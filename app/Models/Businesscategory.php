<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Businesscategory extends Model
{
    protected $table = 'tbl_business_category';
    public $primaryKey = 'id';
    public $guarded = [];
    public $timestamps = false;
    protected $with = ['module'];
    public function scopeFilter($query)
    {
        $name_en = request('name_en');
        $name_hi = request('name_hi');
        $name_mr = request('name_mr');
        $type = request('type');
        $status = request('status');
        $module_id = request('module_id');
        if ($name_en) {
            $query->where('name_en', 'LIKE', '%' . $name_en . '%');
        }
        if ($name_hi) {
            $query->where('name_hi', 'LIKE', '%' . $name_hi . '%');
        }
        if ($name_mr) {
            $query->where('name_mr', 'LIKE', '%' . $name_mr . '%');
        }
        if ($type) {
            $query->where('type', 'LIKE', '%' . $type . '%');
        }
        if ($status) {
            $query->where('status', 'LIKE', '%' . $status . '%');
        }
        if ($module_id) {
            $query->whereHas('module', function ($query) {
                $query->where('module_name', request('module_id'));
            });
        }
    }
    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id', 'id');
    }
    public function products()
    {
        return $this->hasMany(BusinessCategoryProduct::class, 'category_id', 'id');
    }

    public function banners(){
        return $this->hasMany(BusinessBanner::class, 'category_id', 'id');
    }
}
