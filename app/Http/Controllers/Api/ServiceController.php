<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // Список услуг
    public function index()
    {
        // Можно просто вернуть все услуги
        return Service::all();
    }

    // Одна услуга
    public function show(int $id)
    {
        $service = Service::findOrFail($id);

        return $service;
    }
}
