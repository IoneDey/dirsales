<div>
    <!-- <link href="{{ asset('css/styles_table_res.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/style_alert_center_close.css') }}" rel="stylesheet" />
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
        table th,
        table td {
            white-space: nowrap;

        }

        .table-responsive {
            max-height: 72vh;
            overflow-y: auto;
            overflow-x: auto;
        }

        @media (max-height: 800px) {
            .table-responsive {
                max-height: 58vh;
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

    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
            <pre>{{ $error }}</pre>
            @endforeach
        </ul>
        <button wire:click="resetErrors" type="button" class="btn-close" data-bs-dismiss="alert" aria-label=""></button>
    </div>
    @endif

    @if(session()->has('ok'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <ul>
            <pre>{{ session('ok') }} </pre>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label=""></button>
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
            <div class="card-header">
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
                            <select x-data="{item: @entangle('timsetupid')}" x-init="$($refs.select2ref).select2(); $($refs.select2ref).on('change', function(){$wire.set('timsetupid', $(this).val());});" x-effect="$refs.select2ref.value = item; $($refs.select2ref).select2();" x-ref="select2ref" :disabled="isUpdate" class="form-select input-group-item" aria-label="Tim">
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
                </div>
            </div>

            <div class="card-header">
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-3">
                        <input class="form-control" wire:model.live.debounce.500ms="cari" type="text" id="cari" placeholder="cari nota/nama/no.telp ....">
                    </div>

                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Act</th>
                                        <th>Tim</th>
                                        <th>Nota</th>
                                        <th>Kota</th>
                                        <th>Kecamatan</th>
                                        <th>Tgl Jual</th>
                                        <th>Nama Customer</th>
                                        <th>Alamat Customer</th>
                                        <th>Telp Customer</th>
                                        <th>Share Loc</th>
                                        <th>Nama Sales</th>
                                        <th>Nama Lock</th>
                                        <th>Nama Driver</th>
                                        <th>PJ Kurir Nota</th>
                                        <th>PJ Admin Nota</th>
                                        <th class="rata-kanan">Tot Jumlah</th>
                                        <th>Barang</th>
                                        <th>Foto KTP</th>
                                        <th>Foto Nota</th>
                                        <th>Foto Nota Rekap</th>
                                        <th>Status</th>
                                        <th>User Entry</th>
                                        <th>Timestamp</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penjualanhds as $penjualanhd)
                                    <tr>
                                        <td>
                                            <a type="button" class="badge bg-warning bg-sm" href="{{ route('penjualanvalidasiedit', ['id' => $penjualanhd->id, 'tglAwal' => $tglAwal, 'tglAkhir' => $tglAkhir, 'cari' => $cari]) }}" title="Edit">
                                                <i class="fas fa-edit fa-lg"></i>
                                            </a>
                                            <a type="button" class="badge bg-success bg-sm" data-bs-toggle="modal" data-bs-target="#ModalValid" title="Validasi" wire:click="cekValidasi('{{ $penjualanhd->timsetupid }}','{{ $penjualanhd->nota }}')">
                                                <i class="fas fa-lock fa-lg"></i>
                                            </a>
                                        </td>
                                        <td>{{ $penjualanhd->joinTimSetup->jointim->nama }}</td>
                                        <td>{{ $penjualanhd->nota }}</td>
                                        <td>{{ $penjualanhd->joinTimSetup->joinkota->nama }}</td>
                                        <td>{{ $penjualanhd->kecamatan }}</td>
                                        <td>{{ $penjualanhd->tgljual }}</td>
                                        <td>{{ $penjualanhd->customernama }}</td>
                                        <td>{{ $penjualanhd->customeralamat }}</td>
                                        <td>{{ $penjualanhd->customernotelp }}</td>
                                        <td>{{ $penjualanhd->shareloc }}</td>
                                        <td>{{ $penjualanhd->namasales }}</td>
                                        <td>{{ $penjualanhd->namalock }}</td>
                                        <td>{{ $penjualanhd->namadriver }}</td>
                                        <td>{{ $penjualanhd->pjkolektornota }}</td>
                                        <td>{{ $penjualanhd->pjadminnota }}</td>
                                        <td class="rata-kanan">{{ number_format(($penjualanhd->hargajual_total ?? 0), 0, ',', '.') }}</td>
                                        <td>
                                            @foreach($penjualanhd->joinPenjualandt as $penjualandt)
                                            <li>
                                                {{ $penjualandt->joinTimSetupPaket->nama }} (Qty: {{ $penjualandt->jumlah+$penjualandt->jumlahkoreksi }})
                                                <ul>
                                                    @foreach($penjualandt->joinTimSetupPaket->joinTimSetupBarang as $barang)
                                                    <li>{{ $barang->joinBarang->nama }}</li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                            @endforeach
                                        </td>
                                        <td><a href="{{ asset('storage/' . $penjualanhd->fotoktp ) }}" target="_blank">{{ $penjualanhd->fotoktp }}</a></td>
                                        <td><a href="{{ asset('storage/' . $penjualanhd->fotonota ) }}" target="_blank">{{ $penjualanhd->fotonota }}</a></td>
                                        <td><a href="{{ asset('storage/' . $penjualanhd->fotonotarekap ) }}" target="_blank">{{ $penjualanhd->fotonotarekap }}</a></td>
                                        <td>{{ $penjualanhd->status }}</td>
                                        <td>{{ $penjualanhd->joinUser->name }}</td>
                                        <td>{{ $penjualanhd->updated_at }}</td>

                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="rata-kanan">Grand Total</td>
                                        <td class="rata-kanan">{{ number_format(($grandTotal->totaljual ?? 0), 0, ',', '.') }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="card-body">
                            {{ $penjualanhds->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- test wa dan spreadsheet -->
        @if (in_array(auth()->user()->roles ?? '', ['SUPERVISOR', 'SPV ADMIN']))
        <!-- <button wire:click="testSendWA"> test send wa</button> -->
        @endif
    </div>

    <!-- modal valid -->
    <div wire:ignore.self class="modal fade" id="ModalValid" tabindex="-1" aria-labelledby="ModalValidLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="ModalValidLabel">Validasi</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($validMessage != '')
                    {!! $validMessage !!}
                    @else
                    Anda yakin validasi Nota: {{ $nota }}?
                    @endif
                </div>
                <div class="modal-footer">
                    @if ($validMessage != '')
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                    @else
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button wire:click="valid()" type="button" class="btn btn-primary" data-bs-dismiss="modal">Yes</button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var myModal = document.getElementById('ModalValid');
            myModal.addEventListener('show.bs.modal', function() {
                // Clear modal content before showing
                var modalBody = myModal.querySelector('.modal-body');
                modalBody.innerHTML = ''; // Clearing modal body
                var modalFooter = myModal.querySelector('.modal-footer');
                modalFooter.innerHTML = ''; // Clearing modal body
            });
        });
    </script>
</div>
