<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pengaturan as pengaturanModel;

class pengaturan extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $pengaturan_model = pengaturanModel::orderBy('id','desc')->get();
        return view('pengaturan.index', ['pengaturan_model' => $pengaturan_model]);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('pengaturan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'nama' => 'required',
            'nilai' => 'required',
        ]);
        pengaturanModel::create($request->except(['_token', '_method']));
        return redirect()->route('pengaturan.index')->with('success','pengaturan berhasil ditambahkan.');

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
        $pengaturan_model = pengaturanModel::find($id);
        return view('pengaturan.edit', ['pengaturan_model' => $pengaturan_model]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'nama' => 'required',
            'nilai' => 'required',
        ]);
        pengaturanModel::where('id', $id)->update($request->except(['_token', '_method']));
        return redirect()->route('pengaturan.index')->with('success','pengaturan berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $pengaturan_model = pengaturanModel::find($id);
        if(!$pengaturan_model) {
            return redirect()->route('pengaturan.index')
            ->with('error','pengaturan tidak ditemukan');
        }
        if($pengaturan_model->delete()) {
            return redirect()->route('pengaturan.index')
            ->with('success','pengaturan berhasil dihapus');
        }
        return redirect()->route('pengaturan.index')->with('error','pengaturan gagal dihapus');
    }
}
