<?php

namespace App\Http\Controllers\Api\V1;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Businesscategory;
use App\Models\BusinessCategoryProduct;
use App\Models\Zone;
use Illuminate\Http\Request;

class BusinessCategoryController extends Controller
{
    public function list(){
        $lang = request('lang')?request('lang'):'en';
        $zoneId = request()->header('zoneId');
        $categories = Businesscategory::select('*','name_'.$lang.' as name')->with('products.product')->where('status',1)->where('module_id',request()->header('moduleId'))->orderBy('sort','asc')->get();
        $categoryProduct = [];
        foreach($categories as $category){
            if($category->type==2){
                $childs = [];
                $allProduct = [];

                foreach($category->products as $catProduct){
                    if($catProduct->product){
                       $childs[] = Helpers::product_data_formatting($catProduct->product, false, false, app()->getLocale(),true);
                        // $allProduct[] = $catProduct->product;
                    }

                    // $discount_type = optional($catProduct->product)->discount_type;
                    // $discount = optional($catProduct->product)->discount;
                    // $discount_price = $discount_type=='percent'?$discount/100*optional($catProduct->product)->price:$discount;
                    // $childs['image'] = [
                    //     'id'=>optional($catProduct->product)->id,
                    //     'name'=>optional($catProduct->product)->name,
                    //     'unit'=>optional($catProduct->product->unit)->unit,
                    //     'image'=>optional($catProduct->product)->image_url,
                    //     'regular_price'=>optional($catProduct->product)->price+$discount_price,
                    //     'final_price'=>optional($catProduct->product)->price,
                    //     'discount'=>$discount_type == 'percent'?$discount_price.'%':$discount_price,
                    // ];
                }
                // return $allProduct;
            }else{
                $childs=[];
                foreach($category->banners as $banner){
                    $childs[] = [
                        'image'=>$banner->image_url,
                        "name"=>null,
                        "description"=>null,
                        "category_id"=>null,
                        "category_ids"=>[],
                        "variations"=>[],
                        "add_ons"=>[],
                        "attributes"=>[],
                        "choice_options"=>[],
                        "price"=>null,
                        "tax"=>null,
                        "tax_type"=>null,
                        "discount"=>null,
                        "discount_type"=>null,
                        "available_time_starts"=>null,
                        "available_time_ends"=>null,
                        "veg"=>null,
                        "status"=>null,
                        "store_id"=>null,
                        "created_at"=>null,
                        "updated_at"=>null,
                        "order_count"=>null,
                        "avg_rating"=>null,
                        "rating_count"=>null,
                        "module_id"=>null,
                        "stock"=>null,
                        "unit_id"=>null,
                        "images"=>[],
                        "food_variations"=>[],
                        "brand_id"=>null,
                        "store_name"=>null,
                        "module_type"=>null,
                        "zone_id"=>null,
                        "store_discount"=>null,
                        "schedule_order"=>null,
                        "unit_type"=>null,
                        "module"=>null,
                        "unit"=>null,
                        "available_date_starts"=>null,
                    ];
                }
                // $childs = $category->banners;
            }


             $categoryProduct[]=[
                'id'=>$category->id,
                'name'=>$category->name,
                'type'=>$category->type == 1?'banner':'category',
                'items'=>$childs
            ];


            // $data->childs = $prod->produc
        }

            // return $allProduct;

        $brands  = Brand::select('id','name_'.$lang,'image')->where('status',1)->orderBy('id','desc')->get();

        $zone_subtitle = null;
        if($zoneId){
            $zoneId = json_decode($zoneId);
            $zone_subtitle = Zone::whereIn('id',$zoneId)->value('subtitle');
        }

        return response()->json(['categories'=>$categoryProduct,'brands'=>$brands,'company_subtitle'=>$zone_subtitle]);
    }


    public function categoryProducts($category_id){
        $categoryProducts = BusinessCategoryProduct::with('product')->where('category_id',$category_id)->orderBy('id','desc')->get();
        $data = [];
        foreach($categoryProducts as $catProduct){
            // $discount_type = optional($catProduct->product)->discount_type;
            // $discount = optional($catProduct->product)->discount;
            // $discount_price = $discount_type=='percent'?$discount/100*optional($catProduct->product)->price:$discount;
            // $data[] = [
            //     'id'=>optional($catProduct->product)->id,
            //     'name'=>optional($catProduct->product)->name,
            //     'unit'=>optional($catProduct->product->unit)->unit,
            //     'image'=>optional($catProduct->product)->image_url,
            //     'regular_price'=>optional($catProduct->product)->price+$discount_price,
            //     'final_price'=>optional($catProduct->product)->price,
            //     'discount'=>$discount_type == 'percent'?$discount_price.'%':$discount_price,
            // ];

            $data[] = Helpers::product_data_formatting($catProduct->product, false, false, app()->getLocale(),true);
        }


        return response()->json(['items'=>$data]);
    }


}
