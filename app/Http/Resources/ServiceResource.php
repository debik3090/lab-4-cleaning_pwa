<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::where('is_active', 1)->paginate(10);

        return ServiceResource::collection($services);
    }

    public function show($id)
    {
        $service = Service::where('is_active', 1)->findOrFail($id);

        return new ServiceResource($service);
    }
}
