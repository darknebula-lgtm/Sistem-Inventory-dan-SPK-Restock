<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::with('kategori');

        // 🔍 SEARCH PRODUK
        if ($request->search) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        $data = $query->get();

        // 🔥 CEK JIKA USER MELAKUKAN PENCARIAN DAN HASILNYA KOSONG
        if ($request->search && $data->isEmpty()) {
            // Kembalikan ke halaman produk polosan (tanpa query search) bawa Toast error
            return redirect('/produk')->with('error', 'Barang tidak tersedia atau tidak ditemukan!');
        }

        return view('produk.index', compact('data'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        return view('produk.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        // VALIDASI
        $request->validate([
            'nama_produk' => 'required',
            'id_kategori' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
        ]);

        Produk::create($request->all());

        return redirect('/produk')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = Produk::findOrFail($id);
        $kategori = Kategori::all();

        return view('produk.edit', compact('data', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        // VALIDASI
        $request->validate([
            'nama_produk' => 'required',
            'id_kategori' => 'required',
            'harga' => 'required|numeric',
        ]);

        $produk = Produk::findOrFail($id);
        $produk->update($request->all());

        return redirect('/produk')->with('success', 'Produk berhasil diupdate');
    }

    public function destroy($id)
    {
        Produk::destroy($id);
        return back()->with('success', 'Produk berhasil dihapus');
    }
}