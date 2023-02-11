<?php

use App\CentralLogics\Helpers;
use Illuminate\Support\Facades\App;

if (! function_exists('translate')) {
    function translate($key, $replace = [])
    {
        if(strpos($key, 'validation.') === 0 || strpos($key, 'passwords.') === 0 || strpos($key, 'pagination.') === 0 || strpos($key, 'order_texts.') === 0) {
            return trans($key, $replace);
        }

        $key = strpos($key, 'messages.') === 0?substr($key,9):$key;
        $local = Helpers::default_lang();
        App::setLocale($local);
        try {
            $lang_array = include(base_path('resources/lang/' . $local . '/messages.php'));
            $processed_key = ucfirst(str_replace('_', ' ', Helpers::remove_invalid_charcaters($key)));

            if (!array_key_exists($key, $lang_array)) {
                $lang_array[$key] = $processed_key;
                $str = "<?php return " . var_export($lang_array, true) . ";";
                file_put_contents(base_path('resources/lang/' . $local . '/messages.php'), $str);
                $result = $processed_key;
            } else {
                $result = trans('messages.' . $key, $replace);
            }
        } catch (\Exception $exception) {
            info($exception);
            $result = trans('messages.' . $key, $replace);
        }

        return $result;
    }

    function serverError(){
        return ['success'=>false,'message'=>'Sorry ! something went wrong with server . please try later'];
    }

    if (!function_exists("getFormInfo")) {
        function getFormInfo($isEditInfo,$others=[])
        {
            if($isEditInfo){
                $info = ['title' => 'EDIT', 'status' => 'success', 'button_name' => 'UPDATE', 'image_class' => 'edit-input'];
            }else{
                $info = ['title' => 'CREATE', 'status' => 'success', 'button_name' => 'CREATE', 'image_class' => ''];
            }
            return array_merge($info,$others);
        }
    }

    function defaultLimit(){
        return 10;
    }
}
