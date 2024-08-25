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

<!-- header nota -->
<div class="card">
    <div class="col-md-12">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 col-lg-4 mb-3">
                    <div x-data="{ isUpdate: @entangle('isUpdate') }" wire:ignore>
                        <span class="input-label">Tim</span>
                        <select x-data="{item: @entangle('timsetupid')}" x-init="$($refs.select2ref).select2(); $($refs.select2ref).on('change', function(){$wire.set('timsetupid', $(this).val());});" x-effect="$refs.select2ref.value = item; $($refs.select2ref).select2();" x-ref="select2ref" :disabled="isUpdate" class="form-select input-group-item">
                            <option value=""></option>
                            @foreach ($dbTimsetups as $dbTimsetup)
                            <option value="{{ $dbTimsetup->id }}">{{ $dbTimsetup->joinTim->nama }} ({{ $dbTimsetup->joinTim->joinPt->nama }}) - {{ $dbTimsetup->joinKota->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('timsetupid')
                    <span style="font-size: smaller; color: red;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="input-group-item" x-data="{ Nota: @entangle('nota') }">
                        <span class="input-label">Nota</span>
                        <input type="text" inputmode="numeric" maxlength="15" class="form-control" x-model="Nota" x-on:input="formatNota($event)">
                        @error('nota')
                        <span style="font-size: smaller; color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <span class="input-label">Angsuran - Hari</span>
                    <input wire:model="angsuranhari" type="number" class="form-control">
                    @error('angsuranhari')
                    <span style="font-size: smaller; color: red;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <span class="input-label">Angsuran - Periode</span>
                    <input wire:model="angsuranperiode" type="number" class="form-control">
                    @error('angsuranperiode')
                    <span style="font-size: smaller; color: red;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <span class="input-label">Kecamatan</span>
                    <input wire:model="kecamatan" type="text" class="form-control">
                    @error('kecamatan')
                    <span style="font-size: smaller; color: red;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <span class="input-label">Tgl Jual</span>
                    <input wire:model="tgljual" type="date" class="form-control">
                    @error('tgljual')
                    <span style="font-size: smaller; color: red;">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <!-- /header nota -->

    <div class="separator-solid"></div>

    <!-- entry customer -->
    <div class="col-md-12">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 col-lg-4 mb-3">
                    <span class="input-label">Nama Customer</span>
                    <input wire:model="customernama" type="text" class="form-control">
                    @error('customernama')
                    <span style="font-size: smaller; color: red;">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 col-lg-4 mb-3">
                    <span class="input-label">Alamat Customer</span>
                    <input wire:model="customeralamat" type="text" class="form-control">
                    @error('customeralamat')
                    <span style="font-size: smaller; color: red;">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 col-lg-4 mb-3">
                    <span class="input-label">No.Telp Customer</span>
                    <input wire:model="customernotelp" type="text" class="form-control">
                    @error('customernotelp')
                    <span style="font-size: smaller; color: red;">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 col-lg-4 mb-3">
                    <span class="input-label">Share Lokasi</span>
                    <input wire:model="shareloc" type="text" class="form-control">
                    @error('shareloc')
                    <span style="font-size: smaller; color: red;">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <!-- /entry customer -->

    <div class="separator-solid"></div>

    <!-- sales driver lock dll -->
    <div class="col-md-12">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 col-lg-4 mb-3">
                    <span class="input-label">Nama Sales</span>
                    <select wire:model="namasales" type="text" class="form-select">
                        <option value=""></option>
                        @if($dbSaless)
                        @foreach ($dbSaless as $dbSales)
                        <option value="{{ $dbSales->nama }}">{{ $dbSales->nama }}</option>
                        @endforeach
                        @endif
                    </select>
                    @error('namasales')
                    <span style="font-size: smaller; color: red;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <span class="input-label">Surveyor</span>
                    <select wire:model="namalock" type="text" class="form-select">
                        <option value=""></option>
                        @if($dbSurveyorss)
                        @foreach ($dbSurveyorss as $dbSurveyors)
                        <option value="{{ $dbSurveyors->nama }}">{{ $dbSurveyors->nama }}</option>
                        @endforeach
                        @endif
                    </select>
                    @error('namalock')
                    <span style="font-size: smaller; color: red;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
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

                <div class="col-md-6 col-lg-4 mb-3">
                    <span class="input-label">Penanggung jawab Kurir Nota</span>
                    <select wire:model="pjkolektornota" type="text" class="form-select">
                        <option value=""></option>
                        @if($dbDrivers)
                        @foreach ($dbKolektors as $dbKolektor)
                        <option value="{{ $dbKolektor->nama }}">{{ $dbKolektor->nama }}</option>
                        @endforeach
                        @endif
                    </select>
                    @error('pjkolektornota')
                    <span style="font-size: smaller; color: red;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <span class="input-label">Penanggung jawab Asisten Kurir</span>
                    <select wire:model="pjkolektorasisten" type="text" class="form-select">
                        <option value=""></option>
                        @if($dbDrivers)
                        @foreach ($dbKolektors as $dbKolektor)
                        <option value="{{ $dbKolektor->nama }}">{{ $dbKolektor->nama }}</option>
                        @endforeach
                        @endif
                    </select>
                    @error('pjkolektorasisten')
                    <span style="font-size: smaller; color: red;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <span class="input-label">Penanggung jawab Admin Nota</span>
                    <input wire:model="pjadminnota" type="text" class="form-control">
                    @error('pjadminnota')
                    <span style="font-size: smaller; color: red;">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <!-- /sales driver lock dll -->

    <div class="separator-solid"></div>

    <!-- upload nota rekap -->
    <div class="col-md-12">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 col-lg-4 mb-3">
                    <span class="input-label" for="inputGroupKTP">Foto KTP</span>
                    <input wire:model="fotoktp" accept="image/png, image/jpeg" type="file" class="form-control" id="inputGroupKTP">
                    <div wire:loading wire:target="fotoktp">Uploading...</div>
                    @error('fotoktp')
                    <span style="font-size: smaller; color: red;">{{ $message }}</span>
                    @enderror
                    @if (is_string($fotoktp) && strlen($fotoktp) > 0)
                    <img src="{{ asset('storage/' . $fotoktp) }}" class="img-fluid rounded mx-auto d-block mt-2" alt="...">
                    @else
                    @if ($fotoktp)
                    <img src="{{ $fotoktp->temporaryUrl() }}" class="img-fluid rounded mx-auto d-block mt-2" alt="...">
                    @endif
                    @endif
                </div>
                <div class="col-md-6 col-lg-4 mb-3">
                    <span class="input-label" for="inputGroupNota">Foto Nota</span>
                    <input wire:model="fotonota" accept="image/png, image/jpeg" type="file" class="form-control" id="inputGroupNota">
                    <div wire:loading wire:target="fotonota">Uploading...</div>
                    @error('fotonota')
                    <span style="font-size: smaller; color: red;">{{ $message }}</span>
                    @enderror
                    @if (is_string($fotonota) && strlen($fotonota) > 0)
                    <img src="{{ asset('storage/' . $fotonota) }}" class="img-fluid rounded mx-auto d-block mt-2" alt="...">
                    @else
                    @if ($fotonota)
                    <img src="{{ $fotonota->temporaryUrl() }}" class="img-fluid rounded mx-auto d-block mt-2" alt="...">
                    @endif
                    @endif
                </div>
                <div class="col-md-6 col-lg-4 mb-3">
                    <span class="input-label" for="inputGroupNota">Foto Rekap Sales</span>
                    <input wire:model="fotonotarekap" accept="image/png, image/jpeg" type="file" class="form-control" id="inputGroupNotaRekap">
                    @error('fotonotarekap')
                    <span style="font-size: smaller; color: red;">{{ $message }}</span>
                    @enderror
                    <div wire:loading wire:target="fotonotarekap">Uploading...</div>
                    @if (is_string($fotonotarekap) && strlen($fotonotarekap) > 0)
                    <img src="{{ asset('storage/' . $fotonotarekap) }}" class="img-fluid rounded mx-auto d-block mt-2" alt="...">
                    @else
                    @if ($fotonotarekap)
                    <img src="{{ $fotonotarekap->temporaryUrl() }}" class="img-fluid rounded mx-auto d-block mt-2" alt="...">
                    @endif
                    @endif
                </div>
                <div class="col-md-6 col-lg-4 mb-3">
                    <span class="input-label" for="inputGroupSuratUndian">Foto Akad Jual Beli</span>
                    <input wire:model="fotosuratundian" accept="image/png, image/jpeg" type="file" class="form-control" id="inputGroupSuratUndian">
                    @error('fotosuratundian')
                    <span style="font-size: smaller; color: red;">{{ $message }}</span>
                    @enderror
                    <div wire:loading wire:target="fotosuratundian">Uploading...</div>
                    @if (is_string($fotosuratundian) && strlen($fotosuratundian) > 0)
                    <img src="{{ asset('storage/' . $fotosuratundian) }}" class="img-fluid rounded mx-auto d-block mt-2" alt="...">
                    @else
                    @if ($fotosuratundian)
                    <img src="{{ $fotosuratundian->temporaryUrl() }}" class="img-fluid rounded mx-auto d-block mt-2" alt="...">
                    @endif
                    @endif
                </div>
            </div>
            <div class="card-action">
                @if ($isUpdate)
                <button wire:click="update" type="button" class="btn btn-primary btn-round">Update</button>
                @else
                <button wire:click="create" type="button" class="btn btn-primary btn-round">Simpan</button>
                @endif
            </div>
        </div>
    </div>
    <!-- /upload nota rekap -->
</div>

<!-- detail entry paket -->
<div class="card">
    <div class="card-header">
        <div class="card-title">Detail Barang</div>
    </div>
    <!-- entry paket -->
    <div class="col-md-12">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 col-lg-4 mb-3">
                    <span class="input-label">Barang (Paket)</span>
                    <select wire:model="timsetuppaketid" class="form-control" {{ $isUpdate ? '' : 'disabled' }}>
                        <option value=""></option>
                        @foreach ($dbTimssetuppakets as $dbTimssetuppaket)
                        <option value="{{ $dbTimssetuppaket->id }}">{{ $dbTimssetuppaket->nama }}</option>
                        @endforeach
                    </select>
                    @error('timsetuppaketid')
                    <span style="font-size: smaller; color: red;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <span class="input-label">Jumlah Barang</span>
                    <input wire:model="jumlah" type="number" class="form-control" {{ $isUpdate ? '' : 'disabled' }}>
                    @error('jumlah')
                    <span style="font-size: smaller; color: red;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="card-action">
                @if ($isUpdatePaket)
                <button wire:click="updatePaket" type="button" class="btn btn-primary btn-round" {{ $isUpdate ? '' : 'disabled' }}>Update</button>
                @else
                <button wire:click="createPaket" type="button" class="btn btn-primary btn-round" {{ $isUpdate ? '' : 'disabled' }}>Simpan</button>
                @endif
                <button wire:click="clearPaket" type="button" class="btn btn-secondary btn-round" {{ $isUpdate ? '' : 'disabled' }}>Bersihkan</button>
            </div>
        </div>
    </div>

    <!-- list paket -->
    <div class="card-body">
        <div class="table-responsive text-nowrap">
            <table class="display table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">Act</th>
                        <th scope="col">#</th>
                        <th scope="col">Paket</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col" class="rata-kanan">H.Jual</th>
                        <th scope="col">Barang</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dbPenjualandts as $dbPenjualandt)
                    <tr>
                        <td>
                            <a wire:click="editPaket({{ $dbPenjualandt->id }})" wire:loading.attr="disabled" type="button" class="badge bg-warning bg-sm"><i class="fas fa-edit fa-lg"></i></a>
                            <a wire:click="confirmDeletePaket({{ $dbPenjualandt->id }})" wire:loading.attr="disabled" type="button" class="badge bg-danger bg-sm" data-bs-toggle="modal" data-bs-target="#ModalDeletePaket"><i class="fas fa-eraser fa-lg"></i></a>
                        </td>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $dbPenjualandt->joinTimSetupPaket->nama }}</td>
                        <td>{{ $dbPenjualandt->jumlah }}</td>
                        <td class="rata-kanan">{{ number_format($dbPenjualandt->joinTimSetupPaket->hargajual, 0, ',', '.') }}</td>
                        <td>
                            <ul style="list-style-type: none; padding-left: 0;">
                                @foreach ($dbPenjualandt->joinTimSetupPaket->joinTimSetupBarang as $joinTimSetupBarang)
                                <li>&bull; {{ $joinTimSetupBarang->joinBarang->nama }}</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- modal delete paket -->
<div wire:ignore.self class="modal fade" id="ModalDeletePaket" tabindex="-1" aria-labelledby="ModalDeleteLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="ModalDeleteLabel">Hapus Data</h1>
                <button wire:click="clearPaket" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Anda yakin hapus data {{ $paketnama }}?
            </div>
            <div class="modal-footer">
                <button wire:click="clearPaket" type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <button wire:click="deletePaket()" type="button" class="btn btn-primary" data-bs-dismiss="modal">Yes</button>
            </div>
        </div>
    </div>
</div>