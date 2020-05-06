<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Dotenv\Validator;
//use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class ServiceController extends Controller
{
    use apiResponseTrait;

    public function index()
    {
        $service = ServiceResource::collection(Service::paginate($this->paginateNumber));
        return $this->apiResponse($service);
    }

    public function show($id)
    {
        $service = Service::find($id);
        if ($service) {
            return $this->apiResponse(new ServiceResource($service));
        }
        return $this->notFoundMassage();
    }

    public function store(Request $request)
    {
//        $validation = $this->validation($request);
//        if ($validation instanceof Response) {
//            return $validation;
//        }

        $service = Service::create($request->all());
        if ($service) {
            return $this->createdResponse(new ServiceResource($service));
        }
        return $this->generalError();
    }

    public function update($id, Request $request)
    {
//        $validation = $this->validation($request);
//        if ($validation instanceof Response) {
//            return $validation;
//        }

        $service = Service::find($id);

        if (!$service) {
            return $this->notFoundMassage();
        }

        $service->update($request->all());
        if ($service) {
            return $this->apiResponse(new ServiceResource($service));
        }
        return $this->generalError();
    }

    public function delete($id, Request $request)
    {
        $service = Service::find($id);
        if ($service) {
            $service->delete();
            return $this->deleteResponse();
        }
        return $this->notFoundMassage();
    }

    public function validation($request)
    {
        return $this->apiValidation($request, [
            'name' => 'required',
            'details' => 'required',
            'imgPath' => 'required',
        ]);
    }
}
