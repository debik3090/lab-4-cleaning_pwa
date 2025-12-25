<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $orders = Order::where('user_id', $user->id)
            ->with(['items.service'])
            ->orderByDesc('id')
            ->paginate(10);

        return OrderResource::collection($orders);
    }

    public function show(Request $request, $id)
    {
        $user = $request->user();

        $order = Order::where('user_id', $user->id)
            ->with(['items.service'])
            ->findOrFail($id);

        return new OrderResource($order);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'address_id'   => 'required|integer|exists:addresses,id',
            'time_slot_id' => 'required|integer|exists:time_slots,id',
            'comment'      => 'nullable|string',
            'items'        => 'required|array|min:1',
            'items.*.service_id' => 'required|integer|exists:services,id',
            'items.*.quantity'   => 'required|integer|min:1',
        ]);

        return DB::transaction(function () use ($user, $data) {
            $order = Order::create([
                'user_id'        => $user->id,
                'address_id'     => $data['address_id'],
                'time_slot_id'   => $data['time_slot_id'],
                'status'         => 'pending',
                'total_price'    => 0,
                'payment_method' => null,
                'payment_status' => 'unpaid',
                'comment'        => $data['comment'] ?? null,
            ]);

            $total = 0;

            foreach ($data['items'] as $itemData) {
                $service = Service::findOrFail($itemData['service_id']);

                $price    = $service->base_price;
                $quantity = $itemData['quantity'];
                $subtotal = $price * $quantity;

                OrderItem::create([
                    'order_id'  => $order->id,
                    'service_id'=> $service->id,
                    'quantity'  => $quantity,
                    'price'     => $price,
                    'subtotal'  => $subtotal,
                ]);

                $total += $subtotal;
            }

            $order->update(['total_price' => $total]);

            return new OrderResource(
                $order->load(['items.service'])
            );
        });
    }
}
