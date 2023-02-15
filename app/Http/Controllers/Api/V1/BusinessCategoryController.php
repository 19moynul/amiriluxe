<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Businesscategory;
use Illuminate\Http\Request;

class BusinessCategoryController extends Controller
{
    public function list(){
        $lang = request('lang')?request('lang'):'en';
        $categories = Businesscategory::select('*','name_'.$lang.' as name')->with('products.product')->where('status',1)->get();
        $categoryProduct = [];
        foreach($categories as $category){


            if($category->type==2){
                $childs = [];

                foreach($category->products as $catProduct){
                    $discount_price = optional($catProduct->product)->discount_type=='percent'?optional($catProduct->product)->discount/100*optional($catProduct->product)->price:optional($catProduct->product)->discount;
                    $childs[] = [
                        'id'=>optional($catProduct->product)->id,
                        'name'=>optional($catProduct->product)->name,
                        'unit'=>optional($catProduct->product)->unit->unit,
                        'image'=>optional($catProduct->product)->image_url,
                        'regular_price'=>optional($catProduct->product)->price+$discount_price,
                        'final_price'=>optional($catProduct->product)->price,
                        'discount'=>$discount_price,
                    ];
                }
            }

             $categoryProduct[]=[
                'id'=>$category->id,
                'name'=>$category->name,
                'type'=>$category->type == 1?'banner':'category',
                'childs'=>$childs
            ];


            // $data->childs = $prod->produc
        }
        return $categoryProduct;
    }


}
