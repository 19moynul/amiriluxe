<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Businesscategory;
use App\Models\Item;
use App\Models\Store;
use Hamcrest\Arrays\IsArray;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function list(){
        $moduleId = request()->header('moduleId');
        $zoneId = request()->header('zoneId');
        $interest = request('interest');
        $brands = Brand::select('id','name_en','image')->where('status',1)->get();

        $items = Item::hasStore();

        if($interest){
            $interest = is_array($interest)?$interest:json_decode($interest);
            $items = $items->whereIn('category_id',$interest);
        }else{
            $items = $items->orderBy('avg_rating','desc')->orderBy('rating_count','desc');
        }

        $items  = $items->where('module_id',$moduleId)->inRandomOrder()->get()->take(15);

        $data = [];

        foreach($items as $item){
            $data[] = Helpers::product_data_formatting($item, false, false, app()->getLocale());
        }

        $popularProducts = Item::hasStore()->popular()->module($moduleId)->get()->take(15);

        $popular = [];
        foreach($popularProducts as $item){
            $data[] = Helpers::product_data_formatting($item, false, false, app()->getLocale());
        }


        $stores = Store::select('id','name','logo')->where('status',1);
        if($zoneId){
            $stores = $stores->where('zone_id',$zoneId);
        }
        // $stores = $stores->inRandomOrder()->get()->take(16);
        $banners = Businesscategory::with('banners:category_id,image')->where('type',1)->where('module_id',$moduleId)->get();
        $bannersData = [];
        foreach($banners as $banner){
            $bans = [];
            foreach($banner->banners as $banner){
                $bans[] = [
                        'image'=>$banner->image_url,
                        "name"=>null,
                        "description"=>null,
                        "image"=>null,
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
                        "unit"=>null
                    ];
            }
            $bannersData[] = [
                'name'=>$banner->name_en,
                'banners'=>$bans
            ];
        }

        return response()->json(['brands'=>$brands,'for_you'=>$data,'popular'=>$popular,'banners'=>$bannersData]);

    }


    public function getRelatedProducts(){
        $moduleId = request()->header('moduleId');
        $interest = request('interest');

        if(!$interest){
            return response()->json(['status'=>409,'message'=>'interest is required']);
        }

        $items = Item::hasStore();
        if($interest){
            $interest = is_array($interest)?$interest:json_decode($interest);
            $items = $items->whereIn('category_id',$interest);
        }else{
            $items = $items->orderBy('avg_rating','desc')->orderBy('rating_count','desc');
        }

        $items  = $items->where('module_id',$moduleId)->inRandomOrder()->get()->take(15);

        $data = [];

        foreach($items as $item){
            $data[] = Helpers::product_data_formatting($item, false, false, app()->getLocale());
        }

        return response()->json(['data'=>$data],200);
    }
}
