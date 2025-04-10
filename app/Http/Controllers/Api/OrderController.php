<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponser;

class OrderController extends Controller
{
    use ApiResponser;
    public function index()
    {
        $orders = Order::where('user_id', Auth::id() ?? '')
            ->with('payment')
            ->paginate(5);

        return $this->success(OrderResource::collection($orders), 'success');
    }
    public function show($id)
    {
        $order = Order::with(['payment', 'orderProducts'])
            ->where('user_id', Auth::id() ?? '')
            ->where('id', $id)
            ->first();

        if (! $order) {
            return $this->error('Order not found', 404);
        }

        return $this->success(new OrderResource($order), 'success');
    }
}
