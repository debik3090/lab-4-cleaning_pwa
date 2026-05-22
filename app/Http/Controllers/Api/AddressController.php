<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $addresses = Address::where('user_id', $user->id)->get();

        return AddressResource::collection($addresses);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'city'       => 'required|string|max:100',
            'street'     => 'required|string|max:150',
            'house'      => 'required|string|max:50',
            'apartment'  => 'nullable|string|max:50',
            'comment'    => 'nullable|string|max:255',
            'is_default' => 'boolean',
        ]);

        $data['user_id'] = $user->id;

        if (!empty($data['is_default'])) {
            Address::where('user_id', $user->id)->update(['is_default' => 0]);
        }

        $address = Address::create($data);

        return new AddressResource($address);
    }
}

