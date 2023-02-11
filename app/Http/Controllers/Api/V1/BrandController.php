<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Product;

class BrandController extends Controller
{
    public function list(){
        $lang = request('lang')?request('lang'):'en';
        $data  = Brand::select('id','name_'.$lang.' as name','image')->where('status',1)->orderBy('id','desc')->limit(10)->get();
        return response()->json(['data'=>$data],200);
    }

    public function allBrands(){
        $lang = request('lang')?request('lang'):'en';
        $data  = Brand::select('id','name_'.$lang,'image')->where('status',1)->orderBy('id','desc')->get();
        return response()->json(['data'=>$data],200);
    }


    public function brandProducts($brand_id){
        $lang = request('lang')?request('lang'):'en';
        $brandInfo = Brand::select('id','name_'.$lang,'image')->where('id',$brand_id)->first();
        $products = Item::select(DB::raw('items.id,items.name,items.image,items.price,units.unit,discount,discount_type'))
        ->where('brand_id',$brand_id)
        ->leftjoin('units','units.id','=','items.unit_id')
        ->get();

        $data=[];
        foreach($products as $product){
            $discount_price = $product->discount_type=='percent'?$product->discount/100*$product->price:$product->discount;
            $data[]=[
                'id'=>$product->id,
                'name'=>$product->name,
                'image'=>$product->image_url,
                'regular_price'=>$product->price+$discount_price,
                'final_price'=>$product->price,
                'discount'=>$discount_price,
                'unit'=>$product->unit,

            ];
        }

        return response()->json(['brandInfo'=>$brandInfo,'products'=>$data],200);
    }
}
