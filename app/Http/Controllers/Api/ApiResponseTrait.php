<?php

namespace App\Http\Controllers\Api;

use http\Env\Request;
use Illuminate\Support\Facades\Validator;

trait ApiResponseTrait
{
    public $paginateNumber = 10;


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

    public function createdResponse($data)
    {
        return $this->apiResponse($data, null, 201);
    }

    public function deleteResponse()
    {
        return $this->apiResponse(true, null, 200);
    }

    public function notFoundMassage()
    {
        return $this->apiResponse(null, "Not found", 404);
    }

    public function generalError()
    {
        return $this->apiResponse(null, "General Error", 404);
    }

    public function apiValidation(Request $request, $array)
    {

        $validate = Validator::make($request->all(), $array);
        if ($validate->fails()) {
            return $this->apiResponse(null, $validate->errors(), 520);
        }
    }
}
