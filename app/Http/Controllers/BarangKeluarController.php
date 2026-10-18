<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangKeluar;
use App\Models\Produk;
use App\Models\Kategori;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB; // Tambahkan ini di atas untuk Transaction

class BarangKeluarController extends Controller
{
    public function index()
    {
        $data = BarangKeluar::with('produk')
            ->orderBy('tanggal_keluar','desc')
            ->get();

        return view('barang_keluar.index', compact('data'));
    }

    public function create()
    {
        $produk = Produk::all();
        $kategori = Kategori::all();

        return view('barang_keluar.create', compact('produk', 'kategori'));
    }

    public function store(Request $request)
    {
        // Gunakan DB Transaction agar jika ada satu baris yang gagal, semua input dibatalkan
        DB::beginTransaction();

        try {
            foreach ($request->data as $item) {
                $produk = Produk::find($item['id_produk']);

                if (!$produk) {
                    DB::rollBack();
                    return back()->with('error', 'Produk tidak ditemukan!');
                }

                // VALIDASI STOK (Server-side)
                if ($item['jumlah'] > $produk->stok) {
                    DB::rollBack(); // Batalkan semua produk yang sempat diproses di baris atasnya
                    return back()->with('error', 'Stok produk ' . $produk->nama_produk . ' tidak mencukupi!');
                }

                BarangKeluar::create([
                    'id_user' => auth()->id(),
                    'id_produk' => $item['id_produk'],
                    'tanggal_keluar' => $item['tanggal_keluar'],
                    'jumlah' => $item['jumlah'],
                ]);

                // KURANGI STOK
                $produk->stok -= $item['jumlah'];
                $produk->save();
            }

            DB::commit(); // Eksekusi semua perubahan ke database jika sukses semua
            return redirect('/barang-keluar')->with('success', 'Data pengeluaran barang berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan jika terjadi error tak terduga sistem
            return back()->with('error', 'Terjadi kesalahan sistem saat menyimpan data.');
        }
    }

    public function destroy($id)
    {
        // 1. Cari data barang keluar yang akan dihapus
        $barangKeluar = BarangKeluar::find($id);

        if ($barangKeluar) {
            // 2. Kembalikan stok produk karena pengeluaran dibatalkan
            $produk = Produk::find($barangKeluar->id_produk);
            if ($produk) {
                $produk->stok += $barangKeluar->jumlah;
                $produk->save();
            }

            // 3. Hapus data barang keluar
            $barangKeluar->delete();

            // 4. Return dengan membawa Toast sukses
            return back()->with('success', 'Data barang keluar berhasil dihapus dan stok dikembalikan!');
        }

        return back()->with('error', 'Data tidak ditemukan!');
    }

    public function laporan(Request $request)
    {
        $data = BarangKeluar::with('produk')
            ->whereBetween('tanggal_keluar', [$request->tgl_awal, $request->tgl_akhir])
            ->get();

        $pdf = Pdf::loadView('laporan.keluar', compact('data'));
        return $pdf->download('laporan_barang_keluar.pdf');
    }
}