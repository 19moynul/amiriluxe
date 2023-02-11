<?php
namespace App\Models;

            use Illuminate\Database\Eloquent\Model; 

            class Brand extends Model 

            { 
protected $table = 'tbl_brand'; public $primaryKey = 'id'; protected $appends = ['image_url'];  public function getImageUrlAttribute(){ if($this->image){ return url('images/'.$this->image); }else{return 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/1024px-No_image_available.svg.png'; }  }  public function scopeFilter($query){ $name_en = request('name_en'); $name_hi = request('name_hi'); $name_mr = request('name_mr'); $status = request('status'); if($name_en){  $query->where('name_en', 'LIKE','%' . $name_en .'%');  }  if($name_hi){  $query->where('name_hi', 'LIKE','%' . $name_hi .'%');  }  if($name_mr){  $query->where('name_mr', 'LIKE','%' . $name_mr .'%');  }  if($status){  $query->where('status', 'LIKE','%' . $status .'%');  }  }
}