<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Storage;

class APIHelper {

    public static function createAPIResponse($data, $status_code, $status_message) {

        $result = [];
        $result["status_code"] = $status_code;
        $result["status_message"] = $status_message;
        $result["data"] = $data;
        return $result;
    }

    public static function errorAPIResponse($data, $status_code)
    {
        $result = [];
        $result["status_code"] = $status_code;
        $result["error"] = $data;
        return $result;
    }


}
