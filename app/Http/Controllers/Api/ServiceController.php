<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use http\Env\Response;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use apiResponseTrait;

    public function getServices()
    {
        $service = ServiceResource::collection(Service::paginate($this->paginateNumber));
        return $this->apiResponse($service);
    }

    public function getServiceById($id)
    {
        $service = new ServiceResource(Service::find($id));
        if ($service) {
            return $this->apiResponse($service);
        } else {
            return $this->apiResponse(null, "Can't Find Item", 404);
        }
    }
}
