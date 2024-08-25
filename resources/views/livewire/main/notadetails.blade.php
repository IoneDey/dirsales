<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <!-- Modal -->
    <div class="modal fade" id="notaDetailsModal" tabindex="-1" aria-labelledby="notaDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notaDetailsModalLabel">Detail Nota</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5>Penjualan Nota: {{ $nota }}</h5>
                    @if($dbPenjualan)
                    {{ $dbPenjualan->tim }} <br>
                    Koordinator: {{ $dbPenjualan->customernama }} <br>
                    Barang Terjual: {{ $dbPenjualan->jumlah }} <br>
                    <h6>Penjualan: <b>{{ number_format(($dbPenjualan->Total ?? 0), 0, ',', '.') }}</b></h6>
                    @endif

                    <hr>

                    <h5>Retur</h5>
                    @if($dbReturTotal)
                    <h6>Total: <b>{{ number_format(($dbReturTotal ?? 0), 0, ',', '.') }}</b></h6>
                    @else
                    Tidak ada retur. <br><br>
                    @endif

                    @if(isset($dbRetur) && count($dbRetur) > 0)
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive text-nowrap">
                                <table class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Noretur</th>
                                            <th>Tgl Retur</th>
                                            <th>Qty</th>
                                            <th>Total</th>
                                            <th>Qty Valid</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($dbRetur)
                                        @foreach ($dbRetur as $item)
                                        <tr>
                                            <td>{{ $item->noretur }}</td>
                                            <td>{{ $item->tglretur }}</td>
                                            <td>{{ $item->Qty }}</td>
                                            <td>{{ number_format(($item->Total ?? 0), 0, ',', '.') }}</td>
                                            <td>{{ $item->QtyValid }}</td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif

                    <hr>

                    <h5>Penagihan</h5>
                    @if($dbpenagihanTotal)
                    <h6>Total: <b>{{ number_format(($dbpenagihanTotal ?? 0), 0, ',', '.') }}</b></h6>
                    @else
                    Tidak ada Penagihan. <br><br>
                    @endif

                    @if(isset($dbpenagihan) && count($dbpenagihan) > 0)
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive text-nowrap">
                                <table class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Tgl Penagihan</th>
                                            <th>Nama Penagih</th>
                                            <th>Total</th>
                                            <th>Rating</th>
                                            <th>Kategori</th>
                                            <th>Catatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($dbpenagihan)
                                        @foreach ($dbpenagihan as $item)
                                        <tr>
                                            <td>{{ $item->tglpenagihan }}</td>
                                            <td>{{ $item->namapenagih }}</td>
                                            <td>{{ number_format(($item->total ?? 0), 0, ',', '.') }}</td>
                                            <td>{{ $item->rating }}</td>
                                            <td>{{ $item->kategori }}</td>
                                            <td>{{ $item->catatan }}</td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif

                    <hr>

                    <h5>Sisa Belum Tertagih: {{ number_format(($Sisa ?? 0), 0, ',', '.') }}</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('openModal', event => {
            var myModal = new bootstrap.Modal(document.getElementById('notaDetailsModal'));
            myModal.show();
        });
    </script>
</div>