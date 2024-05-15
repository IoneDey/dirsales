<?php

namespace App\Livewire\Main\Penjualan;

use App\Models\Penjualandt;
use App\Models\Penjualanhd;
use App\Models\Timsetup;
use App\Models\Timsetuppaket;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Index extends Component {
    use WithPagination;
    use WithFileUploads;

    public $title = 'Penjualan';

    //entity
    public $timsetupid;
    public $nota;
    public $tgljual;
    public $angsuranhari;
    public $angsuranperiode;
    public $customernama;
    public $customeralamat;
    public $customernotelp;
    public $shareloc;
    public $namasales;
    public $namalock;
    public $namadriver;
    public $pjkolektornota;
    public $pjadminnota;
    public $fotonotarekap;

    public $penjualanhdid;
    public $timsetupnama;
    public $jumlahTotal;
    public $validMessage;

    //barang-paket
    public $timsetuppaketid;
    public $jumlah;
    public $jumlahkoreksi;

    public $penjualandtid;

    public $paketnama;


    //lain2x
    public $isUpdate;
    public $isUpdatePaket;

    public $isEditor = false;

    //db
    public $dbTimsetups;

    public function resetErrors() {
        $this->resetErrorBag();
    }

    public function mount() {
        $this->dbTimsetups = Timsetup::get();
    }

    public function entryNew() {
        $this->clear();
        $this->clearPaket();
        $this->isEditor = true;
        $this->isUpdate = false;
    }

    //head
    public function updatedtimsetupid($id) {
        $dbTimsetuppaket = Timsetup::where('id', $id)->first();
        $this->angsuranhari = $dbTimsetuppaket->angsuranhari;
        $this->angsuranperiode = $dbTimsetuppaket->angsuranperiode;
    }

    public function create() {
        $rules = [
            'timsetupid' => 'required',
            'nota' => 'required|string|unique:penjualanhds',
            'tgljual' => 'required|date',
            'angsuranhari' => 'required|numeric|min:1|max:10',
            'angsuranperiode' => 'required|numeric|min:1|max:10',
            'customernama' => 'required|string|max:150',
            'customeralamat' => 'string|max:255',
            'customernotelp' => 'required|string',
            'shareloc' => 'string|max:150',
            'namasales' => 'required|string|max:150',
            'namalock' => 'required|string|max:150',
            'namadriver' => 'required|string|max:150',
            'pjkolektornota' => 'required|string|max:150',
            'pjadminnota' => 'required|string|max:150',
            'fotonotarekap' => 'required|sometimes|image|max:1024',
        ];

        $validated = $this->validate($rules);
        if ($this->fotonotarekap) {
            $validated['fotonotarekap'] = $this->fotonotarekap->storeAs('uploads', 'notarekap-' . $this->nota . '.jpg', 'public');
        }
        $validated['status'] = 'Entry';
        $validated['userid'] = auth()->user()->id;

        Penjualanhd::create($validated);
        $msg = 'Tambah data ' . $this->nota . ' berhasil.';
        session()->flash('ok', $msg);

        $this->penjualanhdid = Penjualanhd::where('nota', $this->nota)->pluck('id')->first();
        $this->isUpdate = true;
    }

    public function edit($id) {
        $this->getData($id);
        $this->isUpdate = true;
        $this->isEditor = true;
    }

    public function update() {
        //$this->js('alert("Under construction!!!")');
        if ($this->penjualanhdid) {
            $data = Penjualanhd::find($this->penjualanhdid);

            $rules = [
                'timsetupid' => 'required',
                'tgljual' => 'required|date',
                'angsuranhari' => 'required|numeric|min:1|max:10',
                'angsuranperiode' => 'required|numeric|min:1|max:10',
                'customernama' => 'required|string|max:150',
                'customeralamat' => 'required|string|max:255',
                'customernotelp' => 'required|string',
                'shareloc' => 'required|string|max:150',
                'namasales' => 'required|string|max:150',
                'namalock' => 'required|string|max:150',
                'namadriver' => 'required|string|max:150',
                'pjkolektornota' => 'required|string|max:150',
                'pjadminnota' => 'required|string|max:150',
            ];

            if ($this->nota != $data->nota) {
                $rules['nota'] = ['required', 'string', 'unique:penjualanhds'];
            }
            if ($this->fotonotarekap != $data->fotonotarekap) {
                $rules['fotonotarekap'] = ['required', 'sometimes', 'image', 'max:1024'];
            }

            $validated = $this->validate($rules);
            if (!is_string($this->fotonotarekap)) {
                if ($this->fotonotarekap) {
                    $validated['fotonotarekap'] = $this->fotonotarekap->storeAs('uploads', 'notarekap-' . $this->nota . '.jpg', 'public');
                }
            }

            $validated['penjualanhdid'] = $this->penjualanhdid;
            $validated['userid'] = auth()->user()->id;

            try {
                $data->update($validated);

                $msg = 'Update data Nota: ' . $this->nota . ' berhasil.';
                $this->clearPaket();
                session()->flash('ok', $msg);
            } catch (\Exception $e) {
                $errors = implode("\n", array('Terjadi kesalahan:   ', 'Data sudah terpakai.', '(' . $e->getMessage() . ')'));
                session()->flash('error', $errors);
            }
        }
    }

    public function confirmDelete($id) {
        $this->getData($id);
        $this->isUpdate = true;
        $this->isEditor = true;
    }

    public function delete() {
        if ($this->penjualanhdid) {
            $data = Penjualanhd::find($this->penjualanhdid);
            $msg = 'Data ' . $this->nota . ' berhasil dihapus.';
            try {
                $data->delete();
                $this->clear();
                $this->clearPaket();
                $this->isEditor = false;
                $this->isUpdate = false;
                session()->flash('ok', $msg);
            } catch (\Exception $e) {
                $errors = implode("\n", array('Terjadi kesalahan:   ', 'Data sudah terpakai.'));
                session()->flash('error', $errors);
            }
            //$this->js('alert("$this->msg")');
        }
    }

    public function clear() {
        $this->timsetupid = "";
        $this->nota = "";
        $this->tgljual = "";
        $this->angsuranhari = "";
        $this->angsuranperiode = "";
        $this->customernama = "";
        $this->customeralamat = "";
        $this->customernotelp = "";
        $this->shareloc = "";
        $this->namasales = "";
        $this->namalock = "";
        $this->namadriver = "";
        $this->pjkolektornota = "";
        $this->pjadminnota = "";
        $this->fotonotarekap = "";
        $this->penjualanhdid = "";
    }

    public function getData($id) {
        $data = Penjualanhd::find($id);
        $this->penjualanhdid = $data->id;
        $this->timsetupid = $data->timsetupid;
        $this->nota = $data->nota;
        $this->tgljual = $data->tgljual;
        $this->angsuranhari = $data->angsuranhari;
        $this->angsuranperiode = $data->angsuranperiode;
        $this->customernama = $data->customernama;
        $this->customeralamat = $data->customeralamat;
        $this->customernotelp = $data->customernotelp;
        $this->shareloc = $data->shareloc;
        $this->namasales = $data->namasales;
        $this->namalock = $data->namalock;
        $this->namadriver = $data->namadriver;
        $this->pjkolektornota = $data->pjkolektornota;
        $this->pjadminnota = $data->pjadminnota;
        $this->fotonotarekap = $data->fotonotarekap;

        $this->timsetupnama = $data->joinTimSetup->joinTim->nama;
        //dump($this->timsetupnama);
    }

    public function confirmValid($id, $tot) {
        $this->jumlahTotal = $tot;
        $this->getData($id);
        $this->isUpdate = true;
        $this->isEditor = true;

        // cek kelengkapan detail data
        $hasil = PenjualanHd::find($id)
            ->leftJoin('penjualandts as b', 'b.penjualanhdid', '=', 'penjualanhds.id')
            ->leftJoin('timsetuppakets as c', function ($join) {
                $join->on('c.id', '=', 'b.timsetuppaketid')
                    ->leftJoin('timsetupbarangs as d', 'd.timsetuppaketid', '=', 'c.id');
            })
            ->where('penjualanhds.id', $id)
            ->where('d.timsetuppaketid', null)
            ->select('c.nama')
            ->get();

        $this->validMessage = "";
        if ($hasil->count() != 0) {
            $this->validMessage = "Paket ";
            foreach ($hasil as $item) {
                $this->validMessage .= $item->nama . ", ";
            }
            $this->validMessage = rtrim($this->validMessage, ", ") . ". Tidak memiliki detail barang.";
            $this->validMessage .= " Segera hubungi supervisor untuk melakukan setting barang pada paket.";
        }
    }

    public function valid() {
        //dump($this->jumlahTotal);
        if ($this->penjualanhdid) {
            $data = Penjualanhd::find($this->penjualanhdid);
            $data->status = 'Entry Valid';
            $data->save();
            $this->entryNew();
        }
    }
    //end head

    //paket
    public function updatedtimsetuppaketid($id) {
        $this->paketnama = Timsetuppaket::where('id', $id)->plucK('nama')->first();
    }

    public function createPaket() {
        $rulepakets = [
            'timsetuppaketid' => [
                'required',
                Rule::unique('penjualandts')->where(function ($query) {
                    return $query->where('timsetuppaketid', $this->timsetuppaketid)
                        ->where('penjualanhdid', $this->penjualanhdid);
                })
            ],
            'jumlah' => ['required', 'numeric', 'min:1'],
        ];
        $pesan = [
            'timsetuppaketid.required' => 'Paket wajib diisi.',
            'timsetuppaketid.unique' => 'Paket sudah ada.',
        ];
        $validatedPaket = $this->validate($rulepakets, $pesan);
        $validatedPaket['penjualanhdid'] = $this->penjualanhdid;
        $validatedPaket['jumlahkoreksi'] = 0;
        $validatedPaket['userid'] = auth()->user()->id;

        Penjualandt::create($validatedPaket);
        $msg = 'Tambah data ' . $this->paketnama . ' berhasil.';
        session()->flash('ok', $msg);

        $this->clearPaket();
    }

    public function editPaket($id) {
        $data = Penjualandt::find($id);
        $this->timsetuppaketid = $data->timsetuppaketid;
        $this->jumlah = $data->jumlah;
        $this->jumlahkoreksi = $data->jumlahkoreksi;

        $this->penjualandtid = $data->id;
        $this->paketnama = $data->joinTimSetupPaket->nama;
        $this->isUpdatePaket = true;
    }

    public function updatePaket() {
        if ($this->penjualandtid) {
            $data = Penjualandt::find($this->penjualandtid);

            $rulesPaket = [
                'jumlah' => ['required', 'numeric', 'min:1'],
            ];

            if ($this->timsetuppaketid != $data->timsetuppaketid) {
                $rulesPaket['timsetuppaketid'] = [
                    'required',
                    Rule::unique('penjualandts')->where(function ($query) {
                        return $query->where('timsetuppaketid', $this->timsetuppaketid)
                            ->where('penjualanhdid', $this->penjualanhdid);
                    })
                ];
            }
            $validatePaket = $this->validate($rulesPaket);
            $validatePaket['penjualanhdid'] = $this->penjualanhdid;
            $validatePaket['userid'] = auth()->user()->id;

            try {
                $data->update($validatePaket);

                $msg = 'Update data ' . $this->paketnama . ' berhasil.';
                $this->clearPaket();
                session()->flash('ok', $msg);
            } catch (\Exception $e) {
                $errors = implode("\n", array('Terjadi kesalahan:   ', 'Data sudah terpakai.', '(' . $e->getMessage() . ')'));
                session()->flash('error', $errors);
            }
        }
    }

    public function confirmDeletePaket($id) {
        $data = Penjualandt::find($id);
        $this->timsetuppaketid = $data->timsetuppaketid;
        $this->jumlah = $data->jumlah;

        $this->penjualandtid = $data->id;
        $this->paketnama = $data->joinTimSetupPaket->nama;
        $this->isUpdatePaket = true;
    }

    public function deletePaket() {
        if ($this->penjualandtid) {
            $data = Penjualandt::find($this->penjualandtid);
            $msg = 'Data ' . $this->paketnama . ' berhasil dihapus.';
            try {
                $data->delete();
                $this->clearPaket();
                session()->flash('ok', $msg);
            } catch (\Exception $e) {
                $errors = implode("\n", array('Terjadi kesalahan:   ', 'Data sudah terpakai.'));
                session()->flash('error', $errors);
            }
            //$this->js('alert("$this->msg")');
        }
    }

    public function clearPaket() {
        $this->timsetuppaketid = "";
        $this->jumlah = "";
        $this->jumlahkoreksi = "";
        $this->paketnama = "";

        $this->isUpdatePaket = false;
    }
    //end paket

    public function render() {
        $dbTimssetuppakets = Timsetuppaket::where('timsetupid', $this->timsetupid)->get();

        $dbPenjualandts = Penjualandt::where('penjualanhdid', $this->penjualanhdid)->get();

        $listPenjualans = Penjualanhd::select(
            'penjualanhds.id',
            'penjualanhds.tgljual',
            'tims.nama as Tim',
            'penjualanhds.nota',
            'penjualanhds.customernama',
            'penjualanhds.customeralamat',
            'penjualanhds.customernotelp',
            DB::raw('SUM(penjualandts.jumlah * timsetuppakets.hargajual) AS totaljual'),
            'users.name AS userentry',
            'penjualanhds.updated_at'
        )
            ->leftJoin('penjualandts', 'penjualanhds.id', '=', 'penjualandts.penjualanhdid')
            ->leftJoin('timsetuppakets', 'penjualandts.timsetuppaketid', '=', 'timsetuppakets.id')
            ->leftJoin('users', 'penjualanhds.userid', '=', 'users.id')
            ->leftJoin('timsetups', 'penjualanhds.timsetupid', '=', 'timsetups.id')
            ->leftJoin('tims', 'timsetups.timid', '=', 'tims.id')
            ->where('penjualanhds.userid', auth()->user()->id)
            ->where('status', 'Entry')
            ->groupBy('penjualanhds.id', 'penjualanhds.tgljual', 'tims.nama', 'penjualanhds.nota', 'penjualanhds.customernama', 'penjualanhds.customeralamat', 'penjualanhds.customernotelp', 'users.name', 'penjualanhds.updated_at')
            ->get();

        return view('livewire.main.penjualan.index', [
            'listPenjualans' => $listPenjualans,
            'dbTimssetuppakets' => $dbTimssetuppakets,
            'dbPenjualandts' => $dbPenjualandts,
        ])->layout('layouts.app-layout', [
            'menu' => 'navmenu.main',
            'title' => $this->title,
        ]);
    }
}
