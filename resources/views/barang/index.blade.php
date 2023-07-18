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
    <a href="barang/create" class="btn btn-primary mb-3">
        Tambah barang
    </a>
    <div class="table-responsive">
        <table class="table  table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Supplier</th>
                    <th>Stok</th>
                    <th>Harga Jual (per lembar)</th>
                    <th class="text-center" width="150px">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($barang_model as $barang)
                <tr>
                    <td>{{ $barang->nama }}</td>
                    <td>{{ $barang->supplier->nama }}</td>
                    <td>{{ $barang->stok }}</td>
                    <td>{{ $barang->harga_jual }}</td>
                    <td class="text-end">
                        <a href="{{ route('barang.edit',$barang->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('barang.destroy',$barang->id) }}" method="POST" class="d-inline">
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
    {{ $barang_model->links() }}
</div>
@endsection