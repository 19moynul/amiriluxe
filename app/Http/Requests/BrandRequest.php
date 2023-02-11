<?php

            namespace App\Http\Requests;

            use Illuminate\Foundation\Http\FormRequest;

            class BrandRequest extends FormRequest

            { 
public function authorize() { return true; } public function rules() { if (Request()->has('id')) { return [  'name_en' => 'required', 'status' => 'required', ];  }else{  return [  'name_en' => 'required', 'image' => 'required', 'status' => 'required', ];  }  }
}