@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-3">
                <h2>Edit Penjualan</h2>
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
    <form action="{{ route('penjualan.update', $penjualan_model->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="table-responsive">
            <table class=" table table-bordered table-hover table-stripped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Barang</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Jumlah Final</th>
                        <th>Subtotal</th>
                        <th class="text-center" width="150px">Aksi</th>
                    </tr>
                </thead>
                <tbody class="input_fields_wrap">
                    @php
                        $total = 0;
                    @endphp
                    @foreach ($penjualan_detail_model as $penjualan_detail)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <select  name="barang[{{ $loop->iteration }}][id]" class="form-select barang_select">
                                    <option value="">Pilih Barang</option>
                                    @foreach ($barang_model as $barang)
                                        <option value="{{ $barang->id }}" harga="{{$barang->harga_jual}}" stok="{{$barang->stok}}" {{ $barang->id == $penjualan_detail->barang_id ? 'selected' : '' }}>{{ $barang->nama }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" disabled value={{ $penjualan_detail->barang->stok }} class="stok form-control disabled" >
                            </td>
                            <td>
                                <input type="number" disabled  class="harga form-control disabled" name="barang[{{ $loop->iteration }}][harga]" value="{{ $penjualan_detail->barang->harga_jual }}">
                                <input type="hidden" class="harga form-control" name="barang[{{ $loop->iteration }}][harga]" value="{{ $penjualan_detail->barang->harga_jual }}">
                            </td>
                            <td>
                                <input type="number" name="barang[{{ $loop->iteration }}][jumlah]" class="form-control jumlah_input" min=1 placeholder="Jumlah" value="{{ $penjualan_detail->jumlah }}">
                            </td>
                            
                        <td>
                            <select class="form-select satuan_input" required>
                                <option value="">Pilih satuan</option>
                                <option value="1" selected>Lembar</option>
                                <option value="12">Lusin</option>
                                <option value="20">Kodi</option>
                                <option value="144">Gross</option>
                                <option value="500">Rim</option>
                            </select>
                        </td>
                        <td>
                            <input type="number" disabled  class="jumlah_final form-control disabled" name="barang[{{ $loop->iteration }}][jumlah]" value="{{ $penjualan_detail->jumlah }}">
                            <input type="hidden"  class="jumlah_final form-control" name="barang[{{ $loop->iteration }}][jumlah]" value="{{ $penjualan_detail->jumlah }}">
                        </td>
                            <td>
                                @php
                                    $total += $penjualan_detail->jumlah * $penjualan_detail->barang->harga_jual;
                                @endphp
                                <input type="number" disabled  class="subtotal form-control disabled" value="{{ $penjualan_detail->jumlah * $penjualan_detail->barang->harga_jual }}">
                            </td>
                            <td class="text-center">
                                <a href="#" class="btn btn-danger remove_field">Remove</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-12 mb-3">
            <button class="add_field_button btn btn-outline-primary mb-3">Add More Fields</button>
        </div>
        <div class="text-end total_final">
            <h3>Total: {{$total}}</h3>
            <input type="hidden" name="total" value="{{$total}}">
        </div>
        <div class="row mb-3">
            <div class="col-md-12 mb-3">
                {{-- ppn input type number --}}
                <label for="ppn">PPN:</label>
                <input id="ppn" type="number" name="ppn" class="form-control ppn" placeholder="PPN" value="{{$penjualan_model->ppn}}">
            </div>
            <div class="col-md-12 mb-3 grand_total text-center">
                
                <h3>Grand Total: {{$penjualan_model->grand_total}}</h3>
                <input type="hidden" name="grand_total" value="{{$penjualan_model->grand_total}}">
            </div>
            <div class="col-md-12 mb-3">
                <label for="bayar">Bayar:</label>
                <input id="bayar" type="number" name="bayar"  class="form-control" placeholder="Bayar" min=0 value="{{$penjualan_model->bayar}}">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 mb-3">
                <label for="kembalian">Kembalian:</label>
                <input id="kembalian" type="number" name="kembalian" class="form-control" placeholder="Kembalian" min=0 value="{{$penjualan_model->kembalian}}">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a class="btn btn-outline-primary" href="{{ route('penjualan.index') }}"> Back</a>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        max_fields = {{ $barang_model->count() }};
        var wrapper   		= $(".input_fields_wrap"); //Fields wrapper
        var add_button      = $(".add_field_button"); //Add button ID
       
        var x = 1; //initlal text box count
        $(add_button).click(function(e){ //on add input button click
            e.preventDefault();
            if(x <= max_fields){ //max input box allowed
                // if(true) {
                // $(wrapper).append(`
                //     <div class="row mb-3">
                //         <div class="col-md-2 mb-3">
                //             <input type="number" disabled class="form-control disabled" value="${x}">
                //         </div>
                //         <div class="col-md-2 mb-3">
                //             <select  name="barang[][id]" class="form-select">
                //                 <option value="">Pilih Barang</option>
                //                 @foreach ($barang_model as $barang)
                //                     <option value="{{ $barang->id }}" harga="{{$barang->harga_jual}}">{{ $barang->nama }}</option>
                //                 @endforeach
                //             </select>
                //         </div>
                //         <div class="col-md-2 mb-3 ">
                //             <input type="number" disabled value=0 class="jumlah form-control disabled">
                //         </div>
                //         <div class="col-md-2 mb-3">
                //             <input type="text" name="barang[][jumlah]" class="form-control" placeholder="Jumlah">
                //         </div>
                //         <div class="col-md-2 mb-3 ">
                //             <input type="number" disabled value=0 class="sub total form-control disabled">
                //         </div>
                //         <div class="col-md-2 mb-3 ">
                        
                //             <a href="#" class="btn btn-danger remove_field">Remove</a>
                //         </div>
                //     </div>`); //add input box
                //change to table
                $(wrapper).append(`
                    <tr>
                        <td>${x}</td>
                        <td>
                            <select  name="barang[${x}][id]" class="form-select barang_select">
                                <option value="">Pilih Barang</option>
                                @foreach ($barang_model as $barang)
                                    <option value="{{ $barang->id }}" harga="{{$barang->harga_jual}}" stok="{{$barang->stok}}">{{ $barang->nama }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" disabled value=0 class="stok form-control disabled" >
                        </td>
                        <td>
                            <input type="number" disabled value=0 class="harga form-control disabled" name="barang[${x}][harga]">
                            <input type="hidden" value=0 class="harga form-control" name="barang[${x}][harga]">
                        </td>
                        <td>
                            <input type="number" name="barang[${x}][jumlah]" class="form-control jumlah_input" min=1 placeholder="Jumlah" value=1>
                        </td>
                        <td>
                            <select class="form-select satuan_input" required>
                                <option value="">Pilih satuan</option>
                                <option value="1" selected>Lembar</option>
                                <option value="12">Lusin</option>
                                <option value="20">Kodi</option>
                                <option value="144">Gross</option>
                                <option value="500">Rim</option>
                            </select>
                        </td>
                        <td>
                            <input type="number" disabled value=1 class="jumlah_final form-control disabled" name="barang[${x}][jumlah]">
                            <input type="hidden" value=1 class="jumlah_final form-control" name="barang[${x}][jumlah]">
                        </td>
                        <td>
                            <input type="number" disabled value=1 class="subtotal form-control disabled">
                        </td>
                        <td class="text-center">
                            <a href="#" class="btn btn-danger remove_field">Remove</a>
                        </td>
                    </tr>`); //add input box
                x++; //text box increment
            }
            else {
                alert('Maksimal barang adalah ' + max_fields);
            }
        });
       
        $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent().parent().remove(); x--;
            //total_final
            var subtotal = $('.subtotal');
            var subtotal_length = subtotal.length;
            var total = 0;
            for(var i = 0; i < subtotal_length; i++) {
                total += parseInt(subtotal.eq(i).val());
            }
            $('.total_final').html(`
                <h3>Total: ${total}</h3>
                <input type="hidden" name="total" value="${total}">
            `);
            //hitung grand total
            var ppn = $('.ppn').val();
            var grand_total = total + (total * ppn / 100);
            $('.grand_total').html(`
                <h3>Grand Total: ${grand_total}</h3>
                <input type="hidden" name="grand_total" value="${grand_total}">
            `);
        })
        //barang select change
        $(wrapper).on("change",".barang_select", function(e){ //user click on remove text
            e.preventDefault(); 
            var harga = $(this).find(':selected').attr('harga');
            var stok = $(this).find(':selected').attr('stok');
            $(this).parent().parent().find('.harga').val(harga);
            $(this).parent().parent().find('.stok').val(stok);
            $(this).parent().parent().find('.jumlah_input').val(1);
            var jumlah_final = $(this).parent().parent().find('.jumlah_final').val();
            $(this).parent().parent().find('.subtotal').val(harga * jumlah_final);
            $(this).parent().parent().find('.jumlah_input').attr('max',stok);
            
            // tidak boleh ada duplikat barang
            var barang_select = $('.barang_select');
            var barang_select_length = barang_select.length;
            for(var i = 0; i < barang_select_length; i++) {
                if($(this).val() == barang_select.eq(i).val() && i != barang_select.index(this)) {
                    alert('Barang tidak boleh duplikat');
                    $(this).val('');
                    $(this).parent().parent().find('.harga').val(0);
                    $(this).parent().parent().find('.stok').val(0);
                    $(this).parent().parent().find('.jumlah_input').val(0);
                    $(this).parent().parent().find('.subtotal').val(0);
                    $(this).parent().parent().find('.jumlah_input').attr('max',0);
                    break;
                }
            }
            //total_final
            var subtotal = $('.subtotal');
            var subtotal_length = subtotal.length;
            var total = 0;
            for(var i = 0; i < subtotal_length; i++) {
                total += parseInt(subtotal.eq(i).val());
            }
            $('.total_final').html(`
                <h3>Total: ${total}</h3>
                <input type="hidden" name="total" value="${total}">
            `);
            //hitung grand total
            var ppn = $('.ppn').val();
            var grand_total = total + (total * ppn / 100);
            $('.grand_total').html(`
                <h3>Grand Total: ${grand_total}</h3>
                <input type="hidden" name="grand_total" value="${grand_total}">
            `);



        })

        //satuan_input change
        $(wrapper).on("change",".satuan_input", function(e){ //user click on remove text
            e.preventDefault(); 
            var jumlah_input = $(this).parent().parent().find('.jumlah_input').val();
            var satuan_input = $(this).val();
            var jumlah_final = jumlah_input * satuan_input;
            $(this).parent().parent().find('.jumlah_final').val(jumlah_final);
            $(this).parent().parent().find('.subtotal').val(jumlah_final * $(this).parent().parent().find('.harga').val());
            //total_final
            var subtotal = $('.subtotal');
            var subtotal_length = subtotal.length;
            var total = 0;
            for(var i = 0; i < subtotal_length; i++) {
                total += parseInt(subtotal.eq(i).val());
            }
            $('.total_final').html(`
                <h3>Total: ${total}</h3>
                <input type="hidden" name="total" value="${total}">
            `);
            //hitung grand total
            var ppn = $('.ppn').val();
            var grand_total = total + (total * ppn / 100);
            $('.grand_total').html(`
                <h3>Grand Total: ${grand_total}</h3>
                <input type="hidden" name="grand_total" value="${grand_total}">
            `);
            check_kedua_jumlah_input($(this))
        })
        


        //jumlah input change
        $(wrapper).on("change",".jumlah_input", function(e){ //user click on remove text
            e.preventDefault(); 
            var jumlah_input = $(this).val();
            jumlah_input = parseInt(jumlah_input);
            var stok = $(this).parent().parent().find('.stok').val();
            stok = parseInt(stok);
            var satuan_input = $(this).parent().parent().find('.satuan_input').val();
            var jumlah_final = jumlah_input * satuan_input;
            $(this).parent().parent().find('.jumlah_final').val(jumlah_final);
            
            check_kedua_jumlah_input($(this))
            $(this).parent().parent().find('.subtotal').val(jumlah_final * $(this).parent().parent().find('.harga').val());
            //total_final
            var subtotal = $('.subtotal');
            var subtotal_length = subtotal.length;
            var total = 0;
            for(var i = 0; i < subtotal_length; i++) {
                total += parseInt(subtotal.eq(i).val());
            }
            $('.total_final').html(`
                <h3>Total: ${total}</h3>
                <input type="hidden" name="total" value="${total}">
            `);
            //hitung grand total
            var ppn = $('.ppn').val();
            var grand_total = total + (total * ppn / 100);
            $('.grand_total').html(`
                <h3>Grand Total: ${grand_total}</h3>
                <input type="hidden" name="grand_total" value="${grand_total}">
            `);
            check_kedua_jumlah_input($(this))

        })

        //bayar change
        $('#bayar').on("change", function(e){ //user click on remove text
            e.preventDefault(); 
            var bayar = $(this).val();
            var grand_total = $('.grand_total').find('input').val();
            var kembalian = bayar - grand_total;
            $('#kembalian').val(kembalian);
        })

        function check_jumlah_input_lebih_dari_stok(el) {
            var jumlah_input = el.parent().parent().find('.jumlah_input').val();
            jumlah_input = parseInt(jumlah_input);
            var stok = el.parent().parent().find('.stok').val();
            stok = parseInt(stok);
            if(jumlah_input > stok) {
                alert('Jumlah input tidak boleh lebih dari stok');
                el.parent().parent().find('.satuan_input').val(1);
                el.parent().parent().find('.jumlah_input').val(1);
                el.parent().parent().find('.jumlah_final').val(1);
                el.parent().parent().find('.subtotal').val(el.parent().parent().find('.harga').val());
                //reset total dan grand total
                var subtotal = $('.subtotal');
                var subtotal_length = subtotal.length;
                var total = 0;
                for(var i = 0; i < subtotal_length; i++) {
                    total += parseInt(subtotal.eq(i).val());
                }
                $('.total_final').html(`
                    <h3>Total: ${total}</h3>
                    <input type="hidden" name="total" value="${total}">
                `);
                //hitung grand total
                var ppn = $('.ppn').val();
                var grand_total = total + (total * ppn / 100);
                $('.grand_total').html(`
                    <h3>Grand Total: ${grand_total}</h3>
                    <input type="hidden" name="grand_total" value="${grand_total}">
                `);
            }
        }
        function check_jumlah_input_final_lebih_dari_stok(el) {
            var jumlah_final = el.parent().parent().find('.jumlah_final').val();
            jumlah_final = parseInt(jumlah_final);
            var stok = el.parent().parent().find('.stok').val();
            stok = parseInt(stok);
            console.log(jumlah_final, stok)
            if(jumlah_final > stok) {
                alert('Jumlah input final tidak boleh lebih dari stok');
                //kembalikan satuan ke lembar
                el.parent().parent().find('.satuan_input').val(1);
                el.parent().parent().find('.jumlah_input').val(1);
                el.parent().parent().find('.jumlah_final').val(1);
                el.parent().parent().find('.subtotal').val(el.parent().parent().find('.harga').val());
                //reset total dan grand total
                var subtotal = $('.subtotal');
                var subtotal_length = subtotal.length;
                var total = 0;
                for(var i = 0; i < subtotal_length; i++) {
                    total += parseInt(subtotal.eq(i).val());
                }
                $('.total_final').html(`
                    <h3>Total: ${total}</h3>
                    <input type="hidden" name="total" value="${total}">
                `);
                //hitung grand total
                var ppn = $('.ppn').val();
                var grand_total = total + (total * ppn / 100);
                $('.grand_total').html(`
                    <h3>Grand Total: ${grand_total}</h3>
                    <input type="hidden" name="grand_total" value="${grand_total}">
                `);
                
            }
        }

        function check_kedua_jumlah_input(el) {
            check_jumlah_input_lebih_dari_stok(el);
            check_jumlah_input_final_lebih_dari_stok(el);
        }
        //handle ppn change
        $('.ppn').on("change", function(e){ //user click on remove text
            e.preventDefault(); 
            var ppn = $(this).val();
            var total = $('.total_final').find('input').val();
            var grand_total = parseInt(total) + (parseInt(total) * parseInt(ppn) / 100);
            $('.grand_total').html(`
                <h3>Grand Total: ${grand_total}</h3>
                <input type="hidden" name="grand_total" value="${grand_total}">
            `);
        })
        
        //barang atau jumlah ketika ganti salah satu input maka akan mengubah total
         
    });
</script>
@endsection