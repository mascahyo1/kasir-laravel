<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pembelian as pembelianModel;
use App\Models\pembelian_detail as pembelian_detailModel;
use App\Models\barang as barangModel;

class pembelian_detail extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $pembelian_id = request()->get('pembelian_id');
        $pembelian_detail_model = pembelian_detailModel::where('pembelian_id', $pembelian_id)->get();
        return view('pembelian_detail.index', ['pembelian_detail_model' => $pembelian_detail_model, 'pembelian_id' => $pembelian_id]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $pembelian_id = request()->get('pembelian_id');
        $barang_model = barangModel::orderBy('id','desc')->get();

        return view('pembelian_detail.create', ['barang_model' => $barang_model, 'pembelian_id' => $pembelian_id]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $pembelian_id = $request->get('pembelian_id');
        $request->validate([
            'pembelian_id' => ['required','exists:App\Models\pembelian,id'],
            'barang_id' => ['required','exists:App\Models\barang,id'],
            'jumlah' => ['required','numeric'],
        ]);
        pembelian_detailModel::create($request->except(['_token', '_method']));
        //ubah barang stok
        $barang_model = barangModel::find($request->get('barang_id'));
        $barang_model->stok += $request->get('jumlah');
        $barang_model->save();
        // ubah pembelian total dan grand_total
        $pembelian_model = pembelianModel::find($pembelian_id);
        //get pembelian detail
        $pembelian_detail_model = pembelian_detailModel::where('pembelian_id', $pembelian_id)->get();
        $total = 0;
        foreach($pembelian_detail_model as $p) {
            $total += $p->jumlah * $p->harga;
        }
        $pembelian_model->total = $total;
        $pembelian_model->grand_total = $total + ($total * $pembelian_model->ppn / 100);
        $pembelian_model->save();
        
        return redirect()->route('pembelian-detail.index', ['pembelian_id' => $pembelian_id])->with('success','pembelian_detail berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id_pembelian, $id_pembelian_detail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_pembelian_detail)
    {
        //
        $pembelian_detail_model = pembelian_detailModel::find($id_pembelian_detail);
        $barang_model = barangModel::orderBy('id','desc')->get();
        $pembelian_id = request()->get('pembelian_id');
        return view('pembelian_detail.edit', ['pembelian_detail_model' => $pembelian_detail_model, 'barang_model' => $barang_model, 'pembelian_id' => $pembelian_id]);


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_pembelian_detail)
    {
        //
        $barang_model = barangModel::find($request->get('barang_id'));
        $request->validate([
            // 'pembelian_id' => ['required','exists:App\Models\pembelian,id'],
            'barang_id' => ['required','exists:App\Models\barang,id'],
            'jumlah' => ['required','numeric'],
        ]);
        $pembelian_detail = pembelian_detailModel::where('id', $id_pembelian_detail)->first();
        $jumlah_sebelum_update = $pembelian_detail->jumlah;
        $pembelian_detail->update($request->except(['_token', '_method', 'pembelian_id']));
        //ubah barang stok
        $barang_model->stok += $jumlah_sebelum_update;
        $barang_model->stok -= $request->get('jumlah');
        //ubah pembelian total dan grand_total
        $pembelian_model = pembelianModel::find($pembelian_detail->pembelian_id);
        //get pembelian detail
        $pembelian_detail_model = pembelian_detailModel::where('pembelian_id', $pembelian_detail->pembelian_id)->get();
        $total = 0;
        foreach($pembelian_detail_model as $p) {
            $total += $p->jumlah * $p->harga;
        }
        $pembelian_model->total = $total;
        $pembelian_model->grand_total = $total + ($total * $pembelian_model->ppn / 100);
        $pembelian_model->save();

        $barang_model->save();
        return redirect()->route('pembelian-detail.index', ['pembelian_id' => $pembelian_detail->pembelian_id])->with('success','pembelian_detail berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_pembelian_detail)
    {
        //
        $pembelian_detail_model = pembelian_detailModel::find($id_pembelian_detail);
        $id_pembelian = $pembelian_detail_model->pembelian_id;
        if(!$pembelian_detail_model) {
            return redirect()->route('pembelian-detail.index', ['pembelian_id' => $id_pembelian])
            ->with('error','pembelian_detail tidak ditemukan');
        }
        if($pembelian_detail_model->delete()) {
            //ubah barang stok
            $barang_model = barangModel::find($pembelian_detail_model->barang_id);
            $barang_model->stok -= $pembelian_detail_model->jumlah;
            $barang_model->save();
            //ubah pembelian total dan grand_total
            $pembelian_model = pembelianModel::find($id_pembelian);
            //get pembelian detail
            $pembelian_detail_model = pembelian_detailModel::where('pembelian_id', $id_pembelian)->get();
            $total = 0;
            foreach($pembelian_detail_model as $p) {
                $total += $p->jumlah * $p->harga;
            }
            $pembelian_model->total = $total;
            $pembelian_model->grand_total = $total + ($total * $pembelian_model->ppn / 100);
            $pembelian_model->save();
            
            return redirect()->route('pembelian-detail.index', ['pembelian_id' => $id_pembelian])
            ->with('success','pembelian_detail berhasil dihapus');
        }
        
        return redirect()->route('pembelian-detail.index', ['pembelian_id' => $id_pembelian])
        ->with('error','pembelian_detail gagal dihapus');


    }
}
