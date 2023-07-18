@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-3">
                <h2>Add pembelian</h2>
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
       
    <form action="{{ route('pembelian.store') }}" method="POST">
        @csrf
      
         <div class="row">
            <div class="col-md-12 mb-3">
                <label for="tanggal">tanggal:</label>
                <input id="tanggal" type="date" name="tanggal" class="form-control" placeholder="tanggal" value="{{date('Y-m-d')}}">
            </div>
            <div class="col-md-12 mb-3">
                <label for="ppn">PPN:</label>
                <input id="ppn" type="number" name="ppn" class="form-control" placeholder="ppn" value="{{$ppn}}">
            </div>
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a class="btn btn-outline-primary" href="{{ route('pembelian.index') }}"> Back</a>
            </div>
        </div>
       
    </form>
</div>
@endsection