<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang as barangModel;
use App\Models\penjualan as penjualanModel;
use App\Models\penjualan_detail as penjualan_detailModel;
use App\Models\pengaturan as pengaturanModel;

class penjualan extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $penjualanModel = penjualanModel::orderBy('id','desc')->paginate(12);
        return view('penjualan.index', ['penjualan_model' => $penjualanModel]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        $ppn = 0;
        $ppn_model = pengaturanModel::where('nama', 'ppn')->first();
        if($ppn_model) {
            $ppn = $ppn_model->nilai;
        }
        $barang_model = barangModel::orderBy('id','desc')->get();
        return view('penjualan.create', ['barang_model' => $barang_model, 'ppn' => $ppn]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //handle barang array request and insert to db
        //insert penjualan skip validate
        $request->merge(['tanggal' => date('Y-m-d')]);  
        $penjualan = penjualanModel::create($request->except(['_token', '_method', 'barang']));
        $penjualan_id = $penjualan->id;

        //create penjualan detail skip validate
        $barang = $request->barang;
        foreach($barang as $b) {
            $penjualan_detail = [
                'penjualan_id' => $penjualan_id,
                'tanggal' => date('Y-m-d'),
                'barang_id' => $b['id'],
                'jumlah' => $b['jumlah'],
                'harga' => $b['harga'],
            ];
            penjualan_detailModel::create($penjualan_detail);
            //kurangi stok barang
            $barang_model = barangModel::find($b['id']);
            $barang_model->stok -= $b['jumlah'];
            $barang_model->save();
        }
        return redirect()->route('penjualan.index') ->with('success','penjualan berhasil dibuat');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $ppn = 0;
        $ppn_model = pengaturanModel::where('nama', 'ppn')->first();
        if($ppn_model) {
            $ppn = $ppn_model->nilai;
        }
        $penjualan_model = penjualanModel::find($id);
        $penjualan_detail_model = penjualan_detailModel::where('penjualan_id', $id)->get();
        $barang_model = barangModel::orderBy('id','desc')->get();
        return view('penjualan.edit', ['ppn'=> $ppn,'penjualan_model' => $penjualan_model,'penjualan_detail_model' =>  $penjualan_detail_model, 'barang_model' => $barang_model]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $penjualan_model = penjualanModel::find($id);
        $penjualan_detail_model = penjualan_detailModel::where('penjualan_id', $id)->get();
        //hapus semua penjualan detail model
        foreach($penjualan_detail_model as $p) {
            $barang_model = barangModel::find($p->barang_id);
            $barang_model->stok += $p->jumlah;
            $barang_model->save();
        }
        penjualan_detailModel::where('penjualan_id', $id)->delete();
        //reinsert
        $barang = $request->barang;
        foreach($barang as $b) {
            $penjualan_detail = [
                'penjualan_id' => $id,
                'tanggal' => date('Y-m-d'),
                'barang_id' => $b['id'],
                'jumlah' => $b['jumlah'],
                'harga' => $b['harga'],
            ];
            penjualan_detailModel::create($penjualan_detail);
            //kurangi stok barang
            $barang_model = barangModel::find($b['id']);
            $barang_model->stok -= $b['jumlah'];
            $barang_model->save();
        }
        //update penjualan except tanggal
        $penjualan_model->update($request->except(['_token', '_method', 'barang']));
        return redirect()->route('penjualan.index') ->with('success','penjualan berhasil diupdate');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $penjualan_model = penjualanModel::find($id);
        if(!$penjualan_model) {
            return redirect()->route('penjualan.index')
            ->with('error','penjualan tidak ditemukan');
        }
        $penjualan_detail_model = penjualan_detailModel::where('penjualan_id', $id)->get();
        foreach($penjualan_detail_model as $p) {
            $barang_model = barangModel::find($p->barang_id);
            $barang_model->stok += $p->jumlah;
            $barang_model->save();
        }
        //delete penjualan detail
        penjualan_detailModel::where('penjualan_id', $id)->delete();
        if($penjualan_model->delete()) {
            return redirect()->route('penjualan.index')
            ->with('success','penjualan berhasil dihapus');
        }
        return redirect()->route('penjualan.index')->with('error','penjualan gagal dihapus');
    }
}
