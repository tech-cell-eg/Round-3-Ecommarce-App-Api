<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(Request $request)
    {
        // Get all the products in the cart for all users
        return response()->json([
            // dont foget to replace $request->user_id with Auth::id() when using authentication
            'data' => Cart::where('user_id', $request->user_id)->with('product')->get(),
            'success' => true
        ]);
    }

    public function store(Request $request)
    {
        // Find if the product is already in the cart and update the quantity for the user
        // and dont foget to replace $request->user_id with Auth::id() when using authentication
        $product = Cart::where('product_id', $request->product_id)->where('user_id', $request->user_id)->first();

        if ($product) {
            $product->quantity += $request->quantity;
            $product->save();
            return response()->json([
                'data' => $product,
                'success' => true
            ]);
        }

        // Create a new cart with validation
        $validated = $request->validate([
            'user_id' => 'required',
            'product_id' => 'required',
            'quantity' => 'required|numeric|min:1',
        ]);

        $cart = Cart::create($validated);

        return response()->json([
            'data' => $cart,
            'success' => true
        ]);
    }
}
