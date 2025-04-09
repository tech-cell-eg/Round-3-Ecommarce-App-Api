<?php

namespace App\Http\Controllers\Api;

use App\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCartRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    use ApiResponse;

    public function index()
    {
        /* 
        ** Get all the products in the cart for all users
        */
        return $this->successResponse(
            CartResource::collection(Cart::where('user_id', Auth::id())->with('product')->get()),
            'Fetched successfully'
        );
    }

    public function store(StoreCartRequest $request)
    {
        /* 
        ** Find if the product is already in the cart and update the quantity for the user
        */

        $cart_item = Cart::where('product_id', $request->product_id)->where('user_id', Auth::id())->first();

        if ($cart_item) {
            $cart_item->quantity += $request->quantity;
            $cart_item->save();
            return $this->successResponse(
                new CartResource($cart_item->load('product')),
                'Product updated successfully'
            );
        }

        $cart_item = Cart::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'quantity' => $request->quantity
        ]);

        return $this->successResponse(
            new CartResource($cart_item->load('product')),
            'Product added to cart successfully'
        );
    }
}
