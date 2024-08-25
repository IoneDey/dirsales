<div>
  {{-- The Master doesn't talk, he acts. --}}
  <!-- <link href="{{ asset('css/styles_table_res.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/styleSelect2.css') }}" rel="stylesheet" />
    <style>
        /* untuk tabel scroll */
        table th,
        table td {
            white-space: nowrap;
        }

        .table-responsive {
            max-height: 80vh;
            overflow-y: auto;
            overflow-x: auto;
        }

        @media (max-height: 800px) {
            .table-responsive {
                max-height: 72vh;
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

        .angsuran-ganjil {
            background-color: #f2f2f2 !important;
        }

        .angsuran-genap {
            background-color: #e6e6e6 !important;
        }
    </style> -->

  <link href="{{ asset('css/select2.css') }}"
    rel="stylesheet" />

  <style>
  .angsuran-ganjil {
    background-color: #f2f2f2 !important;
  }

  .angsuran-genap {
    background-color: #e6e6e6 !important;
  }

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
  <div class="alert alert-success alert-dismissible fade show"
    role="alert">
    <ul>
      <pre>{{ session('ok') }} </pre>
    </ul>
    <button type="button"
      class="btn-close btn-sm"
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

  <div class="card">
    <div class="col-md-12">
      <div class="card-body">
        <div class="row">
          <div class="col-md-6 col-lg-4 mb-3">
            <span class="input-label">Tgl Angsuran</span>
            <input wire:model.live.debounce.500ms="tglangsuran"
              type="date"
              class="form-control"
              aria-label="Tgl Awal">
          </div>
          <div class="col-md-6 col-lg-4 mb-3">
            <span class="input-label">S.D</span>
            <input wire:model.live.debounce.500ms="tglangsuranakhir"
              type="date"
              class="form-control"
              aria-label="Tgl Awal">
          </div>
          <div class="col-md-6 col-lg-4 mb-3">
            <div x-data="{ isUpdate: @entangle('isUpdate') }"
              wire:ignore>
              <span class="input-label">Tim</span>
              <select x-data="{item: @entangle('timsetupid')}"
                x-init="$($refs.select2ref).select2(); $($refs.select2ref).on('change', function(){$wire.set('timsetupid', $(this).val());});"
                x-effect="$refs.select2ref.value = item; $($refs.select2ref).select2();"
                x-ref="select2ref"
                :disabled="isUpdate"
                class="form-select"
                aria-label="Tim">
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
            <span class="input-label">Mode</span>
            <select class="form-select"
              wire:model.live.debounce.500ms="mode">
              <option value="row">row</option>
              <option value="column">column</option>
            </select>
          </div>
          <div class="col-md-6 col-lg-4 mb-3">
            <span class="input-label">Filter Nota</span>
            <textarea class="form-control"
              wire:model.live.debounce.500ms="notasString"
              id="exampleFormControlTextarea1"
              rows="2"
              placeholder="ex: 24-07-2024-0003,24-07-2024-0004,24-07-2024-0007 ..."></textarea>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="col-md-12">
      <div class="card-body">
        <div class="table-responsive text-nowrap">
          @if ($mode=="row")
          <table class="display table table-striped table-hover">
            <thead>
              <tr>
                <th>Tim</th>
                <th>Nota</th>
                <th>Customer Nama</th>
                <th>Customer Alamat</th>
                <th>PJ Kurir Nota</th>
                <th>PJ Admin Nota</th>
                <th>Tanggal Jual</th>
                <th>Angsuran Hari</th>
                <th>Angsuran Periode</th>
                <th>Omset</th>
                <th>Per Angsuran</th>
                <th>Ke</th>
                <th>Angsuran Date</th>
                <th>Penagihan Date</th>
                <th>H</th>
                <th>Penagihan</th>
                <th>Retur</th>
                <th>Total</th>
                <th>Penagih</th>
                <th>Kategori</th>
                <th>Rating</th>
                <th>Catatan</th>
              </tr>
            </thead>
            <tbody>
              @foreach($data as $row)
              <tr>
                <td>{{ $row->tim }}</td>
                <td>{{ $row->nota }}</td>
                <td>{{ $row->customernama }}</td>
                <td>{{ $row->customeralamat }}</td>
                <td>{{ $row->pjkolektornota }}</td>
                <td>{{ $row->pjadminnota }}</td>
                <td>{{ $row->tgljual }}</td>
                <td>{{ $row->angsuranhari }}</td>
                <td>{{ $row->angsuranperiode }}</td>
                <td class="rata-kanan">{{ number_format(($row->omset ?? 0), 0, ',', '.') }}</td>
                <td class="rata-kanan">{{ number_format(($row->perangsuran ?? 0), 0, ',', '.') }}</td>
                <td>{{ $row->Ke }}</td>
                <td class="angsuran-ganjil">{{ $row->angsuran_date }}</td>
                <td class="angsuran-ganjil">{{ $row->penagihan_date }}</td>
                <td class="angsuran-ganjil">{{ $row->h }}</td>
                <td class="angsuran-ganjil rata-kanan">{{ number_format(($row->penagihan ?? 0), 0, ',', '.') }}
                </td>
                <td class="angsuran-ganjil rata-kanan">{{ number_format(($row->retur ?? 0), 0, ',', '.') }}</td>
                <td class="angsuran-ganjil rata-kanan">{{ number_format(($row->A ?? 0), 0, ',', '.') }}</td>
                <td>{{ $row->namapenagih }}</td>
                <td>{{ $row->kategori }}</td>
                <td>{{ $row->rating }}</td>
                <td>{{ $row->catatan }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
          @endif

          @if ($mode=="column")
          <table class="display table table-striped table-hover">
            <thead>
              <tr>
                <th>Tim</th>
                <th>Nota</th>
                <th>Customer Nama</th>
                <th>Customer Alamat</th>
                <th>PJ Kurir Nota</th>
                <th>PJ Admin Nota</th>
                <th>Tanggal Jual</th>
                <th>Angsuran Hari</th>
                <th>Angsuran Periode</th>
                <th>Omset</th>
                <th>Per Angsuran</th>
                <th>Penagihan 0</th>
                <th>Angsuran Date 1</th>
                <th>Penagihan 1 Date</th>
                <th>H1</th>
                <th>Penagihan 1</th>
                <th>Retur 1</th>
                <th>A1</th>
                <th>Angsuran Date 2</th>
                <th>Penagihan 2 Date</th>
                <th>H2</th>
                <th>Penagihan 2</th>
                <th>Retur 2</th>
                <th>A2</th>
                <th>Angsuran Date 3</th>
                <th>Penagihan 3 Date</th>
                <th>H3</th>
                <th>Penagihan 3</th>
                <th>Retur 3</th>
                <th>A3</th>
                <th>Angsuran Date 4</th>
                <th>Penagihan 4 Date</th>
                <th>H4</th>
                <th>Penagihan 4</th>
                <th>Retur 4</th>
                <th>A4</th>
                <th>Angsuran Date 5</th>
                <th>Penagihan 5 Date</th>
                <th>H5</th>
                <th>Penagihan 5</th>
                <th>Retur 5</th>
                <th>A5</th>
                <th>Angsuran Date 6</th>
                <th>Penagihan 6 Date</th>
                <th>H6</th>
                <th>Penagihan 6</th>
                <th>Retur 6</th>
                <th>A6</th>
                <th>Angsuran Date 7</th>
                <th>H7</th>
                <th>Penagihan 7</th>
                <th>Retur 7</th>
                <th>A7</th>
                <th>Angsuran Date 8</th>
                <th>Penagihan 8 Date</th>
                <th>H8</th>
                <th>Penagihan 8</th>
                <th>Retur 8</th>
                <th>A8</th>
                <th>Penagihan X</th>
                <th>Total Tagihan</th>
                <th>Total Retur</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              @foreach($data as $row)
              <tr>
                <td>{{ $row->tim }}</td>
                <td>{{ $row->nota }}</td>
                <td>{{ $row->customernama }}</td>
                <td>{{ $row->customeralamat }}</td>
                <td>{{ $row->pjkolektornota }}</td>
                <td>{{ $row->pjadminnota }}</td>
                <td>{{ $row->tgljual }}</td>
                <td>{{ $row->angsuranhari }}</td>
                <td>{{ $row->angsuranperiode }}</td>
                <td class="rata-kanan">{{ number_format(($row->omset ?? 0), 0, ',', '.') }}</td>
                <td class="rata-kanan">{{ number_format(($row->perangsuran ?? 0), 0, ',', '.') }}</td>
                <td class="rata-kanan">{{ number_format(($row->penagihan_0 ?? 0), 0, ',', '.') }}</td>
                <td class="angsuran-ganjil">{{ $row->angsuran_date_1 }}</td>
                <td class="angsuran-ganjil">{{ $row->Penagihan_1_date }}</td>
                <td class="angsuran-ganjil">{{ $row->h1 }}</td>
                <td class="angsuran-ganjil rata-kanan">{{ number_format(($row->penagihan_1 ?? 0), 0, ',', '.') }}
                </td>
                <td class="angsuran-ganjil rata-kanan">{{ number_format(($row->retur_1 ?? 0), 0, ',', '.') }}</td>
                <td class="angsuran-ganjil rata-kanan">{{ number_format(($row->A1 ?? 0), 0, ',', '.') }}</td>
                <td>{{ $row->angsuran_date_2 }}</td>
                <td>{{ $row->Penagihan_2_date }}</td>
                <td>{{ $row->h2 }}</td>
                <td class="rata-kanan">{{ number_format(($row->penagihan_2 ?? 0), 0, ',', '.') }}</td>
                <td class="rata-kanan">{{ number_format(($row->retur_2 ?? 0), 0, ',', '.') }}</td>
                <td class="rata-kanan">{{ number_format(($row->A2 ?? 0), 0, ',', '.') }}</td>
                <td class="angsuran-ganjil">{{ $row->angsuran_date_3 }}</td>
                <td class="angsuran-ganjil">{{ $row->Penagihan_3_date }}</td>
                <td class="angsuran-ganjil">{{ $row->h3 }}</td>
                <td class="angsuran-ganjil rata-kanan">{{ number_format(($row->penagihan_3 ?? 0), 0, ',', '.') }}
                </td>
                <td class="angsuran-ganjil rata-kanan">{{ number_format(($row->retur_3 ?? 0), 0, ',', '.') }}</td>
                <td class="angsuran-ganjil rata-kanan">{{ number_format(($row->A3 ?? 0), 0, ',', '.') }}</td>
                <td>{{ $row->angsuran_date_4 }}</td>
                <td>{{ $row->Penagihan_4_date }}</td>
                <td>{{ $row->h4 }}</td>
                <td class="rata-kanan">{{ number_format(($row->penagihan_4 ?? 0), 0, ',', '.') }}</td>
                <td class="rata-kanan">{{ number_format(($row->retur_4 ?? 0), 0, ',', '.') }}</td>
                <td class="rata-kanan">{{ number_format(($row->A4 ?? 0), 0, ',', '.') }}</td>
                <td class="angsuran-ganjil">{{ $row->angsuran_date_5 }}</td>
                <td class="angsuran-ganjil">{{ $row->Penagihan_5_date }}</td>
                <td class="angsuran-ganjil">{{ $row->h5 }}</td>
                <td class="angsuran-ganjil rata-kanan">{{ number_format(($row->penagihan_5 ?? 0), 0, ',', '.') }}
                </td>
                <td class="angsuran-ganjil rata-kanan">{{ number_format(($row->retur_5 ?? 0), 0, ',', '.') }}</td>
                <td class="angsuran-ganjil rata-kanan">{{ number_format(($row->A5 ?? 0), 0, ',', '.') }}</td>
                <td>{{ $row->angsuran_date_6 }}</td>
                <td>{{ $row->Penagihan_6_date }}</td>
                <td>{{ $row->h6 }}</td>
                <td class="rata-kanan">{{ number_format(($row->penagihan_6 ?? 0), 0, ',', '.') }}</td>
                <td class="rata-kanan">{{ number_format(($row->retur_6 ?? 0), 0, ',', '.') }}</td>
                <td class="rata-kanan">{{ number_format(($row->A6 ?? 0), 0, ',', '.') }}</td>
                <td class="angsuran-ganjil">{{ $row->angsuran_date_7 }}</td>
                <td class="angsuran-ganjil">{{ $row->h7 }}</td>
                <td class="angsuran-ganjil rata-kanan">{{ number_format(($row->penagihan_7 ?? 0), 0, ',', '.') }}
                </td>
                <td class="angsuran-ganjil rata-kanan">{{ number_format(($row->retur_7 ?? 0), 0, ',', '.') }}</td>
                <td class="angsuran-ganjil rata-kanan">{{ number_format(($row->A7 ?? 0), 0, ',', '.') }}</td>
                <td>{{ $row->angsuran_date_8 }}</td>
                <td>{{ $row->Penagihan_8_date }}</td>
                <td>{{ $row->h8 }}</td>
                <td class="rata-kanan">{{ number_format(($row->penagihan_8 ?? 0), 0, ',', '.') }}</td>
                <td class="rata-kanan">{{ number_format(($row->retur_8 ?? 0), 0, ',', '.') }}</td>
                <td class="rata-kanan">{{ number_format(($row->A8 ?? 0), 0, ',', '.') }}</td>
                <td class="angsuran-genap rata-kanan">{{ number_format(($row->penagihan_x ?? 0), 0, ',', '.') }}
                </td>
                <td class="angsuran-genap rata-kanan">{{ number_format(($row->TotTagihan ?? 0), 0, ',', '.') }}
                </td>
                <td class="angsuran-genap rata-kanan">{{ number_format(($row->TotRetur ?? 0), 0, ',', '.') }}</td>
                <td class="angsuran-genap rata-kanan">{{ number_format(($row->Total ?? 0), 0, ',', '.') }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
          @endif
        </div>
      </div>
    </div>
  </div>
  @if (in_array(auth()->user()->roles ?? '', ['SUPERVISOR', 'SPV ADMIN']))
  <button wire:click="exportExcel"
    wire:loading.attr="disabled"
    class="badge bg-success bg-sm d-flex justify-content-center align-items-center custom-hover mt-2"
    type="button"
    title="Export Excel">
    <svg xmlns="http://www.w3.org/2000/svg"
      width="16"
      height="16"
      fill="currentColor"
      class="bi bi-file-earmark-spreadsheet"
      viewBox="0 0 16 16">
      <path
        d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5zM3 12v-2h2v2zm0 1h2v2H4a1 1 0 0 1-1-1zm3 2v-2h3v2zm4 0v-2h3v1a1 1 0 0 1-1 1zm3-3h-3v-2h3zm-7 0v-2h3v2z" />
    </svg>
  </button>
  @endif
</div>