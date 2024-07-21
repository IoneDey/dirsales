<?php

namespace App\Livewire\Main\Penagihan;

use App\Models\Timsetup;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Laporanperformaangsuran extends Component {
    use WithPagination;

    public $title = 'Laporan Index Performa Angsuran (MAPE)';
    public $dbTimsetups;
    public $tim = 'Semua';
    public $timsetupid;


    public $dbPerformaAngsurans;
    public $iptotal = 50;

    //--cari + paginate
    public $cari = '';
    protected $paginationTheme = 'bootstrap';
    public function paginationView() {
        return 'vendor.livewire.bootstrap';
    }
    public function updatedcari() {
        // $this->resetPage();
        $this->dbPerformaAngsurans = $this->refresh();
    }
    //--end cari + paginate

    public function mount() {
        $this->dbTimsetups = Timsetup::get();
        $this->refresh();
    }

    public function updatedtim($id) {
        $this->timsetupid = $id;
        $this->refresh();
    }

    public function updatediptotal($iptotal) {
        $this->iptotal = $iptotal;
        $this->refresh();
    }

    public function refresh() {
        $query = DB::table('vwlistangsuran as a')
            ->leftJoin('penjualanhds as b', function ($join) {
                $join->on('a.nota', '=', 'b.nota')
                    ->on('a.timsetupid', '=', 'b.timsetupid');
            })
            ->leftJoin('vwindexperformaangsuran as c', function ($join) {
                $join->on('a.nota', '=', 'c.nota')
                    ->on('a.timsetupid', '=', 'c.timsetupid');
            })
            ->select(
                'c.tim',
                'c.ipjumlah',
                'c.ipwaktu',
                'c.iptotal',
                'a.*',
                'b.customernama',
                'b.tgljual'
            )
            ->where(function ($query) {
                $query->where('a.tglangsuran', 'like', '%' . $this->cari . '%')
                    ->orWhere('a.nota', 'like', '%' . $this->cari . '%');
            })
            ->orderBy('b.tgljual', 'asc')
            ->orderBy('a.nota', 'asc')
            ->orderBy('a.tglangsuran', 'asc');

        if ($this->tim <> 'Semua') {
            $query->where('a.timsetupid', $this->timsetupid);
        }

        if ($this->iptotal) {
            $query->where('c.iptotal', "<=", $this->iptotal);
        }

        $dbPerformaAngsurans = $query->get();

        $groupedData = $dbPerformaAngsurans->groupBy(function ($item) {
            // return $item->timsetupid . '-' . $item->nota;
            return $item->customernama . '-' . $item->timsetupid . '-' . $item->nota . '-'
                . $item->penjualan . '-' . $item->retur . '-' . $item->totaljual . '-'
                . $item->ipjumlah . '-' . $item->ipwaktu . '-' . $item->iptotal;
        });


        return $groupedData;
    }

    public function render() {
        $this->dbPerformaAngsurans = $this->refresh();

        return view('livewire.main.penagihan.laporanperformaangsuran', [
            'dbPerformaAngsurans' => $this->dbPerformaAngsurans,
        ])->layout('layouts.app-layout', [
            'menu' => 'navmenu.main',
            'title' => $this->title,
        ]);
    }
}
