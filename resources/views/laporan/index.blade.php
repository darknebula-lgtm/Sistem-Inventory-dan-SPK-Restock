@extends('layout')

@section('content')

<style>
    .form-card {
        max-width: 500px;
        margin: 20px auto;
        padding: 30px;
    }

    .form-title {
        margin: 0 0 25px;
        font-size: 20px;
        font-weight: bold;
        text-align: center;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-size: 14px;
        font-weight: 600;
    }

    .form-input {
        width: 100%;
        box-sizing: border-box;
        padding: 12px 16px;
        font: inherit;
        font-size: 14px;
        color: inherit;
        background: white;
        border: 1px solid var(--line, #cfd8d5);
        border-radius: 14px;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-input:focus {
        border-color: var(--teal, #0f5c4d);
        box-shadow: 0 0 0 3px rgba(15, 92, 77, 0.15);
    }

    .field-error {
        display: block;
        margin-top: 6px;
        font-size: 12px;
        color: #b42318;
    }

    .field-error[hidden] {
        display: none;
    }

    .date-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .btn-form {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        box-sizing: border-box;
        margin-top: 25px;
        padding: 13px;
        font: inherit;
        font-size: 14px;
        font-weight: bold;
        color: white;
        background: var(--teal, #0f5c4d);
        border: none;
        border-radius: 999px;
        cursor: pointer;
        transition: background 0.2s;
    }

    .btn-form:hover {
        background: #0a4a3d;
    }

    @media (max-width: 480px) {
        .date-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="ui-card form-card">
    <h2 class="form-title">Laporan</h2>

    <form method="GET" action="" id="formLaporan">

        <div class="form-group">
            <label for="jenis" class="form-label">Jenis Laporan</label>
            <select id="jenis" class="form-input">
                <option value="">-- Pilih --</option>
                <option value="masuk">Barang Masuk</option>
                <option value="keluar">Barang Keluar</option>
            </select>
            <small id="err-jenis" class="field-error" hidden>Pilih jenis laporan dulu.</small>
        </div>

        <div class="date-grid">
            <div class="form-group">
                <label for="tgl_awal" class="form-label">Tanggal Mulai</label>
                <input type="date" id="tgl_awal" name="tgl_awal" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="tgl_akhir" class="form-label">Tanggal Akhir</label>
                <input type="date" id="tgl_akhir" name="tgl_akhir" class="form-input" required>
            </div>
        </div>
        <small id="err-tanggal" class="field-error" hidden>
            Tanggal akhir tidak boleh lebih awal dari tanggal mulai.
        </small>

        <button type="submit" class="btn-form">
            <i class="ti ti-download"></i> Download PDF
        </button>
    </form>
</div>

<script>
    const form = document.getElementById('formLaporan');
    const jenisSelect = document.getElementById('jenis');
    const tglAwal = document.getElementById('tgl_awal');
    const tglAkhir = document.getElementById('tgl_akhir');
    const errJenis = document.getElementById('err-jenis');
    const errTanggal = document.getElementById('err-tanggal');

    const rute = {
        masuk: '/laporan/masuk',
        keluar: '/laporan/keluar'
    };

    // tanggal akhir tidak boleh sebelum tanggal mulai
    tglAwal.addEventListener('change', function () {
        tglAkhir.min = this.value;
    });

    jenisSelect.addEventListener('change', function () {
        errJenis.hidden = true;
    });

    form.addEventListener('submit', function (e) {
        errJenis.hidden = true;
        errTanggal.hidden = true;

        if (!jenisSelect.value) {
            e.preventDefault();
            errJenis.hidden = false;
            return;
        }

        if (tglAkhir.value < tglAwal.value) {
            e.preventDefault();
            errTanggal.hidden = false;
            return;
        }

        this.action = rute[jenisSelect.value];
    });
</script>

@endsection