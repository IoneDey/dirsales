<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <!-- <script src="{{ asset('js/formatAngka.js') }}"></script>
    <link href="{{ asset('css/style_alert_center_close.css') }}" rel="stylesheet" />
    <style>
        @media (max-width: 768px) {
            .input-group-item {
                flex: 1 1 100%;
                /* Item akan menjadi satu baris pada layar kecil */
            }
        }

        .input-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding: 10px;
            background-color: #f0f0f0;
            box-shadow: none !important;
        }

        .input-group-item {
            flex: 1 1 300px;
            display: flex;
            flex-direction: column;
            box-shadow: none !important;
            border-color: black;
        }

        .input-label {
            margin-bottom: 1px;
            font-weight: normal;
        }

        .custom-divider {
            height: 1px;
            background-color: blue;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 1);
            margin: 20px 0;
        }

        .full-width-input {
            width: 100%;
            box-sizing: border-box;
            /* ensures padding and border are included in the element's total width */
        }

        /* Additional styles for table */
        th,
        td {
            padding: 8px;
            /* Adjust padding as needed */
            text-align: left;
            /* Align text to the left */
        }

        /* untuk cari nota  */
        #search-input {
            display: block;
            width: 100%;
            box-sizing: border-box;
            /* ensures the width includes padding and border */
        }

        .search-results {
            position: absolute;
            top: 100%;
            /* Menempatkan hasil pencarian tepat di bawah input */
            left: 0;
            background: lightgray;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 255, 255, 0.5);
            z-index: 1000;
            max-height: 300px;
            overflow-y: auto;
            overflow-x: auto;
            width: 100%;
            box-sizing: border-box;
            /* ensures the width includes padding and border */
        }

        .result-table th,
        .result-table td {
            white-space: nowrap;
            /* Mencegah pembungkusan teks */
        }

        /* untuk option agar tinggi sesuai dan ada border */
        .form-check-inline-group {
            display: flex;
            align-items: center;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            padding: 0.375rem 0.75rem;
            height: calc(1.5em + 0.75rem + 2px);
            /* height of input field */
        }

        .form-check-inline-group .form-check {
            display: flex;
            align-items: center;
            margin-right: 10px;
        }

        .form-check-inline-group .form-check-input {
            margin-top: 0;
            margin-right: 5px;
            /* add some space between radio button and label */
        }

        .form-control,
        .form-check-inline-group {
            height: calc(1.5em + 0.75rem + 2px);
            /* height of input field */
        }
    </style> -->

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

        /* td */
        .rata-kanan {
            text-align: right;
        }

        /* td */
        .rata-tengah {
            text-align: center;
        }

        /* untuk cari nota  */
        #search-input {
            display: block;
            width: 100%;
            box-sizing: border-box;
            /* ensures the width includes padding and border */
        }

        .search-results {
            position: absolute;
            top: 100%;
            /* Menempatkan hasil pencarian tepat di bawah input */
            left: 15px;
            background: lightgray;
            /* border: 1px solid #ccc; */
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
            z-index: 1000;
            max-height: 300px;
            overflow-y: auto;
            overflow-x: auto;
            width: calc(100% - 30px);
            box-sizing: border-box;
            /* ensures the width includes padding and border */
        }

        .result-table th,
        .result-table td {
            white-space: nowrap;
            /* Mencegah pembungkusan teks */
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

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-3" style="position: relative;">
                        <span class="input-label">Nota/Customer</span>
                        <input wire:model.live="nota" type="text" class="form-control" id="search-input" placeholder="cari berdasakan nota / nama customer">
                        @error('nota')
                        <span style="font-size: smaller; color: red;">{{ $message }}</span>
                        @enderror
                        @if(!empty($results) && !$isNota)
                        <div id="search-results" class="search-results">
                            <table class="result-table table table-sm table-bordered table-striped table-hover" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Nota</th>
                                        <th>Nama Customer</th>
                                        <th>Alamat Customer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($results as $result)
                                    <tr wire:click="selectNota('{{ $result->timsetupid }}','{{ $result->nota }}')" style="cursor: pointer;">
                                        <td>{{ $result->nota }}</td>
                                        <td>{{ $result->customernama }}</td>
                                        <td>{{ $result->customeralamat }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>

                    <div class="col-md-6 col-lg-4 mb-3">
                        <span class="input-label">Tanggal Penjualan</span>
                        <input wire:model="tgljual" type="date" class="form-control" disabled>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <span class="input-label">Tim</span>
                        <input wire:model="tim" type="text" class="form-control" disabled>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <span class="input-label">PT</span>
                        <input wire:model="pt" type="text" class="form-control" disabled>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <span class="input-label">Kota</span>
                        <input wire:model="kota" type="text" class="form-control" disabled>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <span class="input-label">Nama Customer</span>
                        <input wire:model="customernama" type="text" class="form-control" disabled>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <span class="input-label">Alamat Customer</span>
                        <input wire:model="customeralamat" type="text" class="form-control" disabled>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <span class="input-label">Total Penjualan: {{ number_format(($totaljual ?? 0), 0, ',', '.') }}</span>
                        <input wire:model="totaljualRp" type="text" class="form-control" disabled>
                    </div>

                    <!-- info angsuran -->
                    <div class="card-header">
                        <div class="card-title">Informasi Angsuran</div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Ke</th>
                                        <th>Tgl Angsuran</th>
                                        <th class="rata-kanan">Angsuran</th>
                                        <th>Tgl Penagihan</th>
                                        <th class="rata-kanan">Jml Penagihan</th>
                                        <th>Nama Penagih</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dbInfoAngsuran as $item)
                                    <tr>
                                        <td>{{ $item->angsuranke }}</td>
                                        <td>{{ $item->tglangsuran }}</td>
                                        <td class="rata-kanan">{{ number_format(($item->perangsuran ?? 0), 0, ',', '.') }}</td>
                                        <td>{{ $item->tglpenagihan }}</td>
                                        <td class="rata-kanan">{{ number_format(($item->jmlpenagihan ?? 0), 0, ',', '.') }}</td>
                                        <td>{{ $item->namapenagih }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /info angsuran -->
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">

            <div class="card-header" id="card-barangretur">
                <div class="card-title">Input Barang Retur</div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-3">
                        <span class="input-label">Barang</span>
                        <input wire:model="namabarang" type="text" class="form-control" disabled>
                        @error('namabarang')
                        <span style="font-size: smaller; color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <span class="input-label">Jumlah Max Retur</span>
                        <input wire:model="maxretur" type="text" class="form-control" disabled>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <span class="input-label">Jenis Retur</span>
                        <div class="form-check-inline-group" style="border: 1px solid #e9ecef; border-radius: var(--bs-border-radius)">
                            <div class="form-check form-check-inline">
                                <input wire:model="optJenisRetur" class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="Paket">
                                <label class="form-check-label" for="inlineRadio1">Paket</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input wire:model="optJenisRetur" class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="Ecer">
                                <label class="form-check-label" for="inlineRadio2">Ecer</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4 mb-3">
                        <span class="input-label" id="tglretur">Tgl Retur</span>
                        <input wire:model="tglretur" type="date" class="form-control">
                        @error('tglretur')
                        <span style="font-size: smaller; color: red;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 col-lg-4 mb-3">
                        <span class="input-label">Qty Retur</span>
                        <input wire:model.live="qty" type="text" class="form-control">
                        @error('qty')
                        <span style="font-size: smaller; color: red;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 col-lg-4 mb-3" x-data=" { Harga: @entangle('harga') }">
                        <span class="input-label">@Harga</span>
                        <input wire:model.live="harga" type="text" inputmode="text" class="form-control text-right" x-model="Harga" x-on:input="formatAngka($event)">
                        @error('harga')
                        <span style="font-size: smaller; color: red;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 col-lg-4 mb-3">
                        <span class="input-label">Total Retur</span>
                        <input wire:model="totalretur" type="text" class="form-control" disabled>
                    </div>

                    <div class="col-md-6 col-lg-4 mb-3">
                        <span class="input-label" for="inputGroupFoto">Foto Faktur Retur</span>
                        <input wire:model="foto" accept="image/png, image/jpeg" type="file" class="form-control" id="inputGroupFoto">
                        <div wire:loading wire:target="foto">Uploading...</div>
                        @error('foto')
                        <span style="font-size: smaller; color: red;">{{ $message }}</span>
                        @enderror
                        @if (is_string($foto) && strlen($foto) > 0)
                        <img src="{{ asset('storage/' . $foto) }}" class="img-fluid rounded mx-auto d-block mt-2" alt="...">
                        @else
                        @if ($foto)
                        <img src="{{ $foto->temporaryUrl() }}" class="img-fluid rounded mx-auto d-block mt-2" alt="...">
                        @endif
                        @endif
                    </div>

                    <div class="card-action">
                        <button wire:click="simpan" type="button" class="btn btn-primary btn-round">Simpan</button>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="card-header">
                    <div class="card-title">Data Detail Barang Terjual</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Act</th>
                                    <th>Nama Paket</th>
                                    <th>Nama Barang</th>
                                    <th>Qty Barang</th>
                                    <th>Qty Retur</th>
                                    <th>Total Retur</th>
                                    <th>Qty Sisa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($dbDetailJuals)
                                @foreach($dbDetailJuals as $dbDetailJual)
                                <tr>
                                    <td>
                                        <a wire:click="getDataRetur({{ $dbDetailJual->timsetuppaketid }},{{ $dbDetailJual->barangid }})" type="button" title="Retur" href="#card-barangretur" class="badge bg-warning bg-sm"><i class="fas fa-edit fa-lg"></i></a>
                                    </td>
                                    <td>{{ $dbDetailJual->namapaket }} (<label>@</label>{{ number_format(($dbDetailJual->hargajual ?? 0), 0, ',', '.') }})</td>
                                    <td>{{ $dbDetailJual->namabarang }}</td>
                                    <td>{{ $dbDetailJual->jmljual }}</td>
                                    <td>{{ $dbDetailJual->qtyret }}</td>
                                    <td>{{ $dbDetailJual->totalret }}</td>
                                    <td>{{ $dbDetailJual->maxretur }}</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/formatAngka.js') }}"></script>
</div>
