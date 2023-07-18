@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-3">
                <h2>Add pembelian detail</h2>
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
       
    <form action="{{ route('pembelian-detail.store') }}" method="POST">
        @csrf
      
         <div class="row">
            <div class="col-md-12 mb-3">
                <label for="tanggal">barang:</label>
                <select name="barang_id" id="barang_id" class="form-control">
                    <option value="">Pilih barang</option>
                    @foreach ($barang_model as $barang)
                        <option value="{{ $barang->id }}">{{ $barang->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-12 mb-3">
                <label for="jumlah">Jumlah:</label>
                <input id="jumlah" type="text"  class="form-control jumlah" placeholder="Jumlah" required> 
            </div>
            {{-- input satuan dengan select option lembar,lusin,kodi,goss,rim --}}
            <div class="col-md-12 mb-3">
                <label for="satuan">Satuan:</label>
                <select id="satuan" class="form-select" required>
                    <option value="">Pilih satuan</option>
                    <option value="1">Lembar</option>
                    <option value="12">Lusin</option>
                    <option value="20">Kodi</option>
                    <option value="144">Gross</option>
                    <option value="500">Rim</option>
                </select>
            </div>
            {{-- input satuan final disabled --}}
            <div class="col-md-12 mb-3">
                <label for="satuan_final">Satuan Final:</label>
                <input id="satuan_final" type="number" name="satuan_final" class="form-control" placeholder="Satuan Final" disabled>
                {{-- input hidden name jumlah class jumlah_final --}}
                <input type="hidden" name="jumlah" class="jumlah_final">
            </div>

            
            <div class="col-md-12 mb-3">
                <label for="harga">Harga Beli (Per lembar):</label>
                <input id="harga" type="text" name="harga" class="form-control" placeholder="Harga">
                <input type="hidden" name="pembelian_id" value="{{ $pembelian_id }}">
            </div>
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a class="btn btn-outline-primary" href="{{ route('pembelian-detail.index', ['pembelian_id' => $pembelian_id]) }}"> Back</a>
            </div>
        </div>
       
    </form>
</div>
{{-- script untuk menghitung satuan final --}}
<script>
    $(document).ready(function(){
        $(".jumlah").change(function(){
            var jumlah = $(this).val();
            var satuan = $('#satuan').val();
            var satuan_final = jumlah * satuan;
            $('#satuan_final').val(satuan_final);
            $('.jumlah_final').val(satuan_final);
        })
        $('#satuan').change(function(){
            var jumlah = $('.jumlah').val();
            var satuan = $(this).val();
            var satuan_final = jumlah * satuan;
            $('#satuan_final').val(satuan_final);
            $('.jumlah_final').val(satuan_final);
        });
    });
</script>
@endsection