<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier as SupplierModel;


class supplier extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $supplier_model = SupplierModel::orderBy('id','desc')->paginate(12);
        return view('supplier.index', ['supplier_model' => $supplier_model]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'nama' => 'required',
            // 'telepon' => 'required',
            // 'alamat' => 'required',
        ]);
        SupplierModel::create($request->except(['_token', '_method']));
        return redirect()->route('supplier.index')
        ->with('success','Supplier berhasil ditambahkan.');

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
        $supplier_model = SupplierModel::find($id);
        return view('supplier.edit', ['supplier_model' => $supplier_model]);
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
        SupplierModel::where('id', $id)->update($request->except(['_token', '_method']));
        return redirect()->route('supplier.index')
        ->with('success','Supplier berhasil diedit');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $supplier_model = SupplierModel::with('barang')->find($id);
        if(!$supplier_model) {
            return redirect()->route('supplier.index')
            ->with('error','Supplier tidak ditemukan');
        }
        if($supplier_model->barang->first()) {
            return redirect()->route('supplier.index')
            ->with('error','Supplier tidak bisa dihapus karena masih memiliki barang');
        }

        if($supplier_model->delete()) {
            return redirect()->route('supplier.index')
            ->with('success','supplier berhasil dihapus');
        }
        
        return redirect()->route('supplier.index')
        ->with('error','supplier gagal dihapus');


    }
}
