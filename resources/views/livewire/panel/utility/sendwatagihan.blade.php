<div>
    {{-- The best athlete wants his opponent at his best. --}}
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <link href="{{ asset('new/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('new/css/nucleo-svg.css') }}" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link id="pagestyle" href="{{ asset('new/css/material-dashboard.css?v=3.1.0') }}" rel="stylesheet" />
    <link href="{{ asset('old/css/styleSelect2.css') }}" rel="stylesheet" />
    <link href="{{ asset('old/css/styles_table_res.css') }}" rel="stylesheet" />

    <style>
        .input-group {
            display: flex;
            width: 100% !important;
            background-color: #f0f0f0;
            box-shadow: none !important;
            border-radius: 5px !important;
            border: 2px solid #cacaca;
        }

        .input-group-text {
            position: relative !important;
            width: 40% !important;
            padding: 0.375rem 0.5rem !important;
        }

        .justify-content-center {
            justify-content: center !important;
            align-items: center !important;
        }

        .input-group select {
            width: 60% !important;
            padding: 0.375rem 0.5rem;
            background-color: #fff !important;
        }

        .input-group .select2 {
            width: 60% !important;
            background-color: #fff !important;
        }

        .form-control {
            width: 60% !important;
            padding: 0.375rem 0.5rem;
            background-color: #fff !important;
        }

        .input-group textarea {
            width: 60% !important;
            padding: 0.375rem 0.5rem;
            border-radius: 5px !important;
            opacity: 0.6;
        }

        /* untuk tabel scroll */
        table th,
        table td {
            white-space: nowrap;
        }

        .table-responsive {
            max-height: 50vh;
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
            background: #a7b9b1 !important;
            z-index: 10;
            color: #000;
        }

        td {
            position: relative !important;
            z-index: 1 !important;
            border-bottom: 1px solid #cacaca;
        }

        tr:nth-child(odd) td {
            background-color: #c7dbd2;
        }

        tr:nth-child(even) td {
            background-color: #a7b9b1;
        }

        thead,
        tbody,
        tfoot,
        tr,
        td,
        th {
            text-align: center;
        }

        .td-center {
            text-align: end !important;
        }

        .td-kanan {
            text-align: end !important;
        }

        .rata-kiri {
            text-align: start !important;
        }

        .card {
            box-shadow: 5px 4px 10px 0px rgba(0, 0, 0, 0.2), 0 2px 4px -1px rgba(0, 0, 0, 0.1) !important;
        }

        input,
        button,
        select,
        optgroup,
        textarea {
            margin: 0;
            font-family: inherit;
            font-size: inherit;
            line-height: inherit;
            border-radius: 10px;
            padding: 0 10px;
            border: 2px solid #cacaca;
        }

        .input-custom {
            margin-bottom: 10px !important;
            position: relative !important;
        }

        .input-custom input {
            width: 100%;
            height: 100%;
            padding-left: 40px;
            padding-top: 8px;
            padding-bottom: 8px;
            padding-right: 8px;
            font-size: 18px;
            margin-left: 5px;
        }

        .input-custom i {
            position: absolute;
            top: 3px;
            left: 10px;
            font-size: 22px;
            cursor: pointer;
        }

        .badge.bg-primary {
            background: rgba(0, 0, 255, 1) !important;
            border-radius: 50% !important;
        }

        .bg-gradient-primary {
            background-image: linear-gradient(195deg, #d1e7dd 0%, #a7b9b1 100%);
        }

        .shadow-primary {
            box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgba(233, 30, 99, 0.4) !important;
        }
    </style>

    <div class="container">
        <h2 class="text-center">{{ $title }}</h2>

        <div class="container-fluid">
            <div class="card my-3 bg-gray-200">
                <div class="row justify-content-center mt-2">
                    <div class="col-md-3 col-12 mb-1 p-1 g-0">
                        <div class="input-group" x-data="{ isUpdate: @entangle('isUpdate') }" wire:ignore>
                            <span class="input-group-text">Tim</span>
                            <select x-data="{item: @entangle('timsetupid')}" x-init="$($refs.select2ref).select2(); $($refs.select2ref).on('change', function(){$wire.set('timsetupid', $(this).val());});" x-effect="$refs.select2ref.value = item; $($refs.select2ref).select2();" x-ref="select2ref" :disabled="isUpdate" class="form-select" aria-label="Tim">
                                <option value=''></option>
                                @foreach ($dbTimsetups as $dbTimsetup)
                                <option value="{{ $dbTimsetup->id }}">{{ $dbTimsetup->joinTim->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('timsetupid')
                        <span style="font-size: smaller; color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-3 col-12 mb-1 p-1 g-0">
                        <div class="input-group">
                            <span class="input-group-text">Tgl Angsuran</span>
                            <input wire:model.live.debounce.500ms="tglangsuran" type="date" class="form-control" aria-label="Tgl Awal">
                        </div>
                    </div>

                    <div class="col-md-3 col-12 mb-1 p-1 g-0">

                        <div class="input-group">
                            <span class="input-group-text">Surveyor</span>
                            <select wire:model="waNumberKey" name="wanumber" id="wanumber" class="form-control">
                                <option value="gRGKgrAvjMBALPaP">Gandhi</option>
                                <option value="XquzwRWepBwQ1DoK">Riski</option>
                                <option value="If320nKuXNaWj3Iq">Gusti</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-3 col-12 mb-1 p-1 g-0">
                        <div class="input-group">
                            <span class="input-group-text">Test Send</span>
                            <input wire:model.live="nohptest" type="text" class="form-control" aria-label="notest" placeholder="ex: 6287701666286">
                        </div>
                    </div>

                    <div class="col-md-3 col-12 mb-1 p-1 g-0">
                        <div class="input-group">
                            <span class="input-group-text">Filter Nota</span>
                            <textarea wire:model.live.debounce.500ms="notasString" id="exampleFormControlTextarea1" rows="2" placeholder="ex: 24-07-2024-0003,24-07-2024-0004,24-07-2024-0007 ..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4 bg-gray-200">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-black text-capitalize ps-3">List Data</h6>
                                <div class="col-md-6 col-12 mt-1 input-custom">
                                    <i class="bi bi-search"></i>
                                    <input class="border rounded" wire:model.live.debounce.500ms="cari" type="text" id="cari" placeholder="cari surveyor/nota/nama ....">
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Act</th>
                                            <th>Status</th>
                                            <th>Cat. Tambahan</th>
                                            <th>Surveyor</th>
                                            <th>Tim</th>
                                            <th>Nota</th>
                                            <th>Customer Nama</th>
                                            <th>Customer Alamat</th>
                                            <th>Customer Telp</th>
                                            <th>Tanggal Jual</th>
                                            <th>Jumlah</th>
                                            <th>Penjualan</th>
                                            <th>Per Angsuran</th>
                                            <th>Ke</th>
                                            <th>Angsuran Date</th>
                                            <th>H</th>
                                            <th>Penagihan</th>
                                            <th>Retur</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($datas as $row)
                                        <tr>
                                            <td><button data-bs-toggle="modal" data-bs-target="#ModalSendWa1" wire:click="sendWA1Confirm('{{ $row->tim }}','{{ $row->nota }}')" wire:loading.attr="disabled" class="badge bg-primary bg-sm" type="button" class="btn btn-primary mt-2"><i class="bi bi-send"></i></button></td>
                                            <td>{{ $row->status }}</td>
                                            <td><input wire:model="cattambahan.{{ $row->tim }}{{ $row->nota }}" type="text" /></td>
                                            <td>{{ $row->namasurveyors }}</td>
                                            <td class="rata-kiri">{{ $row->tim }}</td>
                                            <td class="rata-kiri">{{ $row->nota }}</td>
                                            <td class="rata-kiri">{{ $row->customernama }}</td>
                                            <td class="rata-kiri">{{ $row->customeralamat }}</td>
                                            <td class="rata-kiri">{{ $row->customernotelp }}</td>
                                            <td>{{ $row->tgljual }}</td>
                                            <td>{{ $row->jumlah }}</td>
                                            <td class="rata-kanan">{{ number_format(($row->omset ?? 0), 0, ',', '.') }}</td>
                                            <td class="rata-kanan">{{ number_format(($row->perangsuran ?? 0), 0, ',', '.') }}</td>
                                            <td>{{ $row->Ke }}</td>
                                            <td class="angsuran-ganjil">{{ $row->angsuran_date }}</td>
                                            <td class="angsuran-ganjil">{{ $row->h }}</td>
                                            <td class="angsuran-ganjil rata-kanan">{{ number_format(($row->penagihan ?? 0), 0, ',', '.') }}</td>
                                            <td class="angsuran-ganjil rata-kanan">{{ number_format(($row->retur ?? 0), 0, ',', '.') }}</td>
                                            <td class="angsuran-ganjil rata-kanan">{{ number_format(($row->A ?? 0), 0, ',', '.') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalSendWaAll">Send All</button>
    </div>


    <!-- modal -->
    <div wire:ignore.self class="modal fade" id="ModalSendWa1" tabindex="-1" aria-labelledby="ModalSendWa1Label" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="ModalSendWa1Label">Send WA</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Anda yakin kirim wa ke no: {{ $nohptujuan1 }}?
                    <br>
                    {!! nl2br(e($messagewa1)) !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button wire:click="sendWA1" type="button" class="btn btn-primary" data-bs-dismiss="modal">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- all data in grid -->
    <div wire:ignore.self class="modal fade" id="ModalSendWaAll" tabindex="-1" aria-labelledby="ModalSendWaAllLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="ModalDeleteLabel">Send WA All</h1>
                    <button wire:click="clearPaket" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Anda yakin kirim semua wa?
                </div>
                <div class="modal-footer">
                    <button wire:click="" type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button wire:click="sendWA" type="button" class="btn btn-primary" data-bs-dismiss="modal">Yes</button>
                </div>
            </div>
        </div>
    </div>
</div>
