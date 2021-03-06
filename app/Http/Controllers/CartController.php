<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{

    public function index()
    {
        $cart = session()->has('cart') ? (session()->get('cart')) : [];

        return view('cart', compact('cart'));
    }

    public function add(Request $request)
    {
        $product = $request->get('product');

        if(session()->has('cart')){

            session()->push('cart', $product);

        }
        else{

            $products[] = $product;

            session()->put('cart', $products);

        }

        flash('Produto adicionado no carrinho!')->success();
        return redirect()->route('product.single', ['slug' => $product['slug']]);

    }

    public function remove($slug)
    {
        if(!session()->has('cart')){
            return redirect()->route('cart.index');
        }
        else{
            $products = session()->get('cart');

            $products = array_filter($products, function($line) use($slug){
                return $line['slug'] != $slug;
            });

            session()->put('cart', $products);
            return redirect()->route('cart.index');
        }
    }

    public function cancel()
    {
       session()->forget('cart');

       flash('Desistencia da compra realizada com sucesso!')->success();
       return redirect()->route('cart.index');
    }
}
