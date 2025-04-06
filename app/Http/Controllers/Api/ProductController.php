<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Product::with('ingredients')->get(),
            'success' => true
        ]);
    }

    public function show($id)
    {
        $product = Product::with('ingredients')->findOrFail($id);
        return response()->json([
            'data' => $product,
            'success' => true
        ]);
    }
}
