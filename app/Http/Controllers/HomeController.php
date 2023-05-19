<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = DB::table('products')->get();

        return view('welcome', ['products' => $products]);
    }
    
    public function add(Request $request)
    {
        $product = Product::find($request->productId);
        $cart = session()->get('cart', []);
    
        if(isset($cart[$request->productId])) {
            $cart[$request->productId]['quantity']++;
        } else {
            $cart[$request->productId] = [
                'name' => $product->description,
                'price' => $product->precio,
                'quantity' => 1,
                'img' => $product->img_url
            ];
        }
    
        session()->put('cart', $cart);
    
        return response()->json(['status' => 'success', 'message' => 'Product added to cart']);
    }
    
    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);
    
        if(isset($cart[$request->productId])) {
            unset($cart[$request->productId]);
            session()->put('cart', $cart);
        }
    
        return response()->json(['status' => 'success', 'message' => 'Product removed from cart']);
    }
    
    public function update(Request $request)
    {
        $cart = session()->get('cart', []);
    
        if(isset($cart[$request->productId])) {
            $cart[$request->productId]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }
    
        return response()->json(['status' => 'success', 'message' => 'Cart updated']);
    }
}
