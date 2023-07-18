@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-3">
                <h2>Add barang Opname</h2>
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
       
    <form action="{{ route('barang-opname.store') }}" method="POST">
        @csrf
      
         <div class="row">
            <div class="col-md-12 mb-3">
                <label for="barang_id">barang:</label>
                <select id="barang_id" name="barang_id" class="form-control">
                    <option value="">Pilih barang</option>
                    @foreach ($barang_model as $barang)
                        <option value="{{ $barang->id }}">{{ $barang->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-12 mb-3">
                <label for="tanggal">tanggal:</label>
                <input id="tanggal" type="date" name="tanggal" class="form-control" placeholder="tanggal">
            </div>
            <div class="col-md-12 mb-3">
                <label for="jumlah">jumlah:</label>
                <input type="number" id="jumlah" class="form-control" name="jumlah" placeholder="jumlah">
            </div>
            <div class="col-md-12 mb-3">
                <label for="deskripsi">deskripsi:</label>
                <textarea id="deskripsi" class="form-control" style="height:150px" name="deskripsi" placeholder="deskripsi"></textarea>
            </div>
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a class="btn btn-outline-primary" href="{{ route('barang.index') }}"> Back</a>
            </div>
        </div>
       
    </form>
</div>
@endsection