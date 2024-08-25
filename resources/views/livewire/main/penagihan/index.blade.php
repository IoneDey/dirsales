<div>
    {{-- The Master doesn't talk, he acts. --}}
    <!-- <script src="{{ asset('js/formatAngka.js') }}"></script>

    <link href="{{ asset('css/style_alert_center_close.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/styles_table_res.css') }}" rel="stylesheet" />
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

        .result-table thead th,
        .result-table tbody td {
            padding: 1px;
            text-align: left;
        }

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
            width: 100%;
            box-sizing: border-box;
            /* ensures the width includes padding and border */
        }

        .text-right {
            text-align: right;
        }

        table th,
        table td {
            white-space: nowrap;
        }

        .table-responsive {
            /* max-height: 400px; */
            /* Sesuaikan tinggi sesuai kebutuhan */
            overflow-y: auto;
            overflow-x: auto;
        }

        .info-box {
            border: 1px solid #ddd;
            padding: 5px;
            margin: 1px;
            border-radius: 5px;
            background-color: #f9f9f9;
            font-size: 0.775em;
        }

        .star-rating {
            position: relative;
            display: inline-block;
        }

        .star-rating span {
            font-size: 1em;
            position: relative;
        }

        .note {
            background: #fff;
            border: 1px solid #ccc;
            padding: 1rem;
            z-index: 1000;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            white-space: pre-wrap;
            text-align: left;
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

    @if ($isUpdate)
    <a typ="button" class="badge bg-warning bg-sm mb-2" style="text-decoration: none;" href="{{ route('penagihanreport', ['tglAwal' => request('tglAwal'), 'tglAkhir' => request('tglAkhir'), 'cari' => request('cari'), 'timsetupid' => request('timsetupid')]) }}"><i class="bi bi-arrow-left-circle"></i> Kembali</a>
    @endif
    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-lg-4 mb-3" style="position: relative;">
                            <span class="input-label">Nota/Customer</span>
                            <input {{ ($isUpdate ? "disabled" :"") }} wire:model.live="nota" type="text" class="form-control" id="search-input" placeholder="cari berdasakan nota / nama customer">
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
                            <span class="input-label">Tgl Penagihan/Pengambilan</span>
                            <input wire:model.live="tglpenagihan" type="date" class="form-control">
                            @error('tglpenagihan')
                            <span style="font-size: smaller; color: red;">{{ $message }}</span>
                            @enderror

                            @if ($dbInfoSPK)
                            <div class="info-box">
                                <div>F.Y.I:</div>
                                <div>Angsuran ke: {{ $dbInfoSPK->angsuranke }}</div>
                                <div>Nilai Angsuran: {{ number_format(($dbInfoSPK->perangsuran ?? 0), 0, ',', '.') }}</div>
                                <div>Penagihan A{{ $dbInfoSPK->angsuranke }}: {{ number_format(($dbInfoSPK->jmlpenagihan ?? 0), 0, ',', '.') }}</div>
                            </div>
                            @endif
                        </div>

                        <div class="col-md-6 col-lg-4 mb-3">
                            <span class="input-label">Yang Menagih</span>
                            <select wire:model="namapenagih" type="text" class="form-select">
                                <option value=""></option>
                                @if($dbKolektors)
                                @foreach ($dbKolektors as $dbKolektor)
                                <option value="{{ $dbKolektor->nama }}">{{ $dbKolektor->nama }}</option>
                                @endforeach
                                @endif
                            </select>
                            @error('namapenagih')
                            <span style="font-size: smaller; color: red;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 col-lg-4 mb-3" x-data="{ Jumlahbayar: @entangle('jumlahbayar') }">
                            <span class="input-label">Jumlah Pembayaran</span>
                            <input wire:model.live="jumlahbayar" type="text" inputmode="text" class="form-control text-right" x-model="Jumlahbayar" x-on:input="formatAngka($event)">
                            @error('jumlahbayar')
                            <span style="font-size: smaller; color: red;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 col-lg-4 mb-3" x-data="{ Biayaadmin: @entangle('biayaadmin')}">
                            <span class="input-label">Biaya Admin/Ongkos</span>
                            <input wire:model.live="biayaadmin" type="text" inputmode="text" class="form-control text-right" x-model="Biayaadmin" x-on:input="formatAngka($event)">
                            @error('biayaadmin')
                            <span style="font-size: smaller; color: red;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 col-lg-4 mb-3" x-data="{ Biayakomisi: @entangle('biayakomisi')}">
                            <span class="input-label">Komisi Warga</span>
                            <input wire:model.live="biayakomisi" type="text" inputmode="text" class="form-control text-right" x-model="Biayakomisi" x-bind:disabled="isDisabled" x-on:input="formatAngka($event)" {{ (($angsuranperiode ?? 0) == ($dbInfoSPK->angsuranke ?? 0) || ($tglpenagihan >= $tglAngsuranAkhir)) ? '' : 'disabled' }}>
                            @error('biayakomisi')
                            <span style="font-size: smaller; color: red;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 col-lg-4 mb-3" x-data="{ Jumlah: @entangle('jumlah') }">
                            <span class="input-label">Jumlah Total</span>
                            <input wire:model="jumlah" type="text" inputmode="text" class="form-control text-right" x-model="Jumlah" x-on:input="formatAngka($event)" disabled>
                            @error('jumlah')
                            <span style="font-size: smaller; color: red;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 col-lg-4 mb-3">
                            <span class="input-label" for="inputKwitans">Foto Kwitansi</span>
                            <input wire:model="fotokwitansi" accept="image/png, image/jpeg" type="file" class="form-control" id="inputKwitans">
                            <div wire:loading wire:target="fotokwitansi">Uploading...</div>
                            @error('fotokwitansi')
                            <span style="font-size: smaller; color: red;">{{ $message }}</span>
                            @enderror
                            @if (is_string($fotokwitansi) && strlen($fotokwitansi) > 0)
                            <img src="{{ asset('storage/' . $fotokwitansi) }}" class="img-fluid rounded mx-auto d-block mt-2" style="transform: rotate({{ $rotation }}deg);" alt="...">
                            @else
                            @if ($fotokwitansi)
                            <img src="{{ $fotokwitansi->temporaryUrl() }}" class="img-fluid rounded mx-auto d-block mt-2" style="transform: rotate({{ $rotation }}deg);" alt="...">
                            @endif
                            @endif
                            @if ($fotokwitansi)
                            <button class="btn btn-primary btn-sm" wire:click="rotate">Rotate</button>
                            @endif
                        </div>

                        <div class="col-md-6 col-lg-4 mb-3">
                            <span class="input-label">Kategori</span>
                            <select wire:model="kategori" type="text" class="form-control">
                                <option value="Belum Terkunjungi">❌Belum Terkunjungi</option>
                                <option value="Penundaan pembayaran">❌Penundaan pembayaran</option>
                                <option value="Penjadwalan pengambilan retur">❌Penjadwalan pengambilan retur</option>
                                <option value="Salah Presepsi Jumlah angsuran">❌Salah Presepsi Jumlah angsuran</option>
                                <option value="Penagihan tidak lengkap terkonfirmasi">✅Penagihan tidak lengkap terkonfirmasi</option>
                                <option value="Penagihan lengkap terkonfirmasi">✅Penagihan lengkap terkonfirmasi</option>
                                <option value="Kunjungan diluar SPK">✅Kunjungan diluar SPK</option>
                                <option value="Kunjungan Ulang">🔁Kunjungan Ulang</option>
                            </select>
                            @error('kategori')
                            <span style="font-size: smaller; color: red;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="input-group">
                                <span class="input-label">Catatan </span>
                                <div class="notes-section">
                                    <div class="star-rating">
                                        @for ($i = 1; $i <= 5; $i++) <span style="cursor: pointer; font-size: 1em; color: {{ $hoverRating >= $i || $rating >= $i ? 'gold' : 'gray' }};" wire:click="setRating({{ $i }})" wire:mouseover="setHoverRating({{ $i }})" wire:mouseout="resetHoverRating">
                                            ★
                                            </span>
                                            @endfor

                                    </div>
                                </div>
                            </div>
                            @if($hoverRating > 0)
                            <div class="note" style="margin-top: 1px;">
                                {{ $notes[$hoverRating] }}
                            </div>
                            @endif
                            <input wire:model="catatan" type="text" class="form-control">
                        </div>

                        <div class="card-action">
                            @if ($isUpdate)
                            <button wire:click="update" type="button" class="btn btn-primary btn-round">Update</button>
                            @else
                            <button wire:click="create" type="button" class="btn btn-primary btn-round">Simpan</button>
                            @endif
                            @if (!$isUpdate)
                            <button wire:click="clear" type="button" class="btn btn-secondary btn-round">Bersihkan</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <!-- kartu piutang -->
            <div class="card">
                <div class="card-body">
                    <div class="card-header">
                        <div class="card-title">Kartu Piutang Nota</div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="display table table-striped table-hover">
                                <table class="table table-sm table-hover table-striped table-bordered border-primary-subtle mt-1" style="width: 100%;">
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
                                            <td class="rata-kanan">{{ number_format(($item->debet ?? 0), 0, ',', '.') }}</td>
                                            <td class="rata-kanan">{{ number_format(($item->kredit ?? 0), 0, ',', '.') }}</td>
                                            <td class="rata-kanan">{{ number_format(($item->saldo ?? 0), 0, ',', '.') }}</td>
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
                        <div>Tgl Penjualan: {{ $tgljual }} - Rp. {{ number_format(($jmljual ?? 0), 0, ',', '.') }}</div>
                        <div>Angsuran Hari: {{ $angsuranhari }} - Angsuran Periode: {{ $angsuranperiode }}</div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-sm table-hover table-striped table-bordered border-primary-subtle mt-1" style="width: 100%;">
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
                                        <td class="rata-kanan">{{ number_format(($item->jmlpenagihan ?? 0), 0, ',', '.') }}</td>
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
    @if ($isUpdate)
    <a typ="button" class="badge bg-warning bg-sm" style="text-decoration: none;" href="{{ route('penagihanreport', ['tglAwal' => request('tglAwal'), 'tglAkhir' => request('tglAkhir'), 'cari' => request('cari'), 'timsetupid' => request('timsetupid')]) }}"><i class="bi bi-arrow-left-circle"></i> Kembali</a>
    @endif

    <script src="{{ asset('js/formatAngka.js') }}"></script>
</div>
