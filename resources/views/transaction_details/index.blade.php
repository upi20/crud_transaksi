@extends('layouts.layout')

@section('title', 'Detail Transaksi')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Detail Transaksi - {{ $transaction->kode_transaksi }}</h2>
        <p><strong>Tanggal:</strong> {{ $transaction->tanggal }}</p>
        
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary mb-3">Kembali</a>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Quantity</th>
                    <th>Harga Satuan</th>
                    <th>Total Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $grandTotal = 0; @endphp
                @foreach($details as $detail)
                    @php $total = $detail->quantity * $detail->product->harga; @endphp
                    <tr>
                        <td>{{ $detail->product->produk }}</td>
                        <td>{{ $detail->quantity }}</td>
                        <td>Rp {{ number_format($detail->product->harga, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('transaction_details.destroy', [$transaction->id, $detail->id]) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus produk ini dari transaksi?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @php $grandTotal += $total; @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-end">Grand Total</th>
                    <th>Rp {{ number_format($grandTotal, 0, ',', '.') }}</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
        
        <h4 class="mt-4">Tambah Produk ke Transaksi</h4>
        <form action="{{ route('transaction_details.store', $transaction->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="id_produk" class="form-label">Pilih Produk</label>
                <select name="id_produk" class="form-control" required>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->produk }} (Stok: {{ $product->stok }})</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Jumlah</label>
                <input type="number" name="quantity" class="form-control" min="1" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Produk</button>
        </form>
    </div>
@endsection
