<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Models\Product;
use App\Models\SalesOrder;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $totalSales = SalesOrder::sum('total');
        $totalOrders = SalesOrder::count();
        $lowStockProducts = Product::where('quantity', '<=', 5)->get();

        $monthlySales = SalesOrder::select(
            DB::raw("DATE_FORMAT(created_at, '%b %Y') as month"),
            DB::raw("SUM(total) as total")
        )
        ->groupBy('month')
        ->orderByRaw("MIN(created_at) ASC")
        ->get();

        return view('dashboard', compact(
            'totalSales',
            'totalOrders',
            'lowStockProducts',
            'monthlySales'
        ));
    }

    public function userDefaultAvatar(Request $request, $text)
    {
        $img = Image::canvas(168, 168, '#29348F');
        $text = strtoupper(substr($text, 0, 2));

        $img->text($text, 83, 56, function ($font) {
            $font->file(public_path('font/SF-Pro-Display-Black.ttf')); // Adjust path if necessary
            $font->size(70);
            $font->color('#FFF');
            $font->align('center');
            $font->valign('top');
        });

        $response = response()->make($img->encode('jpg', 75));
        $response->header('Content-Type', 'image/jpeg');

        return $response;
    }
}
