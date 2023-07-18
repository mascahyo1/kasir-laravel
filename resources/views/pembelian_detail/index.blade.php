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
    <a href="{{ route('pembelian.index') }}" class="btn btn-outline-primary mb-3">
        Kembali
    </a>
    <a href="{{ route('pembelian-detail.create', ['pembelian_id' => $pembelian_id]) }}" class="btn btn-primary mb-3">
        Tambah pembelian detail
    </a>
    @php
        $total = 0;
    @endphp

    <div class="table-responsive">
        <table class="table  table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Barang</th>
                    <th>Jumlah</th>
                    <th>Harga Beli (satuan)</th>
                    <th>Subtotal</th>
                    <th class="text-center" width="150px">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($pembelian_detail_model as $pembelian_detail)
                <tr>
                    <td>{{ $pembelian_detail->barang->nama }}</td>
                    <td>{{ $pembelian_detail->jumlah }}</td>
                    <td>{{ $pembelian_detail->harga }}</td>
                    <td>{{ $pembelian_detail->jumlah * $pembelian_detail->harga }}</td>
                    @php
                        $total += $pembelian_detail->jumlah * $pembelian_detail->harga;
                    @endphp
                    <td class="text-center">
                        {{-- edit detail pembelian dihapus karena merusak perhitungan stok opname barang --}}
                        <a href="{{ route('pembelian-detail.edit',$pembelian_detail->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('pembelian-detail.destroy',$pembelian_detail->id) }}" method="POST" class="d-inline">
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
    <div class="text-end">
        @if ($pembelian_detail_model->count() > 0)
            <h3>Total: {{ $pembelian_detail->pembelian->total }}</h3>
            <h3>PPN: {{ $pembelian_detail->pembelian->ppn }}</h3>
            <h3>Grand Total: {{ $pembelian_detail->pembelian->grand_total }}</h3>
        @endif
    </div>
</div>
@endsection