@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-3">
                <h2>Add pengaturan</h2>
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
       
    <form action="{{ route('pengaturan.store') }}" method="POST">
        @csrf
      
         <div class="row">
            <div class="col-md-12 mb-3">
                <label for="nama">Nama:</label>
                <input id="nama" type="text" name="nama" class="form-control" placeholder="Nama">
            </div>
            <div class="col-md-12 mb-3">
                <label for="nilai">Nilai:</label>
                <input id="nilai" type="number" name="nilai" class="form-control" placeholder="nilai">
            </div>
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a class="btn btn-outline-primary" href="{{ route('pengaturan.index') }}"> Back</a>
            </div>
        </div>
       
    </form>
</div>
@endsection