<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang as barangModel;
use App\Models\barang_opname as barang_opnameModel;

class barang_opname extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $barang_opname_model = barang_opnameModel::orderBy('id','desc')->paginate(12);
        return view('barang_opname.index', ['barang_opname_model' => $barang_opname_model]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $barang_model = barangModel::orderBy('id','desc')->get();
        return view('barang_opname.create', ['barang_model' => $barang_model]);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'barang_id' => ['required','exists:App\Models\barang,id'],
            'jumlah' => ['required','numeric'],
        ]);
        barang_opnameModel::create($request->except(['_token', '_method']));
        $id = barang_opnameModel::latest()->first()->id;
        $barang_opname_model = barang_opnameModel::find($id);
        $barang_model = barangModel::find($barang_opname_model->barang_id);
        $barang_model->stok -= $barang_opname_model->jumlah;
        $barang_model->save();
        return redirect()->route('barang-opname.index');
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
        $barang_model = barangModel::orderBy('id','desc')->get();
        $barang_opname_model = barang_opnameModel::find($id);
        return view('barang_opname.edit', ['barang_opname_model' => $barang_opname_model, 'barang_model' => $barang_model]);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $barang_opname_model = barang_opnameModel::find($id);
        $request->validate([
            'barang_id' => ['required','exists:App\Models\barang,id'],
            'jumlah' => ['required','numeric'],
        ]);
        barang_opnameModel::where('id', $id)->update($request->except(['_token', '_method']));
        $barang_model = barangModel::find($barang_opname_model->barang_id);
        $barang_model->stok += $barang_opname_model->jumlah;
        $barang_model->stok -= $request->get('jumlah');
        $barang_model->save();
        return redirect()->route('barang-opname.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $barang_opname_model = barang_opnameModel::find($id);
        if(barang_opnameModel::find($id)->delete()) {
            //update stok barang
            $barang_model = barangModel::find($barang_opname_model->barang_id);
            $barang_model->stok += $barang_opname_model->jumlah;
            $barang_model->save();
            return redirect()->route('barang-opname.index')
            ->with('success','barang berhasil dihapus');
        }
        else {
            return redirect()->route('barang-opname.index')
            ->with('error','barang gagal dihapus');
        }
        
    }
}
