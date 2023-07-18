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
    <a href="penjualan/create" class="btn btn-primary mb-3">
        Tambah Penjualan
    </a>
    <div class="table-responsive">
        <table class="table table-stripped table-hover table-bordered">
            <thead>
                <tr>
                    <th>No Nota</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th class="text-center" width="150px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penjualan_model as $penjualan)
                    <tr>
                        <td>{{ $penjualan->id }}</td>
                        <td>{{ $penjualan->tanggal }}</td>
                        <td>
                            {{ 
                                $penjualan->penjualan_detail->sum(function($item) {
                                    return $item->jumlah * $item->harga;
                                }) 
                            }}
                        </td>
                        <td class="text-end">
                            <a href="{{ route('penjualan.edit',$penjualan->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('penjualan.destroy',$penjualan->id) }}" method="POST" class="d-inline">
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
    {{$penjualan_model->links()}}
</div>
@endsection