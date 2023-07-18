@extends('layouts.app')
@section('content')
<div class="container">
    
    @if ($message = Session::get('success'))
        <div class="alert alert-success mb-3">
            <p>{{ $message }}</p>
        </div>
    @endif
    @if ($message = Session::get('error'))
        <div class="alert alert-danger mb-3">
            <p>{{ $message }}</p>
        </div>
    @endif
    <a href="user/create" class="btn btn-primary mb-3">
        Tambah user
    </a>
    <div class="table-responsive">
        <table class="table  table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th class="text-center" width="150px">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($user_model as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td class="text-end">
                        <a href="{{ route('user.edit',$user->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('user.destroy',$user->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{ $user_model->links() }}
</div>
@endsection