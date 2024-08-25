<?php

namespace App\Livewire\Main\Penjualan;

use App\Exports\Penjualanreturdetail;
use App\Models\Penjualanret;
use App\Models\Penjualanretfoto;
use App\Models\Timsetup;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Laporanretur extends Component {
    use WithPagination;

    public $title = 'Laporan Retur Penjualan';
    public $tglAwal;
    public $tglAkhir;
    public $timsetupid = [];

    public $dbTimsetups;
    public $gtQty;
    public $gtJumlah;


    public $noretur;
    public $totalCount;

    public $JenisRpt = 'REKAP';

    //--cari + paginate
    public $cari = '';
    protected $paginationTheme = 'bootstrap';
    public function paginationView() {
        return 'vendor.livewire.bootstrap';
    }
    public function updatedcari() {
        $this->resetPage();
    }
    //--end cari + paginate

    public function updatedJenisRpt($jenisrpt) {
        $this->JenisRpt = $jenisrpt;
        $this->refresh();
    }

    public function mount() {
        $this->tglAwal = date('Y-m-01'); // Mengambil tanggal pertama dari bulan ini
        $this->tglAkhir = date('Y-m-t'); // Mengambil tanggal terakhir dari bulan ini
        $this->dbTimsetups = Timsetup::get();
    }

    public function updatedtglAwal() {
        $this->refresh();
    }

    public function updatedtglAkhir() {
        $this->refresh();
    }

    public function confirmDeleteRetur($noretur) {
        $this->noretur = $noretur;
        $this->totalCount  = DB::table('penjualanrets as a')
            ->where('a.noretur', $this->noretur)
            ->count();
    }

    public function deleteRetur() {
        if ($this->totalCount > 0) {
            $noretur = $this->noretur;
            DB::transaction(function () use ($noretur) {
                Penjualanret::where('noretur', $noretur)->delete();

                Penjualanretfoto::where('noretur', $noretur)->delete();
            }, 5);
            $this->js('alert("Data retur no: ' . $this->noretur . ' sudah terhapus.")');
            $this->noretur = null;
            $this->totalCount = null;
        }
    }

    public function refresh() {

        $startDate = Carbon::parse($this->tglAwal)->format('Y-m-d');
        $endDate = Carbon::parse($this->tglAkhir)->format('Y-m-d');

        if ($this->JenisRpt == 'REKAP') {
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
                    DB::raw('SUM(if(a.harga>0,a.qtyvalid,0)) as qtyvalid'),
                    'e.fotovalid'
                )
                ->whereBetween('tglretur', [$startDate, $endDate])
                ->where(function ($query) {
                    $query->where('a.nota', 'like', '%' . $this->cari . '%')
                        ->orWhere('d.customernama', 'like', '%' . $this->cari . '%');
                })
                ->groupBy('a.timsetupid', 'a.tglretur', 'c.nama', 'a.nota', 'd.customernama', 'a.noretur', 'e.foto', 'e.fotovalid');
        }

        if ($this->JenisRpt == 'DETAIL') {
            // queryDetail
            $query = DB::table('penjualanrets as a')
                ->leftJoin('timsetups as b', 'a.timsetupid', '=', 'b.id')
                ->leftJoin('tims as c', 'b.timid', '=', 'c.id')
                ->leftJoin('timsetuppakets as d', 'd.id', '=', 'a.timsetuppaketid')
                ->leftJoin('timsetupbarangs as e', function ($join) {
                    $join->on('e.timsetuppaketid', '=', 'a.timsetuppaketid')
                        ->on('e.barangid', '=', 'a.barangid');
                })
                ->leftJoin('barangs as f', 'a.barangid', '=', 'f.id')
                ->leftJoin('penjualanhds as g', function ($join) {
                    $join->on('a.timsetupid', '=', 'g.timsetupid')
                        ->on('a.nota', '=', 'g.nota');
                })
                ->select(
                    'a.timsetupid',
                    'c.nama as tim',
                    'a.tglretur',
                    'a.noretur',
                    'a.nota',
                    'g.customernama',
                    'f.nama as namabarang',
                    'a.qty as qtyretur',
                    'a.qtyvalid as qtyvalid',
                    'a.harga as hargaretur',
                    DB::raw('a.qty * a.harga as totalretur')
                )
                ->whereBetween('tglretur', [$startDate, $endDate])
                ->where(function ($query) {
                    $query->where('a.nota', 'like', '%' . $this->cari . '%')
                        ->orWhere('g.customernama', 'like', '%' . $this->cari . '%');
                });
        }

        $queryTotal = DB::table('penjualanrets as a')
            ->leftJoin('timsetups as b', 'a.timsetupid', '=', 'b.id')
            ->leftJoin('tims as c', 'b.timid', '=', 'c.id')
            ->leftJoin('penjualanhds as d', function ($join) {
                $join->on('a.timsetupid', '=', 'd.timsetupid')
                    ->on('a.nota', '=', 'd.nota');
            })
            ->select(
                DB::raw('SUM(a.qty) as totalqty'),
                DB::raw('SUM(a.qty * a.harga) as totalretur')
            )
            ->whereBetween('tglretur', [$startDate, $endDate])
            ->where(function ($query) {
                $query->where('a.nota', 'like', '%' . $this->cari . '%')
                    ->orWhere('d.customernama', 'like', '%' . $this->cari . '%');
            });

        if (is_array($this->timsetupid) && count($this->timsetupid) > 0) {;
            $query->whereIn('a.timsetupid', $this->timsetupid);
            $queryTotal->whereIn('a.timsetupid', $this->timsetupid);
        }

        $dbTotal = $queryTotal->get();
        if ($dbTotal) {
            $this->gtQty = $dbTotal[0]->totalqty;
            $this->gtJumlah = $dbTotal[0]->totalretur;
        }

        $dbReturPenjualan = $query->paginate(25);
        return $dbReturPenjualan;
    }

    public function exportExcel() {
        $startDate = Carbon::parse($this->tglAwal)->format('Y-m-d');
        $endDate = Carbon::parse($this->tglAkhir)->format('Y-m-d');

        $query = DB::table('penjualanrets as a')
            ->leftJoin('timsetups as b', 'a.timsetupid', '=', 'b.id')
            ->leftJoin('tims as c', 'b.timid', '=', 'c.id')
            ->leftJoin('timsetuppakets as d', 'd.id', '=', 'a.timsetuppaketid')
            ->leftJoin('timsetupbarangs as e', function ($join) {
                $join->on('e.timsetuppaketid', '=', 'a.timsetuppaketid')
                    ->on('e.barangid', '=', 'a.barangid');
            })
            ->leftJoin('barangs as f', 'a.barangid', '=', 'f.id')
            ->leftJoin('penjualanhds as g', function ($join) {
                $join->on('a.timsetupid', '=', 'g.timsetupid')
                    ->on('a.nota', '=', 'g.nota');
            })
            ->leftJoin('penjualanretfotos as h', function ($join) {
                $join->on('a.noretur', '=', 'h.noretur')
                    ->on('a.userid', '=', 'h.userid');
            })
            ->select(
                'c.nama as tim',
                'a.created_at as Timestamp',
                'a.tglretur',
                'a.nota',
                'g.customernama',
                'f.nama as namabarang',
                'a.qty as qtyretur',
                'a.harga as hargaretur',
                DB::raw('a.qty * a.harga as totalretur'),
                DB::raw("CONCAT('" . asset('storage/') . "/',h.foto) as foto"),
                'a.tglvalid',
                'a.qtyvalid',
            )
            ->whereBetween('tglretur', [$startDate, $endDate])
            ->where(function ($query) {
                $query->where('a.nota', 'like', '%' . $this->cari . '%')
                    ->orWhere('g.customernama', 'like', '%' . $this->cari . '%');
            });

        if (is_array($this->timsetupid) && count($this->timsetupid) > 0) {;
            $query->whereIn('a.timsetupid', $this->timsetupid);
        }

        $data = $query->get();
        return Excel::download(new Penjualanreturdetail($data), 'ReturPenjualanDetail.xlsx');
    }

    public function render() {
        $penjualanreturs = $this->refresh();

        return view('livewire.main.penjualan.laporanretur', [
            'penjualanreturs' => $penjualanreturs,
        ])->layout('layouts.kai-layout', [
            'menu' => 'navmenu.main',
            'title' => $this->title,
        ]);
    }
}