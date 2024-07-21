<div>
    <link href="{{ asset('css/styles_table_res.css') }}" rel="stylesheet" />
    <style>
        /* untuk tabel scroll */
        table th,
        table td {
            white-space: nowrap;
        }

        .table-responsive {
            max-height: 80vh;
            overflow-y: auto;
            overflow-x: auto;
        }

        @media (max-height: 800px) {
            .table-responsive {
                max-height: 72vh;
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

        .angsuran-ganjil {
            background-color: #f2f2f2 !important;
            /* Warna latar belakang untuk angsuran ganjil */
        }

        .angsuran-genap {
            background-color: #e6e6e6 !important;
            /* Warna latar belakang untuk angsuran genap */
        }
    </style>
    {{-- The Master doesn't talk, he acts. --}}
    <div class="container">
        <h2 class="text-center">{{ $title }}</h2>

        <div class="row justify-content-center">
            <div class="col-md-3 col-12 mb-1 p-1 g-0">
                <div class="input-group">
                    <span class="input-group-text">Tgl Angsuran</span>
                    <input wire:model.live.debounce.500ms="tglangsuran" type="date" class="form-control" aria-label="Tgl Awal">
                </div>
            </div>

            <div class="col-md-3 col-12 mb-1 p-1 g-0">
                <div class="input-group">
                    <span class="input-group-text">Mode</span>
                    <select class="form-select" wire:model.live.debounce.500ms="mode">
                        <option value="row">row</option>
                        <option value="column">column</option>
                    </select>
                </div>
            </div>

            <div class="col-md-3 col-12 mb-1 p-1 g-0">
                <div class="input-group">
                    <span class="input-group-text">Filter Nota</span>
                    <textarea wire:model.live.debounce.500ms="notasString" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
            </div>

        </div>

        <div class="table-responsive">
            @if ($mode=="row")
            <table class="table table-sm table-bordered table-striped table-hover" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Tim</th>
                        <th>Nota</th>
                        <th>Customer Nama</th>
                        <th>Customer Alamat</th>
                        <th>PJ Kurir Nota</th>
                        <th>PJ Admin Nota</th>
                        <th>Tanggal Jual</th>
                        <th>Angsuran Hari</th>
                        <th>Angsuran Periode</th>
                        <th>Omset</th>
                        <th>Per Angsuran</th>
                        <th>Ke</th>
                        <th>Angsuran Date</th>
                        <th>Penagihan Date</th>
                        <th>H</th>
                        <th>Penagihan</th>
                        <th>Retur</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $row)
                    <tr>
                        <td>{{ $row->tim }}</td>
                        <td>{{ $row->nota }}</td>
                        <td>{{ $row->customernama }}</td>
                        <td>{{ $row->customeralamat }}</td>
                        <td>{{ $row->pjkolektornota }}</td>
                        <td>{{ $row->pjadminnota }}</td>
                        <td>{{ $row->tgljual }}</td>
                        <td>{{ $row->angsuranhari }}</td>
                        <td>{{ $row->angsuranperiode }}</td>
                        <td class="rata-kanan">{{ number_format(($row->omset ?? 0), 0, ',', '.') }}</td>
                        <td class="rata-kanan">{{ number_format(($row->perangsuran ?? 0), 0, ',', '.') }}</td>
                        <td>{{ $row->Ke }}</td>
                        <td class="angsuran-ganjil">{{ $row->angsuran_date }}</td>
                        <td class="angsuran-ganjil">{{ $row->penagihan_date }}</td>
                        <td class="angsuran-ganjil">{{ $row->h }}</td>
                        <td class="angsuran-ganjil rata-kanan">{{ number_format(($row->penagihan ?? 0), 0, ',', '.') }}</td>
                        <td class="angsuran-ganjil rata-kanan">{{ number_format(($row->retur ?? 0), 0, ',', '.') }}</td>
                        <td class="angsuran-ganjil rata-kanan">{{ number_format(($row->A ?? 0), 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif

            @if ($mode=="column")
            <table class="table table-sm table-bordered table-striped table-hover" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Tim</th>
                        <th>Nota</th>
                        <th>Customer Nama</th>
                        <th>Customer Alamat</th>
                        <th>PJ Kurir Nota</th>
                        <th>PJ Admin Nota</th>
                        <th>Tanggal Jual</th>
                        <th>Angsuran Hari</th>
                        <th>Angsuran Periode</th>
                        <th>Omset</th>
                        <th>Per Angsuran</th>
                        <th>Penagihan 0</th>
                        <th>Angsuran Date 1</th>
                        <th>Penagihan 1 Date</th>
                        <th>H1</th>
                        <th>Penagihan 1</th>
                        <th>Retur 1</th>
                        <th>A1</th>
                        <th>Angsuran Date 2</th>
                        <th>Penagihan 2 Date</th>
                        <th>H2</th>
                        <th>Penagihan 2</th>
                        <th>Retur 2</th>
                        <th>A2</th>
                        <th>Angsuran Date 3</th>
                        <th>Penagihan 3 Date</th>
                        <th>H3</th>
                        <th>Penagihan 3</th>
                        <th>Retur 3</th>
                        <th>A3</th>
                        <th>Angsuran Date 4</th>
                        <th>Penagihan 4 Date</th>
                        <th>H4</th>
                        <th>Penagihan 4</th>
                        <th>Retur 4</th>
                        <th>A4</th>
                        <th>Angsuran Date 5</th>
                        <th>Penagihan 5 Date</th>
                        <th>H5</th>
                        <th>Penagihan 5</th>
                        <th>Retur 5</th>
                        <th>A5</th>
                        <th>Angsuran Date 6</th>
                        <th>Penagihan 6 Date</th>
                        <th>H6</th>
                        <th>Penagihan 6</th>
                        <th>Retur 6</th>
                        <th>A6</th>
                        <th>Angsuran Date 7</th>
                        <th>H7</th>
                        <th>Penagihan 7</th>
                        <th>Retur 7</th>
                        <th>A7</th>
                        <th>Angsuran Date 8</th>
                        <th>Penagihan 8 Date</th>
                        <th>H8</th>
                        <th>Penagihan 8</th>
                        <th>Retur 8</th>
                        <th>A8</th>
                        <th>Penagihan X</th>
                        <th>Total Tagihan</th>
                        <th>Total Retur</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $row)
                    <tr>
                        <td>{{ $row->tim }}</td>
                        <td>{{ $row->nota }}</td>
                        <td>{{ $row->customernama }}</td>
                        <td>{{ $row->customeralamat }}</td>
                        <td>{{ $row->pjkolektornota }}</td>
                        <td>{{ $row->pjadminnota }}</td>
                        <td>{{ $row->tgljual }}</td>
                        <td>{{ $row->angsuranhari }}</td>
                        <td>{{ $row->angsuranperiode }}</td>
                        <td class="rata-kanan">{{ number_format(($row->omset ?? 0), 0, ',', '.') }}</td>
                        <td class="rata-kanan">{{ number_format(($row->perangsuran ?? 0), 0, ',', '.') }}</td>
                        <td class="rata-kanan">{{ number_format(($row->penagihan_0 ?? 0), 0, ',', '.') }}</td>
                        <td class="angsuran-ganjil">{{ $row->angsuran_date_1 }}</td>
                        <td class="angsuran-ganjil">{{ $row->Penagihan_1_date }}</td>
                        <td class="angsuran-ganjil">{{ $row->h1 }}</td>
                        <td class="angsuran-ganjil rata-kanan">{{ number_format(($row->penagihan_1 ?? 0), 0, ',', '.') }}</td>
                        <td class="angsuran-ganjil rata-kanan">{{ number_format(($row->retur_1 ?? 0), 0, ',', '.') }}</td>
                        <td class="angsuran-ganjil rata-kanan">{{ number_format(($row->A1 ?? 0), 0, ',', '.') }}</td>
                        <td>{{ $row->angsuran_date_2 }}</td>
                        <td>{{ $row->Penagihan_2_date }}</td>
                        <td>{{ $row->h2 }}</td>
                        <td class="rata-kanan">{{ number_format(($row->penagihan_2 ?? 0), 0, ',', '.') }}</td>
                        <td class="rata-kanan">{{ number_format(($row->retur_2 ?? 0), 0, ',', '.') }}</td>
                        <td class="rata-kanan">{{ number_format(($row->A2 ?? 0), 0, ',', '.') }}</td>
                        <td class="angsuran-ganjil">{{ $row->angsuran_date_3 }}</td>
                        <td class="angsuran-ganjil">{{ $row->Penagihan_3_date }}</td>
                        <td class="angsuran-ganjil">{{ $row->h3 }}</td>
                        <td class="angsuran-ganjil rata-kanan">{{ number_format(($row->penagihan_3 ?? 0), 0, ',', '.') }}</td>
                        <td class="angsuran-ganjil rata-kanan">{{ number_format(($row->retur_3 ?? 0), 0, ',', '.') }}</td>
                        <td class="angsuran-ganjil rata-kanan">{{ number_format(($row->A3 ?? 0), 0, ',', '.') }}</td>
                        <td>{{ $row->angsuran_date_4 }}</td>
                        <td>{{ $row->Penagihan_4_date }}</td>
                        <td>{{ $row->h4 }}</td>
                        <td class="rata-kanan">{{ number_format(($row->penagihan_4 ?? 0), 0, ',', '.') }}</td>
                        <td class="rata-kanan">{{ number_format(($row->retur_4 ?? 0), 0, ',', '.') }}</td>
                        <td class="rata-kanan">{{ number_format(($row->A4 ?? 0), 0, ',', '.') }}</td>
                        <td class="angsuran-ganjil">{{ $row->angsuran_date_5 }}</td>
                        <td class="angsuran-ganjil">{{ $row->Penagihan_5_date }}</td>
                        <td class="angsuran-ganjil">{{ $row->h5 }}</td>
                        <td class="angsuran-ganjil rata-kanan">{{ number_format(($row->penagihan_5 ?? 0), 0, ',', '.') }}</td>
                        <td class="angsuran-ganjil rata-kanan">{{ number_format(($row->retur_5 ?? 0), 0, ',', '.') }}</td>
                        <td class="angsuran-ganjil rata-kanan">{{ number_format(($row->A5 ?? 0), 0, ',', '.') }}</td>
                        <td>{{ $row->angsuran_date_6 }}</td>
                        <td>{{ $row->Penagihan_6_date }}</td>
                        <td>{{ $row->h6 }}</td>
                        <td class="rata-kanan">{{ number_format(($row->penagihan_6 ?? 0), 0, ',', '.') }}</td>
                        <td class="rata-kanan">{{ number_format(($row->retur_6 ?? 0), 0, ',', '.') }}</td>
                        <td class="rata-kanan">{{ number_format(($row->A6 ?? 0), 0, ',', '.') }}</td>
                        <td class="angsuran-ganjil">{{ $row->angsuran_date_7 }}</td>
                        <td class="angsuran-ganjil">{{ $row->h7 }}</td>
                        <td class="angsuran-ganjil rata-kanan">{{ number_format(($row->penagihan_7 ?? 0), 0, ',', '.') }}</td>
                        <td class="angsuran-ganjil rata-kanan">{{ number_format(($row->retur_7 ?? 0), 0, ',', '.') }}</td>
                        <td class="angsuran-ganjil rata-kanan">{{ number_format(($row->A7 ?? 0), 0, ',', '.') }}</td>
                        <td>{{ $row->angsuran_date_8 }}</td>
                        <td>{{ $row->Penagihan_8_date }}</td>
                        <td>{{ $row->h8 }}</td>
                        <td class="rata-kanan">{{ number_format(($row->penagihan_8 ?? 0), 0, ',', '.') }}</td>
                        <td class="rata-kanan">{{ number_format(($row->retur_8 ?? 0), 0, ',', '.') }}</td>
                        <td class="rata-kanan">{{ number_format(($row->A8 ?? 0), 0, ',', '.') }}</td>
                        <td class="angsuran-genap rata-kanan">{{ number_format(($row->penagihan_x ?? 0), 0, ',', '.') }}</td>
                        <td class="angsuran-genap rata-kanan">{{ number_format(($row->TotTagihan ?? 0), 0, ',', '.') }}</td>
                        <td class="angsuran-genap rata-kanan">{{ number_format(($row->TotRetur ?? 0), 0, ',', '.') }}</td>
                        <td class="angsuran-genap rata-kanan">{{ number_format(($row->Total ?? 0), 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif

        </div>
        @if (in_array(auth()->user()->roles ?? '', ['SUPERVISOR', 'SPV ADMIN']))
        <button wire:click="exportExcel" wire:loading.attr="disabled" class="badge bg-success bg-sm d-flex justify-content-center align-items-center custom-hover mt-2" type="button" title="Export Excel">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-spreadsheet" viewBox="0 0 16 16">
                <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5zM3 12v-2h2v2zm0 1h2v2H4a1 1 0 0 1-1-1zm3 2v-2h3v2zm4 0v-2h3v1a1 1 0 0 1-1 1zm3-3h-3v-2h3zm-7 0v-2h3v2z" />
            </svg>
        </button>
        @endif
    </div>
</div>