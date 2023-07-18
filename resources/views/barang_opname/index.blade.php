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
    <a href="barang-opname/create" class="btn btn-primary mb-3">
        Tambah barang opname
    </a>
    <div class="table-responsive">
        <table class="table  table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Jumlah</th>
                    <th>Deskripsi</th>
                    <th class="text-center" width="150px">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($barang_opname_model as $barang_opname)
                <tr>
                    <td>{{ $barang_opname->tanggal }}</td>
                    <td>{{ $barang_opname->barang->nama }}</td>
                    <td>{{ $barang_opname->jumlah }}</td>
                    <td>{{ $barang_opname->deskripsi }}</td>

                    <td class="text-center">
                        {{-- edit detail pembelian dihapus karena merusak perhitungan stok opname barang --}}
                        <a href="{{ route('barang-opname.edit',$barang_opname->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('barang-opname.destroy',$barang_opname->id) }}" method="POST" class="d-inline">
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
    {{ $barang_opname_model->links() }}
</div>
@endsection