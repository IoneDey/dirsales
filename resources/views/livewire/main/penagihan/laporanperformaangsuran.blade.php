<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <link href="{{ asset('css/styleSelect2.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/styles_table_res.css') }}" rel="stylesheet" />
    <link href="{{ asset('sneat/css/style-spinner.css') }}" rel="stylesheet" />
    <style>
        @media (max-width: 768px) {
            .input-group-item {
                flex: 1 1 100%;
                /* Item akan menjadi satu baris pada layar kecil */
            }
        }

        .custom-divider {
            height: 1px;
            background-color: blue;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 1);
            margin: 20px 0;
        }

        /* untuk tabel scroll */
        table th,
        table td {
            white-space: nowrap;
        }

        .table-responsive {
            max-height: 66vh;
            overflow-y: auto;
            overflow-x: auto;
        }

        @media (max-height: 800px) {
            .table-responsive {
                max-height: 42vh;
            }
        }

        th {
            position: sticky;
            top: 0 !important;
            background-color: #f8f9fa !important;
            z-index: 10;
            box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4) !important;
        }

        td {
            position: relative !important;
            z-index: 1 !important;
        }

        /* untuk tabel rounded */
        .table-rounded {
            border-collapse: separate;
            border-spacing: 0;
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .table-rounded th,
        .table-rounded td {
            border: 1px solid #dee2e6;
        }

        .table-rounded thead th:first-child {
            border-top-left-radius: 0.5rem;
        }

        .table-rounded thead th:last-child {
            border-top-right-radius: 0.5rem;
        }

        .table-rounded tbody tr:last-child td:first-child {
            border-bottom-left-radius: 0.5rem;
        }

        .table-rounded tbody tr:last-child td:last-child {
            border-bottom-right-radius: 0.5rem;
        }

        .data-wrapper {
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
            padding: 1rem;
            overflow: hidden;
        }

        .data-columns {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1px;
        }

        .data-column {
            background: #f9f9f9;
            border-radius: 0.5rem;
            padding: 1px;
            border: 1px solid #ddd;
            margin-bottom: 1px;
        }
    </style>

    <div class="container">

        <h2 class="text-center">{{ $title }}</h2>

        <div class="row justify-content-center">
            <div class="data-columns">
                <div>
                    <div class="d-flex align-items-left" x-data="{ isUpdate: @entangle('isUpdate') }" wire:ignore>
                        <span class="me-0 input-group-text" style="padding: 0.375rem 0.5rem; border-radius: 0.25rem 0 0 0; margin-right: -0.5rem; height: 38px;">Tim</span>
                        <select x-data="{item: @entangle('tim')}" x-init="$($refs.select2ref).select2(); $($refs.select2ref).on('change', function(){$wire.set('tim', $(this).val());});" x-effect="$refs.select2ref.value = item; $($refs.select2ref).select2();" x-ref="select2ref" :disabled="isUpdate" class="form-select" aria-label="Tim">
                            <option value='Semua'>Semua</option>
                            @foreach ($dbTimsetups as $dbTimsetup)
                            <option value="{{ $dbTimsetup->id }}">{{ $dbTimsetup->joinTim->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('timsetupid')
                    <span style="font-size: smaller; color: red;">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <div class="d-flex align-items-left">
                        <span class="me-0 input-group-text">
                            IP. Total &lt;= </span>
                        <input wire:model.live="iptotal" type="number" class="form-control" type="text" placeholder="dalam %...."></input>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 mt-1 mb-1">
            <input class="border rounded" wire:model.live.debounce.500ms="cari" type="text" id="cari" placeholder="cari Nota/Tgl Angsuran ....">
        </div>

        @foreach ($dbPerformaAngsurans as $heads => $items)
        <div class="data-wrapper">
            <div class="data-columns">
                <div class="data-column">
                    {{ $items[0]->tim }}<br>
                    Nota: {{ $items[0]->nota }}<br>
                    Nama: {{ $items[0]->customernama }}<br>
                    Penjualan: {{ number_format(($items[0]->penjualan ?? 0), 0, ',', '.') }}<br>
                    Retur: {{ number_format(($items[0]->retur ?? 0), 0, ',', '.') }}<br>
                    Total: {{ number_format(($items[0]->totaljual ?? 0), 0, ',', '.') }}
                </div>
                <div class="data-column">
                    Index Performa Jumlah: {{ number_format(($items[0]->ipjumlah ?? 0), 2, ',', '.') }}%<br>
                    Index Performa Waktu: {{ number_format(($items[0]->ipwaktu ?? 0), 2, ',', '.') }}%<br>
                    Index Performa Total: {{ number_format(($items[0]->iptotal ?? 0), 2, ',', '.') }}%<br>
                </div>
            </div>
            <table class="table table-sm table-bordered table-striped table-hover table-rounded" style="width: 100%;">
                <thead>
                    <tr>
                        <!-- <th>Tim Id</th>
                        <th>Nota</th>
                        <th>Penjualan</th>
                        <th>Retur</th>
                        <th>Total Penjualan</th> -->
                        <th>Perangsuran</th>
                        <th>+/- Angsuran</th>
                        <th>A-n</th>
                        <th>Tgl Angsuran</th>
                        <th>Tgl Penagihan</th>
                        <th>Jml Penagihan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item )
                    <tr>
                        <!-- <td>{{ $item->timsetupid }}</td>
                        <td>{{ $item->nota }}</td>
                        <td>{{ $item->penjualan }}</td>
                        <td>{{ $item->retur }}</td>
                        <td>{{ $item->totaljual }}</td> -->
                        <td class="rata-kanan">{{ number_format(($item->perangsuran ?? 0), 0, ',', '.') }}</td>
                        <td class="rata-kanan">{{ number_format(($item->selisih ?? 0), 0, ',', '.') }}</td>
                        <td class="rata-tengah">{{ $item->angsuranke }}</td>
                        <td>{{ $item->tglangsuran }}</td>
                        <td>{{ $item->tglpenagihan }}</td>
                        <td class="rata-kanan">
                            {{ number_format(($item->jmlpenagihan ?? 0), 0, ',', '.') }}
                            @if ($item->perangsuran == 0)
                            <i class="bi bi-question" style="color: red;"></i>
                            @elseif ($item->perangsuran > $item->jmlpenagihan)
                            <i class="bi bi-caret-down-fill" style="color: red;"></i>
                            @elseif ($item->perangsuran == $item->jmlpenagihan)
                            <i class="bi bi-check"></i>
                            @else
                            <i class="bi bi-caret-up-fill" style="color: green;"></i>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endforeach

    </div>

    <div wire:loading>
        <div class="loading-overlay"></div>
        <div class="centered-spinner">
            <div class="spinner-border spinner-border-lg text-primary" role="status">
            </div>
        </div>
    </div>
</div>