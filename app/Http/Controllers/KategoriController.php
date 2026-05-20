<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index()
    {
        $data = Kategori::all();
        return view('kategori.index', compact('data'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    // 1. Tambahkan ->with() setelah redirect
    public function store(Request $request)
    {
        Kategori::create($request->all());
        return redirect('/kategori')->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data = Kategori::find($id);
        return view('kategori.edit', compact('data'));
    }

    // 2. Tambahkan ->with() setelah redirect
    public function update(Request $request, $id)
    {
        $data = Kategori::find($id);
        $data->update($request->all());
        return redirect('/kategori')->with('success', 'Kategori berhasil diperbarui!');
    }

    // 3. Tambahkan ->with() setelah back
    public function destroy($id)
    {
        Kategori::destroy($id);
        return back()->with('success', 'Kategori berhasil dihapus!');
    }
}