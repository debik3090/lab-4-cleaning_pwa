<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PushSubscription;
use Illuminate\Http\Request;

class PushSubscriptionController extends Controller
{
    public function store(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'endpoint'   => 'required|string',
            'public_key' => 'nullable|string',
            'auth_token' => 'nullable|string',
        ]);

        PushSubscription::updateOrCreate(
            [
                'user_id'  => $user?->id,
                'endpoint' => $data['endpoint'],
            ],
            [
                'public_key' => $data['public_key'] ?? null,
                'auth_token' => $data['auth_token'] ?? null,
            ]
        );

        return response()->json(['status' => 'ok'], 201);
    }

    public function destroy(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'endpoint' => 'required|string',
        ]);

        PushSubscription::where('endpoint', $data['endpoint'])
            ->when($user, fn($q) => $q->where('user_id', $user->id))
            ->delete();

        return response()->json(null, 204);
    }
}

