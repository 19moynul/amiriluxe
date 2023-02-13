<?php

            namespace App\Http\Requests;

            use Illuminate\Foundation\Http\FormRequest;

            class BusinesscategoryRequest extends FormRequest

            { 
public function authorize() { return true; } public function rules() {  return [  'name_en' => 'required', 'module_id' => 'required', 'type' => 'required', ];  }
}