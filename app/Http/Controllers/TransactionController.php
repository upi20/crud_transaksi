<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::orderBy('tanggal', 'desc')->get();
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        return view('transactions.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
        ]);

        $transaction = new Transaction();
        $transaction->kode_transaksi = 'TRX' . date('YmdHis');
        $transaction->tanggal = Carbon::parse($request->tanggal);
        $transaction->save();
        
        // generate sesuai dengan konsep
        $transaction->kode_transaksi = $transaction->id . date('Ymd');
        $transaction->save();

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dibuat');
    }

    public function destroy(Transaction $transaction)
    {
        DB::beginTransaction();
        // Kembalikan stok produk dari setiap detail transaksi
        foreach ($transaction->details as $detail) {
            $product = $detail->product;
            $product->stok += $detail->quantity;
            $product->save();
        }

        // Hapus transaksi dan detailnya
        $transaction->details()->delete();
        $transaction->delete();
        DB::commit();

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus dan stok produk dikembalikan.');
    }
}
