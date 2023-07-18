<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User as UserModel;

class User extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user_model = UserModel::orderBy('id','desc')->paginate(12);
        return view('user.index', ['user_model' => $user_model]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);
        UserModel::create($request->except(['_token', '_method']));
        return redirect()->route('user.index')->with('success','user berhasil ditambahkan.');
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
        $user_model = UserModel::find($id);
        return view('user.edit', ['user_model' => $user_model]);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            // 'password' => 'required',
        ]);
        $request->merge(['password' => bcrypt($request->get('password'))]);
        UserModel::where('id', $id)->update($request->except(['_token', '_method']));
        return redirect()->route('user.index')->with('success','user berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user_model = UserModel::find($id);
        if(!$user_model) {
            return redirect()->route('user.index')
            ->with('error','user tidak ditemukan');
        }
        //cek if user > 1
        $user_model_count = UserModel::count();
        if($user_model_count <= 1) {
            return redirect()->route('user.index')
            ->with('error','user tidak bisa dihapus karena hanya ada 1 user');
        }
        if($user_model->delete()) {
            return redirect()->route('user.index')
            ->with('success','user berhasil dihapus');
        }
        return redirect()->route('user.index')->with('error','user gagal dihapus');
    }
}
