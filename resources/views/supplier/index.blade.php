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
    <a href="supplier/create" class="btn btn-primary mb-3">
        Tambah Supplier
    </a>
    <div class="table-responsive">
        <table class="table  table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th class="text-center" width="150px">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($supplier_model as $supplier)
                <tr>
                    <td>{{ $supplier->nama }}</td>
                    <td>{{ $supplier->alamat }}</td>
                    <td>{{ $supplier->telepon }}</td>
                    <td class="text-end">
                        <a href="{{ route('supplier.edit',$supplier->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('supplier.destroy',$supplier->id) }}" method="POST" class="d-inline">
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
    {{ $supplier_model->links() }}
</div>
@endsection