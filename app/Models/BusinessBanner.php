<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessBanner extends Model
{
    use HasFactory;
    protected $table = 'tbl_business_banners';
    public $guarded = [];
    public $timestamps=false;
}
