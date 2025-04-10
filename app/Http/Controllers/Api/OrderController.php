<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $orders = Order::where('user_id', Auth::id() ?? '')
            ->with('payment')
            ->paginate(5);

        return $this->successResponse(OrderResource::collection($orders), 'Fetched successfully');
    }
    public function show($id)
    {
        $order = Order::with(['payment', 'orderProducts'])
            ->where('user_id', Auth::id() ?? '')
            ->where('id', $id)
            ->first();

        if (! $order) {
            return $this->errorResponse('Order not found', 404);
        }

        return $this->successResponse(new OrderResource($order), 'Fetched successfully');
    }
}
