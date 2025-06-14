<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalesOrderRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\SalesOrder;
use App\Models\SalesOrderItem;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;



class SalesOrderController extends Controller
{

    public function index()
    {
        $sales = SalesOrder::get();
        return view('sales_orders.list',compact('sales'));
    }


    public function create()
    {
        $products = Product::all();
        return view('sales_orders.create', compact('products'));
    }

    public function store(SalesOrderRequest $request)
    {

        $order = new SalesOrder();
        $order->order_number = 'SO-' . strtoupper(Str::random(6));
        $order->total = 0; // Temporary, will update after
        $order->save();

        $total = 0;

        foreach ($request->products as $item) {
            $product = Product::findOrFail($item['product_id']);

            // Reduce inventory
            if ($product->quantity < $item['quantity']) {
                return redirect()->back()->with('error', "Not enough stock for product: {$product->name}");
            }
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

        return redirect()->route('sales_orders.show', $order->id)->with('success', 'Sales order created.');
    }

    public function show($id)
    {
        $order = SalesOrder::with('items.product')->findOrFail($id);
        return view('sales_orders.show', compact('order'));
    }

    public function exportPDF($id)
    {
        $order = SalesOrder::with('items.product')->findOrFail($id);
        $pdf = Pdf::loadView('sales_orders.pdf', compact('order'));
        return $pdf->download("invoice_{$order->order_number}.pdf");
    }

    public function delete($id)
    {

        SalesOrderItem::where('sales_order_id',$id)->delete();

        $sales = SalesOrder::findOrFail($id);
        $sales->delete();

        return redirect()->route('sales_orders.index')->with('success', 'Sales Order deleted successfully.');
    }

}
