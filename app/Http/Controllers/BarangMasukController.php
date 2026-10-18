<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\Produk;
use App\Models\Kategori;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB; // 🔥 1. WAJIB TAMBAHKAN INI UNTUK TRANSACTION

class BarangMasukController extends Controller
{
    public function index()
    {
        $data = BarangMasuk::with('produk')->get();
        return view('barang_masuk.index', compact('data'));
    }

    public function create()
    {
        $produk = Produk::all();
        $kategori = Kategori::all();
        return view('barang_masuk.create', compact('produk','kategori'));
    }

    public function store(Request $request)
    {
        // 🔥 2. AKTIFKAN TRANSACTION AGAR MULTI-INPUT AMAN
        DB::beginTransaction();

        try {
            foreach ($request->data as $item) {

                BarangMasuk::create([
                    'id_user' => auth()->id(),
                    'id_produk' => $item['id_produk'],
                    'tanggal_masuk' => $item['tanggal_masuk'],
                    'jumlah' => $item['jumlah'],
                ]);

                $produk = Produk::find($item['id_produk']);
                if ($produk) {
                    $produk->stok += $item['jumlah'];
                    $produk->save();
                }
            }

            DB::commit(); // Eksekusi semua perubahan jika berhasil tanpa error
            return redirect('/barang-masuk')->with('success', 'Data barang masuk berhasil disimpan');

        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan semua input jika di tengah jalan ada error sistem
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function destroy($id)
    {
        // 🔥 3. PERBAIKAN LOGIKA HAPUS & STOK SINKRON
        $barangMasuk = BarangMasuk::find($id);

        if ($barangMasuk) {
            // Kurangi stok produk kembali karena barang masuknya dibatalkan/dihapus
            $produk = Produk::find($barangMasuk->id_produk);
            if ($produk) {
                // Pastikan stok tidak minus saat dikurangi (opsional, untuk keamanan)
                if ($produk->stok >= $barangMasuk->jumlah) {
                    $produk->stok -= $barangMasuk->jumlah;
                } else {
                    $produk->stok = 0;
                }
                $produk->save();
            }

            // Baru hapus data riwayat barang masuknya
            $barangMasuk->delete();

            return back()->with('success', 'Data barang masuk berhasil dihapus dan stok telah diperbarui!');
        }

        return back()->with('error', 'Data tidak ditemukan!');
    }

    public function laporan(Request $request)
    {
        $data = BarangMasuk::with('produk')
            ->whereBetween('tanggal_masuk', [$request->tgl_awal, $request->tgl_akhir])
            ->get();

        $pdf = Pdf::loadView('laporan.masuk', compact('data'));
        return $pdf->download('laporan_barang_masuk.pdf');
    }
}