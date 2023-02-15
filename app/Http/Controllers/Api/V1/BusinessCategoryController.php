<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Businesscategory;
use App\Models\BusinessCategoryProduct;
use Illuminate\Http\Request;

class BusinessCategoryController extends Controller
{
    public function list(){
        $lang = request('lang')?request('lang'):'en';
        $categories = Businesscategory::select('*','name_'.$lang.' as name')->with('products.product')->where('status',1)->where('module_id',request()->header('moduleId'))->orderBy('sort','asc')->get();
        $categoryProduct = [];
        foreach($categories as $category){
            if($category->type==2){
                $childs = [];

                foreach($category->products as $catProduct){
                    $discount_type = optional($catProduct->product)->discount_type;
                    $discount = optional($catProduct->product)->discount;
                    $discount_price = $discount_type=='percent'?$discount/100*optional($catProduct->product)->price:$discount;
                    $childs[] = [
                        'id'=>optional($catProduct->product)->id,
                        'name'=>optional($catProduct->product)->name,
                        'unit'=>optional($catProduct->product->unit)->unit,
                        'image'=>optional($catProduct->product)->image_url,
                        'regular_price'=>optional($catProduct->product)->price+$discount_price,
                        'final_price'=>optional($catProduct->product)->price,
                        'discount'=>$discount_type == 'percent'?$discount_price.'%':$discount_price,
                    ];
                }
            }else{
                $childs=[];
                $childs = $category->banners;
            }

             $categoryProduct[]=[
                'id'=>$category->id,
                'name'=>$category->name,
                'type'=>$category->type == 1?'banner':'category',
                'childs'=>$childs
            ];


            // $data->childs = $prod->produc
        }

        $brands  = Brand::select('id','name_'.$lang,'image')->where('status',1)->orderBy('id','desc')->get();


        return response()->json(['categories'=>$categoryProduct,'brands'=>$brands]);
    }


    public function categoryProducts($category_id){
        $categoryProducts = BusinessCategoryProduct::with('product')->where('category_id',$category_id)->orderBy('id','desc')->get();
        $data = [];
        foreach($categoryProducts as $catProduct){
            $discount_type = optional($catProduct->product)->discount_type;
            $discount = optional($catProduct->product)->discount;
            $discount_price = $discount_type=='percent'?$discount/100*optional($catProduct->product)->price:$discount;
            $data[] = [
                'id'=>optional($catProduct->product)->id,
                'name'=>optional($catProduct->product)->name,
                'unit'=>optional($catProduct->product->unit)->unit,
                'image'=>optional($catProduct->product)->image_url,
                'regular_price'=>optional($catProduct->product)->price+$discount_price,
                'final_price'=>optional($catProduct->product)->price,
                'discount'=>$discount_type == 'percent'?$discount_price.'%':$discount_price,
            ];
        }


        return response()->json(['data'=>$data]);
    }


}
