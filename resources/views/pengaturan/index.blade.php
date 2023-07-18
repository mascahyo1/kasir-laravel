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
    <a href="pengaturan/create" class="btn btn-primary mb-3">
        Tambah pengaturan
    </a>
    <div class="table-responsive">
        <table class="table  table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>nilai</th>
                    <th class="text-center" width="150px">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($pengaturan_model as $pengaturan)
                <tr>
                    <td>{{ $pengaturan->nama }}</td>
                    <td>{{ $pengaturan->nilai }}</td>
                    <td class="text-end">
                        <a href="{{ route('pengaturan.edit',$pengaturan->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('pengaturan.destroy',$pengaturan->id) }}" method="POST" class="d-inline">
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
</div>
@endsection