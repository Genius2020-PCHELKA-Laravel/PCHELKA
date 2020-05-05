<?php

namespace App\Http\Controllers\Api;

trait ApiResponseTrait
{
    public $paginateNumber =10;


    /*
     * [
     * data => data ,
     * status=> true or false
     * error = > 'Error Massage'
     * ]
     */

    public function apiResponse($data = null, $error = null, $code = 200)
    {
        $array = [
            'data' => $data,
            'status' => in_array($code, $this->successCode()) ? true : false,
            'error' => $error
        ];
        return response($array, $code);
    }

    public function successCode()
    {
        return [
            200, 201, 202
        ];
    }
}
