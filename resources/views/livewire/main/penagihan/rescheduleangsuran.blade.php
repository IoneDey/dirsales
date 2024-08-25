<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}

    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show"
        role="alert">
        <ul>
            @foreach ($errors->all() as $error)
            <pre>{{ $error }}</pre>
            @endforeach
        </ul>
        <button wire:click="resetErrors"
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label=""></button>
    </div>
    @endif

    @if(session()->has('ok'))
    <div class="alert alert-success alert-dismissible fade show"
        role="alert">
        <ul>
            <pre>{{ session('ok') }} </pre>
        </ul>
        <button type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label=""></button>
    </div>
    @endif

    @if(session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show"
        role="alert">
        <ul>
            <pre>{{ session('error') }} </pre>
        </ul>
        <button type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label=""></button>
    </div>
    @endif

    <link href="{{ asset('css/select2.css') }}"
        rel="stylesheet" />

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
        width: 200%;
        box-sizing: border-box;
        /* ensures the width includes padding and border */
    }

    .result-table th,
    .result-table td {
        white-space: nowrap;
        /* Mencegah pembungkusan teks */
    }
    </style>

    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-6 col-lg-4 mb-3"
                            style="position: relative;">
                            <span class="input-label">Nota/Customer</span>
                            <input wire:model.live="nota"
                                type="text"
                                class="form-control"
                                id="search-input"
                                placeholder="cari berdasakan nota / nama customer">
                            @error('nota')
                            <span style="font-size: smaller; color: red;">{{ $message }}</span>
                            @enderror
                            @if(!empty($results) && !$isNota)
                            <div id="search-results"
                                class="search-results">
                                <table class="result-table table table-sm table-bordered table-striped table-hover"
                                    style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Nota</th>
                                            <th>Nama Customer</th>
                                            <th>Alamat Customer</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($results as $result)
                                        <tr wire:click="selectNota('{{ $result->timsetupid }}','{{ $result->nota }}')"
                                            style="cursor: pointer;">
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
                            <span class="input-label">Tim</span>
                            <input wire:model="tim"
                                type="text"
                                class="form-control"
                                disabled>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <span class="input-label">PT</span>
                            <input wire:model="pt"
                                type="text"
                                class="form-control"
                                disabled>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <span class="input-label">Kota</span>
                            <input wire:model="kota"
                                type="text"
                                class="form-control"
                                disabled>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <span class="input-label">Nama Customer</span>
                            <input wire:model="customernama"
                                type="text"
                                class="form-control"
                                disabled>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <span class="input-label">Alamat Customer</span>
                            <input wire:model="customeralamat"
                                type="text"
                                class="form-control"
                                disabled>
                        </div>

                        <div class="col-md-6 col-lg-4 mb-3">
                            <span class="input-label">Tanggal Mulai Angsuran</span>
                            <input wire:model.live="tglreschedule"
                                type="date"
                                class="form-control">
                            @error('tglreschedule')
                            <span style="font-size: smaller; color: red;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 col-lg-4 mb-3">
                            <span class="input-label">Angsuran - Hari</span>
                            <input wire:model="angsuranhari"
                                type="number"
                                class="form-control">
                            @error('angsuranhari')
                            <span style="font-size: smaller; color: red;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <span class="input-label">Angsuran - Periode</span>
                            <input wire:model="angsuranperiode"
                                type="number"
                                class="form-control">
                            @error('angsuranperiode')
                            <span style="font-size: smaller; color: red;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 col-lg-4 mb-3">
                            <span class="input-label">Kurir</span>
                            <select wire:model="kurir"
                                type="text"
                                class="form-select">
                                <option value=""></option>
                                @if($dbKolektors)
                                @foreach ($dbKolektors as $dbKolektor)
                                <option value="{{ $dbKolektor->nama }}">{{ $dbKolektor->nama }}</option>
                                @endforeach
                                @endif
                            </select>
                            @error('kurir')
                            <span style="font-size: smaller; color: red;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 col-lg-4 mb-3"
                            x-data="{ Item: @entangle('penjualan') }">
                            <span class="input-label">Sisa Tagihan</span>
                            <input disabled
                                wire:model.live="penjualan"
                                type="text"
                                inputmode="text"
                                class="form-control text-right"
                                x-model="Item"
                                x-on:input="formatAngka($event)">
                            @error('penjualan')
                            <span style="font-size: smaller; color: red;">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="card-action">
                            <button {{ $penjualan==0 ? 'disabled':'' }}
                                wire:click="create"
                                type="button"
                                class="btn btn-primary btn-round">Simpan</button>
                            <button wire:click="clear"
                                type="button"
                                class="btn btn-secondary btn-round">Bersihkan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-5">
            <!-- kartu piutang -->
            <div class="card">
                <div class="card-body">
                    <div class="card-header">
                        <div class="card-title">Kartu Piutang Nota</div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive input-group">
                            <table
                                class="table table-sm table-hover table-striped table-bordered border-primary-subtle mt-1"
                                style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Nota</th>
                                        <th class="rata-kanan">Debet</th>
                                        <th class="rata-kanan">Kredit</th>
                                        <th class="rata-kanan">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dbKartus as $item)
                                    <tr>
                                        <td>{{ $item->tgljual }}</td>
                                        <td>{{ $item->nota }}</td>
                                        <td class="rata-kanan">{{ number_format(($item->debet ?? 0), 0, ',', '.') }}
                                        </td>
                                        <td class="rata-kanan">{{ number_format(($item->kredit ?? 0), 0, ',', '.') }}
                                        </td>
                                        <td class="rata-kanan">{{ number_format(($item->saldo ?? 0), 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="separator-solid"></div>

                <!-- info angsuran -->
                <div class="card-body">
                    <div class="card-header">
                        <div class="card-title">Informasi Angsuran</div>
                        <div>Tgl Penjualan: {{ $tgljual }} - Rp.
                            {{ number_format(($jmljual ?? 0), 0, ',', '.') }}
                        </div>
                        <div>Angsuran Hari: {{ $angsuranhari }} - Angsuran Periode: {{ $angsuranperiode }}</div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table
                                class="table table-sm table-hover table-striped table-bordered border-primary-subtle mt-1"
                                style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Ke</th>
                                        <th>Tgl Angsuran</th>
                                        <!-- <th class="rata-kanan">Angsuran</th> -->
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
                                        <!-- <td class="rata-kanan">{{ number_format(($item->perangsuran ?? 0), 0, ',', '.') }}</td> -->
                                        <td>{{ $item->tglpenagihan }}</td>
                                        <td class="rata-kanan">
                                            {{ number_format(($item->jmlpenagihan ?? 0), 0, ',', '.') }}
                                        </td>
                                        <td>{{ $item->namapenagih }}</td>
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

    <script src="{{ asset('js/formatAngka.js') }}"></script>
</div>