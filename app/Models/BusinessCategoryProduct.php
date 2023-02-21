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
        return $this->belongsTo(Item::class,'product_id','id');
    }
}
