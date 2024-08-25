<div>
    {{-- Success is as dangerous as failure. --}}
    <script src="{{ asset('js/formatAngka.js') }}"></script>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
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
    </style>

    @if ($errors->any())
    <div class="alert alert-success alert-dismissible fade show" role="alert">
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
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <ul>
            <pre>{{ session('error') }} </pre>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label=""></button>
    </div>
    @endif

    <h2 class="text-center">{{ $title }}</h2>
    <div class="container">

        <div class="col-6" style="padding: 1px; position: relative;">
            <div class="input-group-item" style="position: relative;">
                <span class="input-label">Nota/Customer</span>
                <input wire:model.live="nota" type="text" class="form-control" id="search-input" placeholder="cari berdasakan nota / nama customer">
                @error('nota')
                <span style="font-size: smaller; color: red;">{{ $message }}</span>
                @enderror
            </div>
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

        <!-- pilih nota -->
        <div class="col-12" style="padding: 1px;">
            <div class="input-group">
                <div class="input-group-item">
                    <span class="input-label">Tanggal Penjualan</span>
                    <input wire:model="tgljual" type="date" class="form-control" disabled>
                </div>
                <div class="input-group-item">
                    <span class="input-label">Tim</span>
                    <input wire:model="tim" type="text" class="form-control" disabled>
                </div>
                <div class="input-group-item">
                    <span class="input-label">PT</span>
                    <input wire:model="pt" type="text" class="form-control" disabled>
                </div>
                <div class="input-group-item">
                    <span class="input-label">Kota</span>
                    <input wire:model="kota" type="text" class="form-control" disabled>
                </div>
                <div class="input-group-item">
                    <span class="input-label">Nama Customer</span>
                    <input wire:model="customernama" type="text" class="form-control" disabled>
                </div>
                <div class="input-group-item">
                    <span class="input-label">Alamat Customer</span>
                    <input wire:model="customeralamat" type="text" class="form-control" disabled>
                </div>
                <div class="input-group-item">
                    <span class="input-label">Total Penjualan: {{ number_format(($totaljual ?? 0), 0, ',', '.') }}</span>
                    <input wire:model="totaljualRp" type="text" class="form-control" disabled>
                </div>
            </div>
        </div>

        <!-- kartu piutang -->
        <div class="table-responsive input-group">
            <div class="input-group-item">
                <div>Kartu Piutang Nota</div>
            </div>
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
                    @foreach($dbKartuPiutang as $item)
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

        <!-- input pengiriman barang -->
        <div class="custom-divider mt-2 mb-3"></div>
        <div class="container">
            <label>Pengiriman Barang</label>
            <div class="input-group">
                <div class="input-group p-0 g-0 m-0">
                    <div class="input-group-item">
                        <span class="input-label" id="tglpengiriman">Tgl Pengiriman</span>
                        <input wire:model="tglretur" type="date" class="form-control">
                        @error('tglpengiriman')
                        <span style="font-size: smaller; color: red;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-group-item">
                        <span class="input-label">Nama Driver</span>
                        <select wire:model="namadriver" type="text" class="form-select">
                            <option value=""></option>
                            @if($dbDrivers)
                            @foreach ($dbDrivers as $dbDriver)
                            <option value="{{ $dbDriver->nama }}">{{ $dbDriver->nama }}</option>
                            @endforeach
                            @endif
                        </select>
                        @error('namadriver')
                        <span style="font-size: smaller; color: red;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-group-item mb-0">
                        <span class="input-label" for="inputGroupFoto">Foto Surat Pengiriman</span>
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

                    <div class="input-group-item mb-0">
                        <span class="input-label" for="inputGroupFoto">Catatan</span>
                        <input wire:model="catatan" type="text" class="form-control">
                        @error('catatan')
                        <span style="font-size: smaller; color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div>
                    <button wire:click="simpan" type="button" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>

        <!-- detail entry paket -->

        <div class="container">
            <h6 style="margin-Top: 7px; margin-Bottom: 0px;"> Detail Barang</h6>
            <!-- entry paket -->
            <div class="container" style="padding: 3px; margin-bottom: 5px;">
                <div class="input-group">
                    <div class="input-group-item">
                        <span class="input-label">Barang (Paket)</span>
                        <select wire:model="timsetuppaketid" class="form-control">
                            <option value=""></option>
                            @foreach ($dbTimssetuppakets as $dbTimssetuppaket)
                            <option value="{{ $dbTimssetuppaket->id }}">{{ $dbTimssetuppaket->nama }}</option>
                            @endforeach
                        </select>
                        @error('timsetuppaketid')
                        <span style="font-size: smaller; color: red;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-group-item">
                        <span class="input-label">Jumlah Barang</span>
                        <input wire:model="jumlah" type="number" class="form-control">
                        @error('jumlah')
                        <span style="font-size: smaller; color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                @if ($isUpdatePaket)
                <button wire:click="updatePaket" type="button" class="btn btn-primary mt-1">Update</button>
                @else
                <button wire:click="createPaket" type="button" class="btn btn-primary mt-1">Simpan</button>
                @endif
                <button wire:click="clearPaket" type="button" class="btn btn-secondary mt-1">Bersihkan</button>
            </div>

            <div class="custom-divider mt-2 mb-3"></div>

            <!-- list paket -->
            <table class="table table-sm table-hover table-striped table-bordered border-primary-subtle">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Paket</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col" class="rata-kanan">H.Jual</th>
                        <th scope="col">Barang</th>
                        <th scope="col">Act</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dbPengirimans as $dbPengiriman)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $dbPengiriman->joinTimSetupPaket->nama }}</td>
                        <td>{{ $dbPengiriman->jumlah }}</td>
                        <td class="rata-kanan">{{ number_format($dbPengiriman->joinTimSetupPaket->hargajual, 0, ',', '.') }}</td>
                        <td>
                            <ul style="list-style-type: none; padding-left: 0;">
                                @foreach ($dbPengiriman->joinTimSetupPaket->joinTimSetupBarang as $joinTimSetupBarang)
                                <li>&bull; {{ $joinTimSetupBarang->joinBarang->nama }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <a wire:click="editPaket({{ $dbPenjualandt->id }})" wire:loading.attr="disabled" type="button" class="badge bg-warning bg-sm"><i class="bi bi-pencil-fill"></i></a>
                            <a wire:click="confirmDeletePaket({{ $dbPenjualandt->id }})" wire:loading.attr="disabled" type="button" class="badge bg-danger bg-sm" data-bs-toggle="modal" data-bs-target="#ModalDeletePaket"><i class="bi bi-eraser"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>



</div>
</div>