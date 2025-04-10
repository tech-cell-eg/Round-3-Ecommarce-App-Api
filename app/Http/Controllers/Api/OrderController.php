<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\PaymentResource;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderProduct;
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

        return $this->success([OrderResource::collection($orders)], 'success');
    }
    public function show($id)
    {
        $order = Order::where('user_id', Auth::id() ?? '')->with('payment')->find($id);

        if (! $order) {
            return $this->error('Order not found', 404);
        }

        $order_products = OrderProduct::where('order_id', $order->id)
            ->with(['product', 'order'])->orderBy('id', 'DESC')->get();

        return $this->success(['order' => new OrderResource($order), 'products' => $order_products], 'success');
    }
}
