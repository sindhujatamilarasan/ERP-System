<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function list(Request $request)
    {
            try {
                $products = Product::get();
                return response()->json([
                    'success' => true,
                    'data' => [
                        'products' => $products
                    ]
                ], 200);

            } catch (\Exception $e) {
                return $this->sendErrorResponse($e->getMessage(), [], 500);
            }

    }

}
