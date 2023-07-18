@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-3">
                <h2>Add Supplier</h2>
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
       
    <form action="{{ route('supplier.store') }}" method="POST">
        @csrf
      
         <div class="row">
            <div class="col-md-12 mb-3">
                <label for="nama">Nama:</label>
                <input id="nama" type="text" name="nama" class="form-control" placeholder="Nama">
            </div>
            <div class="col-md-12 mb-3">
                <label for="telepon">Telepon:</label>
                <input id="telepon" type="text" name="telepon" class="form-control" placeholder="Telepon">
            </div>
            <div class="col-md-12 mb-3">
                <label for="alamat">Alamat:</label>
                <textarea id="alamat" class="form-control" style="height:150px" name="alamat" placeholder="Alamat"></textarea>
            </div>
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a class="btn btn-outline-primary" href="{{ route('supplier.index') }}"> Back</a>
            </div>
        </div>
       
    </form>
</div>
@endsection