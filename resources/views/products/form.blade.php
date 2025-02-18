@extends('layouts.layout')

@section('title', isset($product) ? 'Edit Produk' : 'Tambah Produk')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">{{ isset($product) ? 'Edit Produk' : 'Tambah Produk' }}</h2>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}" method="POST">
            @csrf
            @if(isset($product))
                @method('PUT')
            @endif
            
            <div class="mb-3">
                <label for="produk" class="form-label">Nama Produk</label>
                <input type="text" name="produk" class="form-control" value="{{ old('produk', $product->produk ?? '') }}" required>
            </div>
            
            <div class="mb-3">
                <label for="stok" class="form-label">Stok</label>
                <input type="number" name="stok" class="form-control" value="{{ old('stok', $product->stok ?? '') }}" required>
            </div>
            
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" name="harga" class="form-control" value="{{ old('harga', $product->harga ?? '') }}" required>
            </div>
            
            <button type="submit" class="btn btn-success">{{ isset($product) ? 'Update' : 'Simpan' }}</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
