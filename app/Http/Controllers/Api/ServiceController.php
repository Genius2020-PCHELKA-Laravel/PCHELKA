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
    use ApiResponseTrait;

    public function index()
    {
        try {
            $service = ServiceResource::collection(Service::paginate($this->paginateNumber));
            return $this->apiResponse($service);
        } catch (\Exception $exception) {
            return $this->generalError();
        }
    }

    public function show($id)
    {
        try {
            $service = Service::find($id);
            if ($service) {
                return $this->apiResponse(new ServiceResource($service));
            }
            return $this->notFoundMassage();
        } catch (\Exception $exception) {
            return $this->generalError();
        }
    }

    public function store(Request $request)
    {
        try {
            $service = Service::create($request->all());
            if ($service) {
                return $this->createdResponse(new ServiceResource($service));
            }
            return $this->generalError();
        } catch (\Exception $exception) {
            return $this->generalError();
        }
    }

    public function update($id, Request $request)
    {
        try {
            $service = Service::find($id);

            if (!$service) {
                return $this->notFoundMassage();
            }
            $service->update($request->all());

            if ($service) {
                return $this->apiResponse(new ServiceResource($service));
            }
            return $this->generalError();
        } catch (\Exception $exception) {
            return $this->generalError();
        }
    }

    public function delete($id, Request $request)
    {
        try {
            $service = Service::find($id);
            if ($service) {
                $service->delete();
                return $this->deleteResponse();
            }
            return $this->notFoundMassage();
        } catch (\Exception $exception) {
            return $this->generalError();
        }
    }

}
