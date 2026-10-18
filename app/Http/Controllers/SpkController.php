<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class SpkController extends Controller
{
    public function index(Request $request)
    {
        // =============================
        // BOBOT
        // =============================
        $bobot = [
            'terjual' => (float) ($request->terjual ?? 0.5),
            'harga'   => (float) ($request->harga ?? 0.3),
            'stok'    => (float) ($request->stok ?? 0.2),
        ];

        if (round(array_sum($bobot), 2) != 1) {
            return back()->with('error', 'Total bobot harus = 1');
        }

        // =============================
        // STEP 1: DATA AWAL
        // =============================
        $produk = Produk::withSum('barangKeluar as total_terjual', 'jumlah')
                        ->orderBy('id_produk')
                        ->get();

        $data_awal = [];

        foreach ($produk as $p) {
            $data_awal[] = [
                'id'      => $p->id_produk,
                'nama'    => $p->nama_produk,
                'terjual' => $p->total_terjual ?? 0,
                'harga'   => $p->harga,
                'stok'    => $p->stok,
            ];
        }

        // =============================
        // STEP 2: NORMALISASI
        // =============================
        $maxTerjual = max(array_column($data_awal, 'terjual'));
        $maxHarga   = max(array_column($data_awal, 'harga'));
        $maxStok    = max(array_column($data_awal, 'stok'));

        $normalisasi = [];

        foreach ($data_awal as $d) {
            $normalisasi[] = [
                'nama' => $d['nama'],
                'terjual_n' => $maxTerjual ? $d['terjual'] / $maxTerjual : 0,
                'harga_n'   => $maxHarga ? $d['harga'] / $maxHarga : 0,
                'stok_n'    => $maxStok ? $d['stok'] / $maxStok : 0,
            ];
        }

        // =============================
        // STEP 3 - 6: PROMETHEE
        // =============================
        $hasil = [];

        foreach ($data_awal as $a) {

            $leaving = 0;
            $entering = 0;
            $detail = [];

            foreach ($data_awal as $b) {

                if ($a['id'] == $b['id']) continue;

                // PREF A -> B
                $pref_ab =
                    $bobot['terjual'] * max(0, $a['terjual'] - $b['terjual']) +
                    $bobot['harga']   * max(0, $b['harga'] - $a['harga']) +
                    $bobot['stok']    * max(0, $b['stok'] - $a['stok']);

                // PREF B -> A
                $pref_ba =
                    $bobot['terjual'] * max(0, $b['terjual'] - $a['terjual']) +
                    $bobot['harga']   * max(0, $a['harga'] - $b['harga']) +
                    $bobot['stok']    * max(0, $a['stok'] - $b['stok']);

                $leaving += $pref_ab;
                $entering += $pref_ba;

                $detail[] = [
                    'dibanding' => $b['nama'],
                    'pref_ab'   => round($pref_ab,3),
                    'pref_ba'   => round($pref_ba,3),
                ];
            }

            $hasil[] = [
                'nama'     => $a['nama'],
                'terjual'  => $a['terjual'],
                'harga'    => $a['harga'],
                'stok'     => $a['stok'],
                'leaving'  => $leaving,
                'entering' => $entering,
                'net'      => $leaving - $entering,
                'detail'   => $detail
            ];
        }

        // =============================
        // SORTING
        // =============================
        usort($hasil, fn($a, $b) => $b['net'] <=> $a['net']);

        // =============================
        // CHART
        // =============================
        $chartData = [];

        foreach ($hasil as $h) {
            $chartData[] = [
                'produk' => $h['nama'],
                'skor'   => round($h['net'],3),
            ];
        }

        // =============================
        // STEP FINAL
        // =============================
        $step = [
            'data_awal'   => $data_awal,
            'normalisasi' => $normalisasi
        ];

        return view('spk.index', compact('hasil','bobot','chartData','step'));
    }
}