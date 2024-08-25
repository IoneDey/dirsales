<?php

namespace App\Livewire\Main\Penjualan;

use App\Models\Penjualanret;
use App\Models\Penjualanretfoto;
use App\Models\Timsetup;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class Validasiretur extends Component {
    use WithFileUploads;
    public $title = 'Validasi Retur';
    public $dbTimsetups;

    public $timsetupid;
    public $tglAwal;
    public $tglAkhir;
    public $cari;

    public $dblistretur;
    public $dblistdetailretur;

    //head
    public $tglretur;
    public $noretur;
    public $userid;
    public $nota;

    // untuk block yg di pilih
    public $targetTglRetur;
    public $targetTimSetupId;
    public $targetnoretur;
    public $targetNota;

    //field
    public $tglvalid;
    public $kondisi = '';
    public $gudang = 'Gudang DS';
    public $catatan = '';
    public $fotovalid;
    public $qtyvalid = [];

    public function resetErrors() {
        $this->resetErrorBag();
    }

    public function mount() {
        $this->dbTimsetups = Timsetup::get();
        $this->tglAwal = Date('Y-m-01');
        $this->tglAkhir = Date('Y-m-t');
        $this->tglvalid = Date('Y-m-d');
        $this->refresh();
    }

    public function updated($property) {
        if ($property === 'timsetupid' || $property === 'tglAwal' || $property === 'tglAkhir' || $property === 'cari') {
            $this->refresh();
        }
    }

    public function selectNota($tglretur, $timsetupid, $nota, $noretur, $userid) {
        $this->userid = $userid;
        $this->refreshdetail($noretur, $tglretur, $timsetupid, $nota);
    }

    public function refresh() {
        $startDate = Carbon::parse($this->tglAwal)->format('Y-m-d');
        $endDate = Carbon::parse($this->tglAkhir)->format('Y-m-d');

        $query = DB::table('penjualanrets as a')
            ->leftJoin('timsetups as b', 'a.timsetupid', '=', 'b.id')
            ->leftJoin('tims as c', 'b.timid', '=', 'c.id')
            ->leftJoin('penjualanhds as d', function ($join) {
                $join->on('a.timsetupid', '=', 'd.timsetupid')
                    ->on('a.nota', '=', 'd.nota');
            })
            ->leftJoin('penjualanretfotos as e', function ($join) {
                $join->on('a.noretur', '=', 'e.noretur')
                    ->on('a.userid', '=', 'e.userid');
            })
            ->select(
                'a.timsetupid',
                'a.tglretur',
                'c.nama as tim',
                'a.nota',
                'd.customernama',
                'a.noretur',
                DB::raw('SUM(if(a.harga>0,a.qty,0)) as qtyretur'),
                DB::raw('SUM(a.qty * a.harga) as totalretur'),
                'e.foto',
                'a.userid'
            )
            ->whereBetween('tglretur', [$startDate, $endDate])
            ->where(function ($query) {
                $query->where('a.nota', 'like', '%' . $this->cari . '%')
                    ->orWhere('d.customernama', 'like', '%' . $this->cari . '%');
            })
            ->groupBy('a.timsetupid', 'a.tglretur', 'c.nama', 'a.nota', 'd.customernama', 'a.noretur', 'e.foto', 'a.userid');

        if ($this->timsetupid) {;
            $query->whereIn('a.timsetupid', [$this->timsetupid]);
        }

        $this->dblistretur = $query->get();
        $this->dblistdetailretur = null;
        $this->targetTglRetur = null;
        $this->targetTimSetupId = null;
        $this->targetnoretur = null;
        $this->targetNota = null;

        $this->tglvalid = Date('Y-m-d');
        $this->kondisi = '';
        $this->gudang = 'Gudang DS';
        $this->catatan = '';
        $this->fotovalid = null;
        $this->qtyvalid = [];

        $this->resetErrors();
    }

    public function refreshdetail($noretur, $tglretur, $timsetupid, $nota) {
        $this->targetTglRetur = $tglretur;
        $this->targetTimSetupId = $timsetupid;
        $this->targetnoretur = $noretur;
        $this->targetNota = $nota;

        $this->tglretur = $tglretur;
        $this->nota = $nota;
        $this->noretur = $noretur;
        $this->dblistdetailretur = DB::table('penjualanrets as a')
            ->select(
                'a.id',
                'a.tglretur',
                'a.noretur',
                'a.timsetupid',
                'a.nota',
                'a.timsetuppaketid',
                'a.barangid',
                'b.nama as barang',
                'a.qty',
                'a.harga',
                DB::raw('a.qty * a.harga as total')
            )
            ->leftJoin('barangs as b', 'a.barangid', '=', 'b.id')
            ->where('a.noretur', $this->noretur)
            ->where('a.tglretur', $this->tglretur)
            ->where('a.timsetupid', $timsetupid)
            ->where('a.nota', $this->nota)
            ->get();

        foreach ($this->dblistdetailretur as $item) {
            $this->qtyvalid[$item->id] = $item->qty;
        }
    }

    public function valid() {
        if ($this->tglretur || $this->timsetupid || $this->nota || $this->noretur || $this->userid) {
            $rules = [
                'tglvalid' => ['required', 'date'],
                'kondisi' => ['required', 'string', 'max:150'],
                'gudang' => ['required', 'string', 'max:150'],
                'catatan' => ['string', 'max:255'],
                'fotovalid' => ['sometimes', 'image', 'max:1024'],
            ];

            $validated = $this->validate($rules);

            if ($this->fotovalid) {
                $validated['fotovalid'] = $this->fotovalid->storeAs('upretur', 'vre-' . $this->noretur . $this->nota .  '.jpg', 'public');
            }

            // simpan
            $datas = $this->dblistdetailretur;
            DB::transaction(function () use ($datas, $validated) {
                foreach ($datas as $item) {
                    $dbupdate = Penjualanret::find($item->id);
                    if ($dbupdate) {
                        $validqty['qtyvalid'] = $this->qtyvalid[$item->id];
                        $dbupdate->update($validqty);
                    }
                    // dump($item->id, $this->qtyvalid[$item->id] ?? 0);
                }

                $dbupdatehd = Penjualanretfoto::where('noretur', $this->noretur)
                    ->where('userid', $this->userid)->first();

                $dbupdatehd->update($validated);
            });
            $msg = 'Validas Retur penjualan berhasil.';
            session()->flash('ok', $msg);

            $this->refresh();
        } else {
            $msg = 'Retur penjualan yang akan divalidasi belum dipilih !!!';
            session()->flash('error', $msg);
        }
    }

    public function render() {
        return view('livewire.main.penjualan.validasiretur')->layout('layouts.kai-layout', [
            'menu' => 'navmenu.main',
            'title' => $this->title,
        ]);
    }
}
