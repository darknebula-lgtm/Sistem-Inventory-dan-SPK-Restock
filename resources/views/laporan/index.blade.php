@extends('layout')

@section('content')

<style>
    .card {
        max-width: 500px;
        margin: auto;
        background: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }

    h2 {
        text-align: center;
        color: #0f766e;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        font-weight: bold;
    }

    select, input {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    button {
        width: 100%;
        padding: 10px;
        background: #0f766e;
        color: white;
        border: none;
        border-radius: 5px;
        margin-top: 10px;
        cursor: pointer;
    }
</style>

<div class="card">
    <h2>Laporan</h2>

    <form method="GET" action="" id="formLaporan">

        <div class="form-group">
            <label>Jenis Laporan</label>
            <select id="jenis">
                <option value="">-- Pilih --</option>
                <option value="masuk">Barang Masuk</option>
                <option value="keluar">Barang Keluar</option>
            </select>
        </div>

        <div class="form-group">
            <label>Tanggal Mulai</label>
            <input type="date" name="tgl_awal" required>
        </div>

        <div class="form-group">
            <label>Tanggal Akhir</label>
            <input type="date" name="tgl_akhir" required>
        </div>

        <button type="submit">Download PDF</button>
    </form>
</div>

<script>
document.getElementById('formLaporan').addEventListener('submit', function(e) {
    let jenis = document.getElementById('jenis').value;

    if (!jenis) {
        alert('Pilih jenis laporan!');
        e.preventDefault();
        return;
    }

    if (jenis === 'masuk') {
        this.action = '/laporan/masuk';
    } else {
        this.action = '/laporan/keluar';
    }
});
</script>

@endsection