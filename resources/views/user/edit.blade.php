@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-3">
                <h2>Edit user</h2>
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
       
    <form action="{{ route('user.update', $user_model->id) }}" method="POST">
        @csrf
        @method('PUT')

         <div class="row">
            <div class="col-md-12 mb-3">
                <label for="name">name:</label>
                <input id="name" type="text" name="name" class="form-control" placeholder="name" value="{{$user_model->name}}">
            </div>
            <div class="col-md-12 mb-3">
                <label for="email">email:</label>
                <input id="email" type="email" name="email" class="form-control" placeholder="email" value="{{$user_model->email}}">
            </div>
            <div class="col-md-12 mb-3">
                <label for="password">password:</label>
                <input id="password" type="password" name="password" class="form-control" placeholder="password">
            </div>
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a class="btn btn-outline-primary" href="{{ route('user.index') }}"> Back</a>
            </div>
        </div>
       
    </form>
</div>
@endsection