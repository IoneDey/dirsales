<div>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    <!-- <link href="{{ asset('css/styles_table_res.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/styleSelect2.css') }}" rel="stylesheet" />
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

        table {
            border-collapse: collapse;
            /* Menghilangkan jarak antara border sel */
            width: 100%;
            /* Pastikan tabel memenuhi lebar kontainer */
        }

        table th,
        table td {
            white-space: nowrap;
            border: 1px solid #dee2e6;
            /* Menambahkan border pada sel tabel */
        }

        /* Kontainer tabel */
        .table-container {
            overflow: hidden;
            /* Menghilangkan scroll dari kontainer tabel */
        }

        .table-responsive {
            max-height: 42vh;
            overflow-y: auto;
            /* Scroll vertikal */
            overflow-x: auto;
            /* Scroll horizontal */
            display: block;
            /* Memastikan scroll bekerja */
            position: relative;
            /* Menyediakan positioning untuk elemen sticky */
        }

        /* Header tabel */
        thead th {
            position: sticky;
            top: 0;
            background-color: #f8f9fa;
            /* Pastikan background color diterapkan */
            z-index: 10;
            /* Pastikan z-index lebih tinggi */
            box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
            /* Menambahkan shadow untuk visualisasi */
        }

        /* Kolom pertama tetap terlihat */
        table td:first-child,
        table th:first-child {
            position: sticky;
            left: 0;
            background-color: #f8f9fa;
            z-index: 5;
            box-shadow: 2px 0 2px -1px rgba(0, 0, 0, 0.4);
        }

        /* Tambahan khusus untuk area pertemuan */
        table th:first-child {
            z-index: 15;
        }

        /* Header Tidak ikut scroll */
        thead th:not(:first-child) {
            position: sticky;
            top: 0;
            background-color: #f8f9fa;
            z-index: 9;
        }
    </style> -->

    <link href="{{ asset('css/select2.css') }}" rel="stylesheet" />

    <style>
        /* batasan heigh */
        .table-responsive {
            max-height: 50vh;
            overflow-y: auto;
            overflow-x: auto;
        }

        /* Header tetap terlihat */
        thead th {
            position: sticky;
            top: 0;
            background-color: #f8f9fa;
            z-index: 10;
            box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
        }

        /* Kolom pertama tetap terlihat */
        table td:first-child,
        table th:first-child {
            position: sticky;
            left: 0;
            background-color: #f8f9fa;
            z-index: 5;
            box-shadow: 2px 0 2px -1px rgba(0, 0, 0, 0.4);
        }

        /* Tambahan khusus untuk area pertemuan */
        table th:first-child {
            z-index: 15;
        }

        /* Tambahan khusus untu Header Tidak ikut scroll */
        thead th:not(:first-child) {
            position: sticky;
            top: 0;
            background-color: #f8f9fa;
            z-index: 9;
        }

        .rata-kanan {
            text-align: right;
        }

        .rata-tengah {
            text-align: center;
        }
    </style>

    @if(session()->has('ok'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <ul>
            <pre>{{ session('ok') }} </pre>
        </ul>
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label=""></button>
    </div>
    @endif

    @if(session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul>
            <pre>{{ session('error') }} </pre>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label=""></button>
    </div>
    @endif

    <div class="card">
        <div class="col-md-12">
            <div class="card-body">
                <div class="row">

                    <div class="col-md-6 col-lg-4 mb-3">
                        <span class="input-label">Tgl Awal</span>
                        <input wire:model.live.debounce.500ms="tglAwal" type="date" class="form-control" aria-label="Tgl Awal">
                    </div>

                    <div class="col-md-6 col-lg-4 mb-3">
                        <span class="input-label">Tgl Akhir</span>
                        <input wire:model.live.debounce.500ms="tglAkhir" type="date" class="form-control" aria-label="Tgl Akhir">
                    </div>

                    <div class="col-md-6 col-lg-4 mb-3">
                        <div x-data="{ isUpdate: @entangle('isUpdate') }" wire:ignore>
                            <span class="input-label">Tim</span>
                            <select multiple="multiple" x-data="{item: @entangle('timsetupid')}" x-init="
                                $($refs.select2ref).select2({ closeOnSelect: false });
                                $($refs.select2ref).on('change', function() {
                                $wire.set('timsetupid', $(this).val());
                                });
                                " x-effect="$($refs.select2ref).val(item).trigger('change')" x-ref="select2ref" :disabled="isUpdate" class="form-select" aria-label="Tim">
                                @foreach ($dbTimsetups as $dbTimsetup)
                                <option value="{{ $dbTimsetup->id }}">{{ $dbTimsetup->joinTim->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('timsetupid')
                        <span style="font-size: smaller; color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="col-md-12">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-3">
                        <input class="form-control" wire:model.live.debounce.500ms="cari" type="text" id="cari" placeholder="cari nota/nama ....">
                    </div>

                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Act</th>
                                        <th>Tim</th>
                                        <th>Timestamp</th>
                                        <th>Nota</th>
                                        <th>Nama Customer</th>
                                        <th>Tgl Penagihan</th>
                                        <th>Nama Penagih</th>
                                        <th>Foto Kwitansi</th>
                                        <th class="rata-kanan">Jumlah Pembayaran</th>
                                        <th class="rata-kanan">Biaya Komisi</th>
                                        <th class="rata-kanan">Biaya Admin</th>
                                        <th class="rata-kanan">Total</th>
                                        <th> User Entry</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penagihans as $penagihan)
                                    <tr>
                                        <td>
                                            @if ((auth()->user()->roles ?? '')== 'SUPERVISOR')
                                            <a type="button" class="badge bg-warning bg-sm" href="{{ route('penagihan', ['id' => $penagihan->id, 'tglAwal' => $tglAwal, 'tglAkhir' => $tglAkhir, 'cari' => $cari, 'timsetupid' => $timsetupid]) }}" title="Edit">
                                                <i class="fas fa-edit fa-lg"></i>
                                            </a>
                                            @endif
                                        </td>
                                        <td>{{ $penagihan->tim }}</td>
                                        <td>{{ $penagihan->created_at }}</td>
                                        <td><a href="#" wire:click.prevent="$dispatch('showNotaDetails', { timsetupid: {{ $penagihan->timsetupid }}, nota: '{{ $penagihan->nota }}' })">{{ $penagihan->nota }}</a></td>
                                        <td>{{ $penagihan->customernama }}</td>
                                        <td>{{ $penagihan->tglpenagihan }}</td>
                                        <td>{{ $penagihan->namapenagih }}</td>
                                        <td><a href="{{ asset('storage/' . $penagihan->fotokwitansi ) }}" target="_blank">{{ $penagihan->fotokwitansi }}</a></td>
                                        <td class="rata-kanan">{{ number_format(($penagihan->jumlahbayar ?? 0), 0, ',', '.') }}</td>
                                        <td class="rata-kanan">{{ number_format(($penagihan->biayakomisi ?? 0), 0, ',', '.') }}</td>
                                        <td class="rata-kanan">{{ number_format(($penagihan->biayaadmin ?? 0), 0, ',', '.') }}</td>
                                        <td class="rata-kanan">{{ number_format(($penagihan->total ?? 0), 0, ',', '.') }}</td>
                                        <td>{{ $penagihan->name }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td>#{{ $penagihans->count() }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="rata-kanan"></td>
                                        <td class="rata-kanan"></td>
                                        <td class="rata-kanan"></td>
                                        <td class="rata-kanan">{{ number_format(($penagihanTotal->total ?? 0), 0, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="card-body">
                            {{ $penagihans->links() }}
                        </div>
                    </div>
                </div>

                @if (in_array(auth()->user()->roles ?? '', ['SUPERVISOR', 'SPV ADMIN']))
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <button wire:click="exportExcel" wire:loading.attr="disabled" class="badge bg-success bg-sm" type="button" title="Export Excel">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-spreadsheet" viewBox="0 0 16 16">
                                    <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5zM3 12v-2h2v2zm0 1h2v2H4a1 1 0 0 1-1-1zm3 2v-2h3v2zm4 0v-2h3v1a1 1 0 0 1-1 1zm3-3h-3v-2h3zm-7 0v-2h3v2z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <livewire:main.notadetails />
</div>