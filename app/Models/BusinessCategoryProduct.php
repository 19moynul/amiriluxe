<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessCategoryProduct extends Model
{
    use HasFactory;
    protected $table = 'tbl_business_category_to_product';
    public $guarded = [];
    public $timestamps=false;

    public function product(){
        return $this->hasMany(Item::class,'id','product_id')->select('id','name','price','discount','discount_type');
    }
}
