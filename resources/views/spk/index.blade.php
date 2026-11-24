@extends('layout')

@section('content')

<style>
    .page-title {
        margin: 0 0 20px;
        font-size: 20px;
        font-weight: bold;
    }

    .alert-box {
        margin-bottom: 16px;
        padding: 12px 16px;
        font-size: 14px;
        color: #b42318;
        background: #fde2e2;
        border-radius: 14px;
    }

    /* FORM BOBOT */
    .bobot-form {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        gap: 14px;
        margin-bottom: 24px;
    }

    .bobot-item label {
        display: block;
        margin-bottom: 6px;
        font-size: 13px;
        font-weight: 600;
    }

    .form-input {
        width: 120px;
        box-sizing: border-box;
        padding: 10px 14px;
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

    /* TOMBOL */
    .btn-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 10px 18px;
        font: inherit;
        font-size: 13px;
        font-weight: bold;
        border: none;
        border-radius: 999px;
        cursor: pointer;
    }

    .btn-pill:hover {
        opacity: 0.85;
    }

    .btn-main {
        background: var(--teal, #0f5c4d);
        color: white;
    }

    .btn-soft {
        background: #dcf7ee;
        color: #0f7a5a;
    }

    .btn-step {
        margin-top: 20px;
    }

    /* TABEL */
    .table-wrap {
        overflow-x: auto;
    }

    .tbl {
        width: 100%;
        border-collapse: collapse;
    }

    .tbl th {
        padding: 12px 10px;
        font-size: 13px;
        text-align: left;
        border-bottom: 1px solid var(--line, #cfd8d5);
    }

    .tbl td {
        padding: 12px 10px;
        font-size: 14px;
        border-bottom: 1px solid #eef2f1;
    }

    .tbl .num {
        text-align: right;
    }

    .tbl td.empty-row {
        padding: 30px;
        text-align: center;
        color: var(--muted, #7b8794);
    }

    /* RANKING */
    .rank {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        font-size: 13px;
        font-weight: bold;
        background: #eef2f1;
        border-radius: 50%;
    }

    .rank-1 {
        background: #e24b4a;
        color: white;
    }

    .rank-2 {
        background: var(--orange, #ee7035);
        color: white;
    }

    .rank-3 {
        background: #f5c242;
        color: #5a4300;
    }

    .pos {
        color: #0f7a5a;
    }

    .neg {
        color: #b42318;
    }

    /* MODAL */
    .modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 999;
        padding: 4vh 16px;
        background: rgba(15, 30, 25, 0.5);
    }

    .modal.open {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-box {
        display: flex;
        flex-direction: column;
        width: 100%;
        max-width: 900px;
        max-height: 88vh;
        background: white;
        border-radius: 24px;
    }

    .modal-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        padding: 20px 24px 12px;
    }

    .modal-title {
        margin: 0;
        font-size: 18px;
        font-weight: bold;
    }

    .modal-close {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: var(--muted, #7b8794);
        background: none;
        border: 1px solid var(--line, #cfd8d5);
        border-radius: 50%;
        cursor: pointer;
    }

    .modal-body {
        flex: 1;
        padding: 0 24px;
        overflow: auto;
    }

    .modal-body h4 {
        margin: 18px 0 6px;
        font-size: 15px;
    }

    .modal-foot {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 24px 20px;
    }

    .step-count {
        font-size: 13px;
        color: var(--muted, #7b8794);
    }
</style>

<div class="ui-card">

    <h2 class="page-title">SPK Restock (PROMETHEE)</h2>

    @if(session('error'))
        <div class="alert-box">{{ session('error') }}</div>
    @endif

    <!-- FORM BOBOT -->
    <form method="GET" class="bobot-form">
        <div class="bobot-item">
            <label for="terjual">Terjual</label>
            <input type="number" step="0.1" min="0" id="terjual" name="terjual"
                   class="form-input" value="{{ $bobot['terjual'] }}">
        </div>

        <div class="bobot-item">
            <label for="harga">Harga</label>
            <input type="number" step="0.1" min="0" id="harga" name="harga"
                   class="form-input" value="{{ $bobot['harga'] }}">
        </div>

        <div class="bobot-item">
            <label for="stok">Stok</label>
            <input type="number" step="0.1" min="0" id="stok" name="stok"
                   class="form-input" value="{{ $bobot['stok'] }}">
        </div>

        <button type="submit" class="btn-pill btn-main">
            <i class="ti ti-calculator"></i> Hitung
        </button>
    </form>

    <!-- HASIL RANKING -->
    <div class="table-wrap">
        <table class="tbl">
            <thead>
                <tr>
                    <th>Ranking</th>
                    <th>Produk</th>
                    <th class="num">Terjual</th>
                    <th class="num">Harga</th>
                    <th class="num">Stok</th>
                    <th class="num">Net Flow</th>
                </tr>
            </thead>

            <tbody>
                @forelse($hasil as $h)
                    <tr>
                        <td>
                            <span class="rank {{ $loop->iteration <= 3 ? 'rank-' . $loop->iteration : '' }}">
                                {{ $loop->iteration }}
                            </span>
                        </td>
                        <td>{{ $h['nama'] }}</td>
                        <td class="num">{{ $h['terjual'] }}</td>
                        <td class="num">{{ number_format($h['harga'], 0, ',', '.') }}</td>
                        <td class="num">{{ $h['stok'] }}</td>
                        <td class="num">
                            <strong class="{{ $h['net'] >= 0 ? 'pos' : 'neg' }}">
                                {{ round($h['net'], 3) }}
                            </strong>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-row">Belum ada produk untuk dihitung.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <button type="button" class="btn-pill btn-soft btn-step" onclick="openModal()">
        <i class="ti ti-list-details"></i> Lihat Step Perhitungan
    </button>

</div>

{{-- ========================
     MODAL STEP
======================== --}}
<div id="modalStep" class="modal" onclick="if (event.target === this) closeModal()">
    <div class="modal-box">

        <div class="modal-head">
            <h3 id="stepTitle" class="modal-title"></h3>

            <button type="button" class="modal-close" onclick="closeModal()" title="Tutup">
                <i class="ti ti-x"></i>
            </button>
        </div>

        <div class="modal-body">

            <!-- STEP 1 -->
            <div class="step-panel" data-step="1" data-title="Step 1: Data Awal">
                <table class="tbl">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th class="num">Terjual</th>
                            <th class="num">Harga</th>
                            <th class="num">Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($step['data_awal'] as $d)
                            <tr>
                                <td>{{ $d['nama'] }}</td>
                                <td class="num">{{ $d['terjual'] }}</td>
                                <td class="num">{{ number_format($d['harga'], 0, ',', '.') }}</td>
                                <td class="num">{{ $d['stok'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- STEP 2 -->
            <div class="step-panel" data-step="2" data-title="Step 2: Normalisasi">
                <table class="tbl">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th class="num">Terjual</th>
                            <th class="num">Harga</th>
                            <th class="num">Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($step['normalisasi'] as $d)
                            <tr>
                                <td>{{ $d['nama'] }}</td>
                                <td class="num">{{ round($d['terjual_n'], 3) }}</td>
                                <td class="num">{{ round($d['harga_n'], 3) }}</td>
                                <td class="num">{{ round($d['stok_n'], 3) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- STEP 3 -->
            <div class="step-panel" data-step="3" data-title="Step 3: Perbandingan">
                @foreach($hasil as $h)
                    <h4>{{ $h['nama'] }}</h4>

                    <table class="tbl">
                        <thead>
                            <tr>
                                <th>Dibanding</th>
                                <th class="num">A→B</th>
                                <th class="num">B→A</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($h['detail'] as $d)
                                <tr>
                                    <td>{{ $d['dibanding'] }}</td>
                                    <td class="num">{{ $d['pref_ab'] }}</td>
                                    <td class="num">{{ $d['pref_ba'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endforeach
            </div>

            <!-- STEP 4 -->
            <div class="step-panel" data-step="4" data-title="Step 4-6: Flow & Ranking">
                <table class="tbl">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th class="num">Leaving</th>
                            <th class="num">Entering</th>
                            <th class="num">Net</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hasil as $h)
                            <tr>
                                <td>{{ $h['nama'] }}</td>
                                <td class="num">{{ round($h['leaving'], 3) }}</td>
                                <td class="num">{{ round($h['entering'], 3) }}</td>
                                <td class="num">{{ round($h['net'], 3) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

        <div class="modal-foot">
            <button type="button" id="btnPrev" class="btn-pill btn-soft" onclick="prevStep()">
                <i class="ti ti-arrow-left"></i> Prev
            </button>

            <span id="stepCount" class="step-count"></span>

            <button type="button" id="btnNext" class="btn-pill btn-main" onclick="nextStep()">
                Next <i class="ti ti-arrow-right"></i>
            </button>
        </div>

    </div>
</div>

<script>
    let step = 1;
    const totalStep = 4;

    const modal = document.getElementById('modalStep');
    const stepTitle = document.getElementById('stepTitle');
    const stepCount = document.getElementById('stepCount');
    const btnPrev = document.getElementById('btnPrev');
    const btnNext = document.getElementById('btnNext');
    const panels = document.querySelectorAll('.step-panel');

    function openModal() {
        step = 1;
        modal.classList.add('open');
        showStep();
    }

    function closeModal() {
        modal.classList.remove('open');
    }

    function nextStep() {
        if (step < totalStep) {
            step++;
            showStep();
        }
    }

    function prevStep() {
        if (step > 1) {
            step--;
            showStep();
        }
    }

    function showStep() {
        panels.forEach(function (panel) {
            panel.hidden = Number(panel.dataset.step) !== step;

            if (!panel.hidden) {
                stepTitle.innerText = panel.dataset.title;
            }
        });

        stepCount.innerText = step + ' / ' + totalStep;
        btnPrev.style.visibility = step === 1 ? 'hidden' : 'visible';
        btnNext.style.visibility = step === totalStep ? 'hidden' : 'visible';
    }

    // tekan Esc untuk menutup modal
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });
</script>

@endsection