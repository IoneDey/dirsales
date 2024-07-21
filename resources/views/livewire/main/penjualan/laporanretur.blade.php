<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <link href="{{ asset('css/styles_table_res.css') }}" rel="stylesheet" />
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
    </style>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    <link href="{{ asset('css/styleSelect2.css') }}" rel="stylesheet" />
    <div class="container">
        <h2 class="text-center">{{ $title }}</h2>

        <div class="row justify-content-center">
            <div class="col-md-3 col-12 mb-1 p-1 g-0">
                <div class="input-group">
                    <span class="input-group-text">Tgl Awal</span>
                    <input wire:model.live.debounce.500ms="tglAwal" type="date" class="form-control" aria-label="Tgl Awal">
                </div>
            </div>

            <div class="col-md-3 col-12 mb-1 p-1 g-0">
                <div class="input-group">
                    <span class="input-group-text">Tgl Akhir</span>
                    <input wire:model.live.debounce.500ms="tglAkhir" type="date" class="form-control" aria-label="Tgl Akhir">
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-3 col-12 mb-1 p-1 g-0">
                <div class="d-flex align-items-left" x-data="{ isUpdate: @entangle('isUpdate') }" wire:ignore>
                    <span class="me-0 input-group-text" style="padding: 0.375rem 0.5rem; border-radius: 0.25rem 0 0 0; margin-right: -0.5rem; height: 38px;">Tim</span>
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
            <div class="col-md-3 col-12 mb-1 p-1 g-0">
                <div class="input-group">
                    <span class="input-group-text">Jenis</span>
                    <select wire:model.live="JenisRpt" class="form-control" aria-label="Jenis">
                        <option value="REKAP">REKAP</option>
                        <option value="DETAIL">DETAIL</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-12 mt-1 mb-1">
            <input class="border rounded" wire:model.live.debounce.500ms="cari" type="text" id="cari" placeholder="cari nota/nama ....">
        </div>

        @if ($JenisRpt=="REKAP")
        <div class="table-responsive mb-1">
            <table class="table table-sm table-bordered table-striped table-hover" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Tim</th>
                        <th>Tgl Retur</th>
                        <th>No. Retur</th>
                        <th>Nota</th>
                        <th>Nama Customer</th>
                        <th>Foto Retur</th>
                        <th class="rata-kanan">Total Retur</th>
                        @if (in_array(auth()->user()->roles ?? '', ['SUPERVISOR']))
                        <th>Act</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penjualanreturs as $penjualanretur)
                    <tr>
                        <td>{{ $penjualanretur->tim }}</td>
                        <td>{{ $penjualanretur->tglretur }}</td>
                        <td>{{ $penjualanretur->noretur }}</td>
                        <td>{{ $penjualanretur->nota }}</td>
                        <td>{{ $penjualanretur->customernama }}</td>
                        <td><a target="_blank" href="{{ asset('storage/' . $penjualanretur->foto ) }}">{{ $penjualanretur->foto }}</a></td>
                        <td class="rata-kanan">{{ number_format(($penjualanretur->totalretur ?? 0), 0, ',', '.') }}</td>
                        @if (in_array(auth()->user()->roles ?? '', ['SUPERVISOR']))
                        <td>
                            <a wire:click="confirmDeleteRetur({{ $penjualanretur->noretur }})" wire:loading.attr="disabled" type="button" class="badge bg-danger bg-sm" data-bs-toggle="modal" data-bs-target="#ModalDeleteRetur" title="Delete Retur"><i class="bi bi-eraser"></i></a>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td>#{{ $penjualanreturs->count() }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="rata-kanan">{{ number_format(($gtJumlah ?? 0), 0, ',', '.') }}</td>
                        @if (in_array(auth()->user()->roles ?? '', ['SUPERVISOR']))
                        <td></td>
                        @endif
                    </tr>
                </tfoot>
            </table>
        </div>
        {{ $penjualanreturs->links() }}
        @endif

        @if ($JenisRpt=="DETAIL")
        <div class="table-responsive mb-1">
            <table class="table table-sm table-bordered table-striped table-hover" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Tim</th>
                        <th>Tgl Retur</th>
                        <th>No. Retur</th>
                        <th>Nota</th>
                        <th>Nama Customer</th>
                        <th>Barang</th>
                        <th>Qty</th>
                        <th>@Harga</th>
                        <th class="rata-kanan">Total Retur</th>
                        <th>Act</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penjualanreturs as $penjualanretur)
                    <tr>
                        <td>{{ $penjualanretur->tim }}</td>
                        <td>{{ $penjualanretur->tglretur }}</td>
                        <td>{{ $penjualanretur->noretur }}</td>
                        <td>{{ $penjualanretur->nota }}</td>
                        <td>{{ $penjualanretur->customernama }}</td>
                        <td>{{ $penjualanretur->namabarang }}</td>
                        <td class="rata-kanan">{{ $penjualanretur->qtyretur }}</td>
                        <td class="rata-kanan">{{ number_format(($penjualanretur->hargaretur ?? 0), 0, ',', '.') }}</td>
                        <td class="rata-kanan">{{ number_format(($penjualanretur->totalretur ?? 0), 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td>#{{ $penjualanreturs->count() }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="rata-kanan">{{ number_format(($gtQty ?? 0), 0, ',', '.') }}</td>
                        <td></td>
                        <td class="rata-kanan">{{ number_format(($gtJumlah ?? 0), 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        {{ $penjualanreturs->links() }}
        @endif

        @if (in_array(auth()->user()->roles ?? '', ['SUPERVISOR', 'SPV ADMIN']))
        <button wire:click="exportExcel" wire:loading.attr="disabled" class="badge bg-success bg-sm d-flex justify-content-center align-items-center custom-hover mt-2" type="button" title="Export Excel">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-spreadsheet" viewBox="0 0 16 16">
                <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5zM3 12v-2h2v2zm0 1h2v2H4a1 1 0 0 1-1-1zm3 2v-2h3v2zm4 0v-2h3v1a1 1 0 0 1-1 1zm3-3h-3v-2h3zm-7 0v-2h3v2z" />
            </svg>
            <span class="bg-success">Export Excel Retur Penjualan Detail</span>
        </button>
        @endif

    </div>

    <div wire:ignore.self class="modal fade" id="ModalDeleteRetur" tabindex="-1" aria-labelledby="ModalDeleteLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="ModalDeleteLabel">Hapus Data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Anda yakin hapus data retur: {{ $noretur }}?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button wire:click="deleteRetur()" type="button" class="btn btn-primary" data-bs-dismiss="modal">Yes</button>
                </div>
            </div>
        </div>
    </div>
</div>