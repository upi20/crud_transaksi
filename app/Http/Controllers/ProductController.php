<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'produk' => 'required|unique:products',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|integer|min:0'
        ]);

        $product = new Product();
        $product->produk = $request->produk;
        $product->stok = $request->stok;
        $product->harga = $request->harga;
        $product->save();

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit(Product $product)
    {
        return view('products.form', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'produk' => 'required|unique:products,produk,' . $product->id,
            'stok' => 'required|integer|min:0',
            'harga' => 'required|integer|min:0'
        ]);

        $product->produk = $request->produk;
        $product->stok = $request->stok;
        $product->harga = $request->harga;
        $product->save();

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus');
    }
}
