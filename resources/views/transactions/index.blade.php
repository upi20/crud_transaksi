@extends('layouts.layout')

@section('title', 'Daftar Transaksi')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Daftar Transaksi</h2>
        <a href="{{ route('transactions.create') }}" class="btn btn-primary mb-3">Tambah Transaksi</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kode Transaksi</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->id }}</td>
                        <td>{{ $transaction->kode_transaksi }}</td>
                        <td>{{ $transaction->tanggal }}</td>
                        <td>
                            <a href="{{ route('transaction_details.index', $transaction->id) }}" class="btn btn-info btn-sm">Detail</a>
                            <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus transaksi ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
