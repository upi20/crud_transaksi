<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::orderBy('tanggal', 'desc')->get();
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        return view('transactions.create');
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
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus');
    }
}
