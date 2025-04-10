<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponse;

    public function index()
    {
        return $this->successResponse(
            ProductResource::collection(Product::with('ingredients')->get()),
            'Fetched successfully'
        );
    }

    public function show($id)
    {
        $product = Product::with('ingredients')->find($id);
        
        if (! $product) {
            return $this->errorResponse('Product not found', 404);
        }

        return $this->successResponse(
            new  ProductResource($product),
            'Fetched successfully'
        );
    }
}
