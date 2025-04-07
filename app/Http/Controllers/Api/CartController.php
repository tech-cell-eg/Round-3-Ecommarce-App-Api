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

    public function index(Request $request)
    {
        /* 
        ** Get all the products in the cart for all users
        ** dont foget to replace $request->user_id with Auth::id() when using authentication
        */
        return $this->successResponse(
            CartResource::collection(Cart::where('user_id', $request->user_id)->with('product')->get()),
            'Fetched successfully'
        );
    }

    public function store(StoreCartRequest $request)
    {
        /* 
        ** Find if the product is already in the cart and update the quantity for the user
        ** and dont foget to replace $request->user_id with Auth::id() when using authentication
        */

        $product = Cart::where('product_id', $request->product_id)->where('user_id', $request->user_id)->first();

        if ($product) {
            $product->quantity += $request->quantity;
            $product->save();
            return $this->successResponse($product, 'Product updated successfully');
        }

        $cart = Cart::create([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity
        ]);

        return $this->successResponse($cart, 'Product added to cart successfully');
    }
}
