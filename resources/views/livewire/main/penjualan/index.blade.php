<div>
    <!-- <link href="{{ asset('css/style_alert_center_close.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/styles_table_res.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/tabelsort.css') }}" rel="stylesheet" />
    <style>
        @media (max-width: 768px) {
            .input-group-item {
                flex: 1 1 100%;
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

    <!-- <div class="page-header">
        <h3 class="fw-bold mb-3">{{ $title }}</h3>
    </div> -->

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <button class="btn btn-primary btn-round mb-2" wire:click="entryNew" href="#entry">Baru</button>
                <div class="table-responsive text-nowrap">
                    <table class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Act</th>
                                <th>Tanggal</th>
                                <th>Tim</th>
                                <th>Nota</th>
                                <th>Nama Customer</th>
                                <th>Alamat Customer</th>
                                <th>No. Telepon Customer</th>
                                <th class="rata-kanan">Total Jual</th>
                                <th>User Entry</th>
                                <th>Updated At</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($listPenjualans as $detail)
                            <tr>
                                <td>
                                    <a wire:click="edit({{ $detail->id }})" wire:loading.attr="disabled" title="Edit" type="button" class="badge bg-warning bg-sm" href="#entry"><i class="fas fa-edit fa-lg"></i></a>
                                    <a wire:click="confirmDelete({{ $detail->id }})" wire:loading.attr="disabled" title="Delete" type="button" class="badge bg-danger bg-sm" data-bs-toggle="modal" data-bs-target="#ModalDelete"><i class="fas fa-eraser fa-lg"></i></a>
                                    <a wire:click="confirmValid({{ $detail->id }},{{ $detail->totaljual ?? 0 }})" wire:loading.attr="disabled" title="Valid" type="button" class="badge bg-success bg-sm" data-bs-toggle="modal" data-bs-target="#ModalValid"><i class="fas fa-lock fa-lg"></i></a>
                                </td>
                                <td>{{ $detail->tgljual }}</td>
                                <td>{{ $detail->Tim }}</td>
                                <td>{{ $detail->nota }}</td>
                                <td>{{ $detail->customernama }}</td>
                                <td>{{ $detail->customeralamat }}</td>
                                <td>{{ $detail->customernotelp }}</td>
                                <td class="rata-kanan">{{ number_format(($detail->totaljual ?? 0), 0, ',', '.') }}</td>
                                <td>{{ $detail->userentry }}</td>
                                <td>{{ $detail->updated_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <div class="container col-12" style="padding: 3px;">
        <!-- modal delete -->
        <div wire:ignore.self class="modal fade" id="ModalDelete" tabindex="-1" aria-labelledby="ModalDeleteLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="ModalDeleteLabel">Hapus Data</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Anda yakin hapus data Nota: {{ $nota }}?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <button wire:click="delete()" type="button" class="btn btn-primary" data-bs-dismiss="modal">Yes</button>
                    </div>
                </div>
            </div>
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
                        Jumlah total penjualan = {{ $jumlahTotal }} <br>
                        @if (!empty($validMessage))
                        {{ $validMessage }}
                        @else
                        Anda yakin validasi Nota: {{ $nota }}?
                        @endif
                    </div>
                    <div class="modal-footer">
                        @if (!empty($validMessage))
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                        @else
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <button wire:click="valid()" type="button" class="btn btn-primary" data-bs-dismiss="modal">Yes</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($isEditor)
    @include('livewire.main.penjualan.entry')
    @endif

    <script src="{{ asset('js/formatAngka.js') }}"></script>
    @push('scripts')
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
    @endpush
</div>
