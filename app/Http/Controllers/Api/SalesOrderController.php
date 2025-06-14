<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SalesOrder;
use App\Models\SalesOrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SalesOrderController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'products' => 'required|array|min:1',
                'products.*.product_id' => 'required|exists:products,id',
                'products.*.quantity' => 'required|integer|min:1',
            ];

            $messages = [
                'products.required' => 'Please add at least one product.',
                'products.*.product_id.required' => 'Product is required.',
                'products.*.product_id.exists' => 'One or more selected products are invalid.',
                'products.*.quantity.required' => 'Please enter quantity for all products.',
                'products.*.quantity.integer' => 'Quantity must be a number.',
                'products.*.quantity.min' => 'Quantity must be at least 1.',
            ];
           $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }
            $validated = $validator->validated();
            $order = new SalesOrder();
            $order->order_number = 'SO-' . strtoupper(Str::random(6));
            $order->total = 0; // Will be updated later
            $order->save();
            $total = 0;
            foreach ($validated['products'] as $item) {
                $product = Product::find($item['product_id']);
                if ($product->quantity < $item['quantity']) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => "Not enough stock for product: {$product->name}",
                    ], 400);
                }
                // Update inventory
                $product->quantity -= $item['quantity'];
                $product->save();
                $subtotal = $item['quantity'] * $product->price;
                $total += $subtotal;
                SalesOrderItem::create([
                    'sales_order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'subtotal' => $subtotal,
                ]);
            }
            $order->total = $total;
            $order->save();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Sales order created successfully.',
                'data' => $order->load('items.product'),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function show($id)
    {
        $order = SalesOrder::find($id);
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Sales order not found.',
            ], 404);
        }
        $salesorders = SalesOrder::with('items.product')->find($id);
        return response()->json([
            'success' => true,
            'data' => $salesorders,
        ]);
    }

}
