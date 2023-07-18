<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian as PembelianModel;
use App\Models\pengaturan as pengaturanModel;

class pembelian extends Controller
{
    public function index()
    {
        //
        $pembelian_model = PembelianModel::orderBy('id','desc')->paginate(12);
        return view('pembelian.index', ['pembelian_model' => $pembelian_model]);
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
        return view('pembelian.create', ['ppn' => $ppn]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'tanggal' => 'required',
            'ppn' => 'required',
        ]);
        $request->merge(['total' => 0]);
        $request->merge(['grand_total' => 0]);
        PembelianModel::create($request->except(['_token', '_method']));
        return redirect()->route('pembelian.index')
        ->with('success','pembelian berhasil ditambahkan.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return redirect()->route('pembelian-detail.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $pembelian_model = PembelianModel::find($id);
        return view('pembelian.edit', ['pembelian_model' => $pembelian_model]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'tanggal' => 'required',
            'ppn' => 'required',
            // 'alamat' => 'required',
        ]);
        //update total dan grand total
        $pembelian_model = PembelianModel::find($id);
        //get pembelian detail
        $pembelian_detail_model = $pembelian_model->pembelian_detail;
        $total = 0;
        foreach($pembelian_detail_model as $p) {
            $total += $p->harga * $p->jumlah;
        }
        $grand_total = $total + ($total * $request->get('ppn') / 100);
        $request->merge(['total' => $total]);
        $request->merge(['grand_total' => $grand_total]);
        PembelianModel::where('id', $id)->update($request->except(['_token', '_method']));
        return redirect()->route('pembelian.index')
        ->with('success','pembelian berhasil diedit');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $pembelian_detail_model = PembelianModel::with('pembelian_detail')->find($id);
        if(!$pembelian_detail_model) {
            return redirect()->route('pembelian.index')
            ->with('error','pembelian tidak ditemukan');
        }
        if($pembelian_detail_model->pembelian_detail->first()) {
            
            // $pembelian_detail_model->pembelian_detail()->delete();
            return redirect()->route('pembelian.index')
            ->with('error','pembelian tidak bisa dihapus karena masih memiliki pembelian_detail');
        }
        if(PembelianModel::find($id)->delete()) {
            return redirect()->route('pembelian.index')
            ->with('success','pembelian berhasil dihapus');
        }
        else {
            return redirect()->route('pembelian.index')
            ->with('error','pembelian gagal dihapus');
        }
    }

}
