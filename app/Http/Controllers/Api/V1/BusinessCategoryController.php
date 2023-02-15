<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Businesscategory;
use Illuminate\Http\Request;

class BusinessCategoryController extends Controller
{
    public function list(){
        $data = Businesscategory::with('childs.product')->where('status',1)->get();
        return $data
    }


}
