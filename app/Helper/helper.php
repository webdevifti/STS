<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('admin_logged_in')) {
    function admin_logged_in()
    {
        if(Auth::user()){
            if(Auth::user()->user_type === 'admin'){
                return true;
            }
            return false;
        }
    }
}
if (!function_exists('customer_logged_in')) {
    function customer_logged_in()
    {
        if(Auth::user()){
            if(Auth::user()->user_type === 'customer'){
                return true;
            }
            return false;
        }
    }
}

if (!function_exists('multipleFileUpload')) {
    function multipleFileUpload($request, $path, $name)
    {
        $imagesArr = [];
        if ($request->$name && $request->hasFile($name)) {
            foreach ($request->$name as $image) {
                $extension = $image->getClientOriginalExtension();
                $name = rand(111111, 999999) . '.' . $extension;
                $image->storeAs($path, $name,'public');
                $imagesArr[] = [
                    'img_name' => $name
                ];
            }
            return $imagesArr;
        }
    }
}