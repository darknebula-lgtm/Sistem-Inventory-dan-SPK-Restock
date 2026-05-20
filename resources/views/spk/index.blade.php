@extends('layout')

@section('content')

<style>
.card {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}

h2 {
    margin-bottom: 20px;
    color: #0f766e;
}

.form-bobot {
    display: flex;
    gap: 15px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

input {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    width: 100px;
}

button {
    padding: 8px 15px;
    background: #0f766e;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.alert {
    background: #e74c3c;
    color: white;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 15px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

th {
    background: #0f766e;
    color: white;
    padding: 10px;
}

td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

.rank-1 { background: #e74c3c; color: white; }
.rank-2 { background: #f39c12; color: white; }
.rank-3 { background: #f1c40f; }

.section-title {
    margin-top: 30px;
    margin-bottom: 10px;
    color: #0f766e;
}

/* MODAL */
.modal {
    display: none;
    position: fixed;
    z-index: 999;
    left: 0; top: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.5);
}

.modal-content {
    background: white;
    margin: 5% auto;
    padding: 20px;
    width: 80%;
    max-height: 80vh;
    overflow: auto;
    border-radius: 10px;
}

.modal-footer {
    margin-top: 15px;
    display: flex;
    justify-content: space-between;
}
</style>

<div class="card">

<h2>SPK Restock (PROMETHEE)</h2>

@if(session('error'))
<div class="alert">{{ session('error') }}</div>
@endif

<form method="GET" class="form-bobot">
    <div>
        Terjual<br>
        <input type="number" step="0.1" name="terjual" value="{{ $bobot['terjual'] }}">
    </div>

    <div>
        Harga<br>
        <input type="number" step="0.1" name="harga" value="{{ $bobot['harga'] }}">
    </div>

    <div>
        Stok<br>
        <input type="number" step="0.1" name="stok" value="{{ $bobot['stok'] }}">
    </div>

    <div style="align-self:end;">
        <button type="submit">Hitung</button>
    </div>
</form>

<table>
<tr>
    <th>Ranking</th>
    <th>Produk</th>
    <th>Terjual</th>
    <th>Harga</th>
    <th>Stok</th>
    <th>Net Flow</th>
</tr>

@foreach($hasil as $i => $h)
<tr class="{{ $i == 0 ? 'rank-1' : ($i == 1 ? 'rank-2' : ($i == 2 ? 'rank-3' : '')) }}">
    <td>{{ $i+1 }}</td>
    <td>{{ $h['nama'] }}</td>
    <td>{{ $h['terjual'] }}</td>
    <td>{{ number_format($h['harga']) }}</td>
    <td>{{ $h['stok'] }}</td>
    <td><strong>{{ round($h['net'],3) }}</strong></td>
</tr>
@endforeach
</table>

<br>
<button onclick="openModal()">Lihat Step Perhitungan</button>

</div>

{{-- ========================
     MODAL STEP
======================== --}}
<div id="modalStep" class="modal">
    <div class="modal-content">

        <h3 id="stepTitle"></h3>

        <div id="stepContent"></div>

        <div class="modal-footer">
            <button onclick="prevStep()">⬅ Prev</button>
            <button onclick="nextStep()">Next ➡</button>
            <button onclick="closeModal()">Tutup</button>
        </div>

    </div>
</div>

<script>
let step = 1;

function openModal() {
    document.getElementById('modalStep').style.display = 'block';
    showStep();
}

function closeModal() {
    document.getElementById('modalStep').style.display = 'none';
}

function nextStep() {
    if(step < 4) step++;
    showStep();
}

function prevStep() {
    if(step > 1) step--;
    showStep();
}

function showStep() {
    let title = document.getElementById('stepTitle');
    let content = document.getElementById('stepContent');

    if(step === 1){
        title.innerText = "Step 1: Data Awal";
        content.innerHTML = `
        <table>
        <tr><th>Produk</th><th>Terjual</th><th>Harga</th><th>Stok</th></tr>
        @foreach($step['data_awal'] as $d)
        <tr>
            <td>{{ $d['nama'] }}</td>
            <td>{{ $d['terjual'] }}</td>
            <td>{{ $d['harga'] }}</td>
            <td>{{ $d['stok'] }}</td>
        </tr>
        @endforeach
        </table>`;
    }

    if(step === 2){
        title.innerText = "Step 2: Normalisasi";
        content.innerHTML = `
        <table>
        <tr><th>Produk</th><th>Terjual</th><th>Harga</th><th>Stok</th></tr>
        @foreach($step['normalisasi'] as $d)
        <tr>
            <td>{{ $d['nama'] }}</td>
            <td>{{ round($d['terjual_n'],3) }}</td>
            <td>{{ round($d['harga_n'],3) }}</td>
            <td>{{ round($d['stok_n'],3) }}</td>
        </tr>
        @endforeach
        </table>`;
    }

    if(step === 3){
        title.innerText = "Step 3: Perbandingan";
        content.innerHTML = `
        @foreach($hasil as $h)
        <h4>{{ $h['nama'] }}</h4>
        <table>
        <tr><th>Dibanding</th><th>A→B</th><th>B→A</th></tr>
        @foreach($h['detail'] as $d)
        <tr>
            <td>{{ $d['dibanding'] }}</td>
            <td>{{ $d['pref_ab'] }}</td>
            <td>{{ $d['pref_ba'] }}</td>
        </tr>
        @endforeach
        </table>
        @endforeach`;
    }

    if(step === 4){
        title.innerText = "Step 4-6: Flow & Ranking";
        content.innerHTML = `
        <table>
        <tr><th>Produk</th><th>Leaving</th><th>Entering</th><th>Net</th></tr>
        @foreach($hasil as $h)
        <tr>
            <td>{{ $h['nama'] }}</td>
            <td>{{ round($h['leaving'],3) }}</td>
            <td>{{ round($h['entering'],3) }}</td>
            <td>{{ round($h['net'],3) }}</td>
        </tr>
        @endforeach
        </table>`;
    }
}
</script>

@endsection