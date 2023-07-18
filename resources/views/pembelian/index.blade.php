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
    <a href="pembelian/create" class="btn btn-primary mb-3">
        Tambah pembelian
    </a>
    <div class="table-responsive">
        <table class="table  table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>No Nota</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>PPN</th>
                    <th>Grand Total</th>
                    <th class="text-center" width="230px">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($pembelian_model as $pembelian)
                <tr>
                    <td>{{ $pembelian->id }}</td>
                    <td>{{ $pembelian->tanggal }}</td>
                    <td>{{ $pembelian->total }}</td>
                    <td>{{ $pembelian->ppn }}</td>
                    <td>{{ $pembelian->grand_total }}</td>
                    <td class="text-end">
                        <a href="{{ route('pembelian-detail.index',['pembelian_id'=> $pembelian->id]) }}" class="btn btn-primary">Detail</a>
                        <a href="{{ route('pembelian.edit',$pembelian->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('pembelian.destroy',$pembelian->id) }}" method="POST" class="d-inline">
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
    {{ $pembelian_model->links() }}
</div>
@endsection