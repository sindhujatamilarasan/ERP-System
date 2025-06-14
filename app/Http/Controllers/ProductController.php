<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $products = Product::where('user_id',$user->id)->get();

        return view('inventory.list',compact('products'));
    }

    public function create()
    {
        return view('inventory.form');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('inventory.form', compact('product'));
    }

    public function store(ProductRequest $request)
    {

        $request['user_id'] =  Auth::user()->id;
        DB::beginTransaction();
        $product = Product::create($request->except('_token'));
        DB::commit();
        if ($product) {
            return redirect()->route('product.index')->with('success', __('messages.sucess_message', ['type'=>'Product']));
        }
        return redirect()->route('product.index')->with('error', __('messages.oop_wrong_message'));
    }

    public function update(ProductRequest $request, $id)
    {
        $product = Product::find($id);
        $data = $request->all();
        if (!$product) {
            return redirect()->route('product.edit')->with('error', __('messages.data_not_found'));
        }

        $product->update($data);
        if ($product) {
            return redirect()->route('product.index')->with('success', __('messages.update_sucess_message', ['type'=>'Product']));
        }

    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product deleted successfully.');
    }



}
