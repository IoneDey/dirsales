<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    <!-- <link href="{{ asset('css/styles_table_res.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/styleSelect2.css') }}" rel="stylesheet" />
    <style>
        /* untuk tabel scroll */
        table th,
        table td {
            white-space: nowrap;
        }

        .table-responsive {
            max-height: 90vh;
            overflow-y: auto;
            overflow-x: auto;
        }

        @media (max-height: 800px) {
            .table-responsive {
                max-height: 66vh;
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

    <div class="card">
        <div class="col-md-12">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div x-data="{ isUpdate: @entangle('isUpdate') }" wire:ignore>
                            <span class="input-label" style="padding: 0.375rem 0.5rem; border-radius: 0.25rem 0 0 0; margin-right: -0.5rem; height: 38px;">Tim</span>
                            <select x-data="{item: @entangle('tim')}" x-init="$($refs.select2ref).select2(); $($refs.select2ref).on('change', function(){$wire.set('tim', $(this).val());});" x-effect="$refs.select2ref.value = item; $($refs.select2ref).select2();" x-ref="select2ref" :disabled="isUpdate" class="form-select" aria-label="Tim">
                                <option value='Semua'>Semua</option>
                                @foreach ($dbTimsetups as $dbTimsetup)
                                <option value="{{ $dbTimsetup->joinTim->nama }}">{{ $dbTimsetup->joinTim->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('timsetupid')
                        <span style="font-size: smaller; color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <span class="input-label">Tampilkan sisa <= 0</span>
                                <div class="form-check-inline-group" style="border: 1px solid #e9ecef; border-radius: var(--bs-border-radius)">
                                    <div class="form-check form-check-inline">
                                        <input wire:model.live="chkFilterSisa" class="form-check-input" type="checkbox" value="">
                                        <label class="form-check-label" for="inlineRadio1">Ya</label>
                                    </div>
                                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 col-lg-4 mb-3">
                    <input class="form-control" wire:model.live.debounce.500ms="cari" type="text" id="cari" placeholder="cari nota/nama/PJ Kurir/PJ Nota ....">
                </div>

                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        @foreach ($salesData as $tim => $sales)
                        <h5>{{ $tim }}</h5>
                        <table class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Nota</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Total Penjualan</th>
                                    <th>Total Retur</th>
                                    <th>Total Penagihan</th>
                                    <th>Sisa</th>
                                    <th>PJ. Kurir Nota</th>
                                    <th>PJ. Admin Nota</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sales as $sale)
                                <tr>
                                    <td>{{ $sale->Nota }}</td>
                                    <td>{{ $sale->Customernama }}</td>
                                    <td class="rata-kanan">{{ number_format(($sale->TotalPenjualan ?? 0), 0, ',', '.') }}</td>
                                    <td class="rata-kanan">{{ number_format(($sale->TotalRetur ?? 0), 0, ',', '.') }}</td>
                                    <td class="rata-kanan">{{ number_format(($sale->TotalPenagihan ?? 0), 0, ',', '.') }}</td>
                                    <td class="rata-kanan">{{ number_format(($sale->Sisa ?? 0), 0, ',', '.') }}</td>
                                    <td>{{ $sale->pjkolektornota }}</td>
                                    <td>{{ $sale->pjadminnota }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
