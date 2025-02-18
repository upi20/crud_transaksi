<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use App\Models\Transaction;
use App\Models\Product;

class TransactionDetailController extends Controller
{
    public function index(Transaction $transaction)
    {
        $details = $transaction->details()->with('product')->get();
        return view('transaction_details.index', compact('transaction', 'details'));
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

        // Simpan detail transaksi
        $detail = new TransactionDetail();
        $detail->id_transaksi = $transaction->id;
        $detail->id_produk = $product->id;
        $detail->quantity = $request->quantity;
        $detail->save();

        // Kurangi stok produk
        $product->stok -= $request->quantity;
        $product->save();

        return redirect()->route('transactions.index')->with('success', 'Produk berhasil ditambahkan ke transaksi.');
    }
}
