<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Brand;
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
            $discount_type = $item->discount_type;
            $discount = $item->discount;
            $discount_price = $discount_type=='percent'?$discount/100*$item->price:$discount;
            $data[] = [
                'id'=>$item->id,
                'name'=>$item->name,
                'unit'=>optional($item->unit)->unit,
                'image'=>$item->image_url,
                'regular_price'=>$item->price+$discount_price,
                'final_price'=>$item->price,
                'discount'=>$discount_type == 'percent'?$discount_price.'%':$discount_price,
            ];
        }

        $popularProducts = Item::hasStore()->popular()->module($moduleId)->get()->take(15);

        $popular = [];
        foreach($popularProducts as $item){
            $discount_type = $item->discount_type;
            $discount = $item->discount;
            $discount_price = $discount_type=='percent'?$discount/100*$item->price:$discount;
            $popular[] = [
                'id'=>$item->id,
                'name'=>$item->name,
                'unit'=>optional($item->unit)->unit,
                'image'=>$item->image_url,
                'regular_price'=>$item->price+$discount_price,
                'final_price'=>$item->price,
                'discount'=>$discount_type == 'percent'?$discount_price.'%':$discount_price,
            ];
        }


        $stores = Store::select('id','name','logo')->where('status',1);
        if($zoneId){
            $stores = $stores->where('zone_id',$zoneId);
        }
        $stores = $stores->inRandomOrder()->get()->take(16);

        return response()->json(['brands'=>$brands,'for_you'=>$data,'popular'=>$popular,'stores'=>$stores]);

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
            $discount_type = $item->discount_type;
            $discount = $item->discount;
            $discount_price = $discount_type=='percent'?$discount/100*$item->price:$discount;
            $data[] = [
                'id'=>$item->id,
                'name'=>$item->name,
                'unit'=>optional($item->unit)->unit,
                'image'=>$item->image_url,
                'regular_price'=>$item->price+$discount_price,
                'final_price'=>$item->price,
                'discount'=>$discount_type == 'percent'?$discount_price.'%':$discount_price,
            ];
        }

        return response()->json(['data'=>$data],200);
    }
}
