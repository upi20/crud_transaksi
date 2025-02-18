@extends('layouts.layout')

@section('title', 'Tambah Transaksi')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Tambah Transaksi</h2>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('transactions.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal Transaksi</label>
                <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal') }}" required>
            </div>
            
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
