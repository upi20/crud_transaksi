<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class TransactionDetailController extends Controller
{
    public function index(Transaction $transaction)
    {
        $details = $transaction->details()->with('product')->get();
        $products = Product::all();
        return view('transaction_details.index', compact('transaction', 'details', 'products'));
    }

    public function store(Request $request, Transaction $transaction)
    {
        $request->validate([
            'id_produk' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->id_produk);

        // Cek stok sebelum checkout
        if ($product->stok < $request->quantity) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi untuk produk ini.');
        }

        DB::beginTransaction();
        // Simpan detail transaksi
        $detail = new TransactionDetail();
        $detail->id_transaksi = $transaction->id;
        $detail->id_produk = $product->id;
        $detail->quantity = $request->quantity;
        $detail->save();

        // Kurangi stok produk
        $product->stok -= $request->quantity;
        $product->save();
        DB::commit();

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke transaksi.');
    }

    public function destroy(Transaction $transaction, TransactionDetail $detail)
    {
        DB::beginTransaction();
        // Kembalikan stok produk
        $product = $detail->product;
        $product->stok += $detail->quantity;
        $product->save();

        // Hapus detail transaksi
        $detail->delete();
        DB::commit();

        return redirect()->back()->with('success', 'Produk berhasil dihapus dari transaksi dan stok dikembalikan.');
    }
}
