<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = ['kode_transaksi', 'tanggal'];

    public function details()
    {
        return $this->hasMany(TransactionDetail::class, 'id_transaksi');
    }
}
