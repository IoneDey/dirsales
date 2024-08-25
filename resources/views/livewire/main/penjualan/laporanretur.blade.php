<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <!-- <link href="{{ asset('sneat/css/style-tabel.css') }}" rel="stylesheet" />
    <link href="{{ asset('sneat/css/style-spinner.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/styleSelect2.css') }}" rel="stylesheet" /> -->

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

                    <div class="col-md-6 col-lg-4 mb-3">
                        <span class="input-label">Jenis</span>
                        <select wire:model.live="JenisRpt" class="form-control" aria-label="Jenis">
                            <option value="REKAP">REKAP</option>
                            <option value="DETAIL">DETAIL</option>
                        </select>
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

                    @if ($JenisRpt=="REKAP")
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        @if (in_array(auth()->user()->roles ?? '', ['SUPERVISOR']))
                                        <th>Act</th>
                                        @endif
                                        <th>Tim</th>
                                        <th>Tgl Retur</th>
                                        <th>No. Retur</th>
                                        <th>Nota</th>
                                        <th>Nama Customer</th>
                                        <th>Foto Retur</th>
                                        <th class="rata-kanan">Qty Retur</th>
                                        <th class="rata-kanan">Total Retur</th>
                                        <th>Foto Retur Valid</th>
                                        <th class="rata-kanan">Qty Valid</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penjualanreturs as $penjualanretur)
                                    <tr>
                                        @if (in_array(auth()->user()->roles ?? '', ['SUPERVISOR']))
                                        <td>
                                            <a wire:click="confirmDeleteRetur({{ $penjualanretur->noretur }})" wire:loading.attr="disabled" type="button" class="badge bg-danger bg-sm" data-bs-toggle="modal" data-bs-target="#ModalDeleteRetur" title="Delete Retur"><i class="fas fa-eraser fa-lg"></i></a>
                                        </td>
                                        @endif
                                        <td>{{ $penjualanretur->tim }}</td>
                                        <td>{{ $penjualanretur->tglretur }}</td>
                                        <td>{{ $penjualanretur->noretur }}</td>
                                        <td><a href="#" wire:click.prevent="$dispatch('showNotaDetails', { timsetupid: {{ $penjualanretur->timsetupid }}, nota: '{{ $penjualanretur->nota }}' })">{{ $penjualanretur->nota }}</a></td>
                                        <td>{{ $penjualanretur->customernama }}</td>
                                        <td><a target="_blank" href="{{ asset('storage/' . $penjualanretur->foto ) }}">{{ $penjualanretur->foto }}</a></td>
                                        <td class="rata-kanan">{{ $penjualanretur->qtyretur }}</td>
                                        <td class="rata-kanan">{{ number_format(($penjualanretur->totalretur ?? 0), 0, ',', '.') }}</td>
                                        <td><a target="_blank" href="{{ asset('storage/' . $penjualanretur->fotovalid ) }}">{{ $penjualanretur->fotovalid }}</a></td>
                                        <td class="rata-kanan">{{ number_format(($penjualanretur->qtyvalid ?? 0), 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        @if (in_array(auth()->user()->roles ?? '', ['SUPERVISOR']))
                                        <td></td>
                                        @endif
                                        <td>#{{ $penjualanreturs->count() }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="rata-kanan">{{ number_format(($gtJumlah ?? 0), 0, ',', '.') }}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="card-body">
                            {{ $penjualanreturs->links() }}
                        </div>
                    </div>
                    @endif

                    @if ($JenisRpt=="DETAIL")
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="display table table-striped table-hover">
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
                                        <th>Qty Valid</th>
                                        <th>Act</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penjualanreturs as $penjualanretur)
                                    <tr>
                                        <td>{{ $penjualanretur->tim }}</td>
                                        <td>{{ $penjualanretur->tglretur }}</td>
                                        <td>{{ $penjualanretur->noretur }}</td>
                                        <td><a href="#" wire:click.prevent="$dispatch('showNotaDetails', { timsetupid: {{ $penjualanretur->timsetupid }}, nota: '{{ $penjualanretur->nota }}' })">{{ $penjualanretur->nota }}</a></td>
                                        <td>{{ $penjualanretur->customernama }}</td>
                                        <td>{{ $penjualanretur->namabarang }}</td>
                                        <td class="rata-kanan">{{ $penjualanretur->qtyretur }}</td>
                                        <td class="rata-kanan">{{ number_format(($penjualanretur->hargaretur ?? 0), 0, ',', '.') }}</td>
                                        <td class="rata-kanan">{{ number_format(($penjualanretur->totalretur ?? 0), 0, ',', '.') }}</td>
                                        <td class="rata-kanan">{{ $penjualanretur->qtyvalid }}</td>
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
                        <div class="card-body">
                            {{ $penjualanreturs->links() }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            @if (in_array(auth()->user()->roles ?? '', ['SUPERVISOR', 'SPV ADMIN']))
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-3">
                        <button wire:click="exportExcel" wire:loading.attr="disabled" class="btn btn-success btn-round" type="button" title="Export Excel">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-spreadsheet" viewBox="0 0 16 16">
                                <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5zM3 12v-2h2v2zm0 1h2v2H4a1 1 0 0 1-1-1zm3 2v-2h3v2zm4 0v-2h3v1a1 1 0 0 1-1 1zm3-3h-3v-2h3zm-7 0v-2h3v2z" />
                            </svg>
                            <span class="bg-success">Export Excel Retur Penjualan Detail</span>
                        </button>
                    </div>
                </div>
            </div>
            @endif
        </div>
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

    <div wire:loading>
        <div class="loading-overlay"></div>
        <div class="centered-spinner">
            <div class="spinner-border spinner-border-lg text-primary" role="status">
            </div>
        </div>
    </div>

    <!-- @push('scripts')
    <script>
        document.addEventListener('livewire:load', function() {
            initDataTable();
        });

        function initDataTable() {
            $("#basic-datatables").DataTable();

            $("#multi-filter-select").DataTable({
                pageLength: 5,
                initComplete: function() {
                    this.api()
                        .columns()
                        .every(function() {
                            var column = this;
                            var select = $(
                                    '<select class="form-select"><option value=""></option></select>'
                                )
                                .appendTo($(column.footer()).empty())
                                .on("change", function() {
                                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                                    column
                                        .search(val ? "^" + val + "$" : "", true, false)
                                        .draw();
                                });

                            column
                                .data()
                                .unique()
                                .sort()
                                .each(function(d, j) {
                                    select.append(
                                        '<option value="' + d + '">' + d + "</option>"
                                    );
                                });
                        });
                },
            });

            $("#add-row").DataTable({
                pageLength: 5,
            });

            $("#addRowButton").click(function() {
                var action =
                    '<td> <div class="form-button-action"> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

                $("#add-row")
                    .dataTable()
                    .fnAddData([
                        $("#addName").val(),
                        $("#addPosition").val(),
                        $("#addOffice").val(),
                        action,
                    ]);
                $("#addRowModal").modal("hide");
            });
        }
    </script>
    @endpush -->
    <livewire:main.notadetails />
</div>