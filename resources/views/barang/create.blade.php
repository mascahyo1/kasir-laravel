@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-3">
                <h2>Add barang</h2>
        </div>
    </div>
       
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
       
    <form action="{{ route('barang.store') }}" method="POST">
        @csrf
      
         <div class="row">
            <div class="col-md-12 mb-3">
                <label for="nama">Nama:</label>
                <input id="nama" type="text" name="nama" class="form-control" placeholder="Nama">
            </div>
            <div class="col-md-12 mb-3">
                <label for="telepon">Supplier:</label>
                <select name="supplier_id" id="supplier_id" class="form-select">
                    <option value="" disabled selected>Pilih Supplier</option>
                    @foreach ($supplier_model as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-12 mb-3">
                <label for="stok">Stok:</label>
                <input type="number" id="stok" class="form-control" name="stok" placeholder="stok" min="0">
            </div>
            <div class="col-md-12 mb-3">
                <label for="harga_jual">Harga jual (per lembar):</label>
                <input type="number" id="harga_jual" class="form-control" name="harga_jual" placeholder="harga_jual" min="1">
            </div>
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a class="btn btn-outline-primary" href="{{ route('barang.index') }}"> Back</a>
            </div>
        </div>
       
    </form>
</div>
@endsection