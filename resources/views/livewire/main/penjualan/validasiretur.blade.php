<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <!-- <link href="{{ asset('css/styleSelect2.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/styles_table_res.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/style_alert_center_close.css') }}" rel="stylesheet" />
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
            max-height: 58vh;
            overflow-y: auto;
            overflow-x: auto;
        }

        @media (max-height: 800px) {
            .table-responsive {
                max-height: 34vh;
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

        .input-group-det {
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
                        <div x-data="{ isUpdate: @entangle('isUpdate') }" wire:ignore>
                            <span class="input-label">Tim</span>
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

                    <div class="col-md-6 col-lg-4 mb-3">
                        <span class="input-label">Tgl Awal</span>
                        <input wire:model.live.debounce.500ms="tglAwal" type="date" class="form-control" aria-label="Tgl Awal">
                    </div>

                    <div class="col-md-6 col-lg-4 mb-3">
                        <span class="input-label">Tgl Akhir</span>
                        <input wire:model.live.debounce.500ms="tglAkhir" type="date" class="form-control" aria-label="Tgl Awal">
                    </div>
                </div>

                <div class="separator-solid"></div>

                <!-- cari -->
                <div class="row">
                    <div class="card-header">
                        <div class="card-title">Daftar Retur - Klik Nota yang akan divalidasi.</div>
                    </div>

                    <div class="col-md-6 col-lg-4 mt-2">
                        <input class="form-control" wire:model.live.debounce.500ms="cari" type="text" id="cari" placeholder="cari nota/nama ....">
                    </div>

                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Nota</th>
                                        <th>Tim</th>
                                        <th>Tgl Retur</th>
                                        <th>No. Retur</th>
                                        <th>Nama Customer</th>
                                        <th>Foto Retur</th>
                                        <th class="rata-kanan">Qty Retur</th>
                                        <th class="rata-kanan">Total Retur</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dblistretur as $penjualanretur)
                                    @php
                                    $isSame = ($penjualanretur->tglretur == $targetTglRetur &&
                                    $penjualanretur->timsetupid == $targetTimSetupId &&
                                    $penjualanretur->noretur == $targetnoretur &&
                                    $penjualanretur->nota == $targetNota);

                                    $style = $isSame ? "background-color: yellow;" : ""; // Ganti warna sesuai kebutuhan
                                    @endphp
                                    <tr>
                                        <td wire:click="selectNota('{{ $penjualanretur->tglretur }}','{{ $penjualanretur->timsetupid }}','{{ $penjualanretur->nota }}','{{ $penjualanretur->noretur }}','{{ $penjualanretur->userid }}')" style="cursor: pointer; {{ $style }}">{{ $penjualanretur->nota }}</td>
                                        <td>{{ $penjualanretur->tim }}</td>
                                        <td>{{ $penjualanretur->tglretur }}</td>
                                        <td>{{ $penjualanretur->noretur }}</td>
                                        <td>{{ $penjualanretur->customernama }}</td>
                                        <td><a target="_blank" href="{{ asset('storage/' . $penjualanretur->foto ) }}">{{ $penjualanretur->foto }}</a></td>
                                        <td class="rata-kanan">{{ $penjualanretur->qtyretur }}</td>
                                        <td class="rata-kanan">{{ number_format(($penjualanretur->totalretur ?? 0), 0, ',', '.') }}</td>
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

    <div class="card">
        <div class="col-md-12">

            <div class="card-header">
                <div class="card-title">Detail Retur: {{ $targetNota }}</div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-lg-4 mt-2">
                        <span class="input-label">Tgl Valid</span>
                        <input wire:model.live.debounce.500ms="tglvalid" type="date" class="form-control" aria-label="Tgl Valid">
                        @error('tglvalid')
                        <span style="font-size: smaller; color: red;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 col-lg-4 mt-2">
                        <span class="input-label">Kondisi Barang</span>
                        <input wire:model.live.debounce.500ms="kondisi" type="text" class="form-control" aria-label="Kondisi Barang">
                        @error('kondisi')
                        <span style="font-size: smaller; color: red;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 col-lg-4 mt-2">
                        <span class="input-label">Gudang</span>
                        <select wire:model.live.debounce.500ms="gudang" type="text" class="form-control" aria-label="Gudang">
                            <option value="Gudang DS">Gudang DS</option>
                            <option value="Gudang Pusat">Gudang Pusat</option>
                        </select>
                        @error('gudang')
                        <span style="font-size: smaller; color: red;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 col-lg-4 mt-2">
                        <span class="input-label">Catatan</span>
                        <input wire:model.live.debounce.500ms="catatan" type="text" class="form-control" aria-label="Catatan" rows="2">
                        @error('catatan')
                        <span style="font-size: smaller; color: red;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 col-lg-4 mt-2">
                        <span class="input-label" for="inputGroupKTP">Foto Valid</span>
                        <input wire:model="fotovalid" accept="image/png, image/jpeg" type="file" class="form-control" id="inputGroupKTP">
                        <div wire:loading wire:target="fotovalid">Uploading...</div>
                        @error('fotovalid')
                        <span style="font-size: smaller; color: red;">{{ $message }}</span>
                        @enderror
                        @if (is_string($fotovalid) && strlen($fotovalid) > 0)
                        <img src="{{ asset('storage/' . $fotovalid) }}" class="img-fluid rounded mx-auto d-block mt-2" alt="...">
                        @else
                        @if ($fotovalid)
                        <img src="{{ $fotovalid->temporaryUrl() }}" class="img-fluid rounded mx-auto d-block mt-2" alt="...">
                        @endif
                        @endif
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-sm table-bordered table-striped table-hover" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Barang</th>
                                <th>Qty Retur</th>
                                <th>Qty Valid (Fisik)</th>
                                <th>Harga</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($dblistdetailretur)
                            @foreach ($dblistdetailretur as $item)
                            <tr>
                                <td>{{ $item->barang }}</td>
                                <td>{{ $item->qty }}</td>
                                <td><input wire:model="qtyvalid.{{ $item->id }}" type="numeric" class="form-control form-control-sm"></td>
                                <td class="rata-kanan">{{ number_format(($item->harga ?? 0), 0, ',', '.') }}</td>
                                <td class="rata-kanan">{{ number_format(($item->total ?? 0), 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-action">
                <button wire:click="valid" wire:loading.attr="disabled" class="btn btn-primary btn-round">Valid</button>
            </div>

        </div>
    </div>

</div>