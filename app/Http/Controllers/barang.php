<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang as barangModel;
use App\Models\supplier;
use App\Models\barang_stok as barang_stokModel;

class barang extends Controller
{
    
    public function index()
    {
        //
        $barang_model = barangModel::orderBy('id','desc')->paginate(12);
        return view('barang.index', ['barang_model' => $barang_model]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $supplier_model = supplier::orderBy('id','desc')->get();
        return view('barang.create', ['supplier_model' => $supplier_model]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'nama' => 'required',
            'supplier_id' => ['required','exists:App\Models\supplier,id'],
            'harga_jual' => ['required','numeric'],
        ]);
        barangModel::create($request->except(['_token', '_method']));
        $barang_id = barangModel::latest()->first()->id;
        barang_stokModel::create([
            'barang_id' => $barang_id,
            'jumlah' => 0,
        ]);
        return redirect()->route('barang.index')
        ->with('success','barang berhasil ditambahkan.');

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
        $barang_model = barangModel::find($id);
        return view('barang.edit', ['barang_model' => $barang_model, 'supplier_model' => supplier::orderBy('id','desc')->get()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'nama' => 'required',
            // 'telepon' => 'required',
            // 'alamat' => 'required',
        ]);
        barangModel::where('id', $id)->update($request->except(['_token', '_method']));
        return redirect()->route('barang.index')
        ->with('success','barang berhasil diedit');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        if(barangModel::find($id)->delete()) {
            return redirect()->route('barang.index')
            ->with('success','barang berhasil dihapus');
        }
        else {
            return redirect()->route('barang.index')
            ->with('error','barang gagal dihapus');
        }
    }
}
