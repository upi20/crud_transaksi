<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionDetail extends Model
{
    use HasFactory;
    protected $fillable = ['id_transaksi', 'id_produk', 'quantity'];
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_produk');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'id_transaksi');
    }
}
