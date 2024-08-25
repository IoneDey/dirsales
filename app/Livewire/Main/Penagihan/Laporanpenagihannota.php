<?php

namespace App\Livewire\Main\Penagihan;

use App\Models\Timsetup;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Laporanpenagihannota extends Component {
    use WithPagination;
    public $title = 'Laporan Sisa Penagihan / Nota';

    public $dbTimsetups;
    public $tim = 'Semua';
    public $chkFilterSisa = false;

    //--cari + paginate
    public $cari = '';
    protected $paginationTheme = 'bootstrap';
    public function paginationView() {
        return 'vendor.livewire.bootstrap';
    }
    public function updatedcari() {
        // $this->resetPage();
        if (strlen($this->cari) >= 3) {
            $this->refresh();
        }
    }
    //--end cari + paginate

    public function mount() {
        $this->dbTimsetups = Timsetup::get();
    }

    public function updatedchkFilterSisa() {
        $this->refresh();
    }

    public function refresh() {
        $tim = $this->tim;

        $query = "
            WITH ctePenjualan AS (
                    SELECT
                            e.nama as Tim,
                            a.tgljual,
                            a.Nota,
                            a.Customernama,
                            SUM((b.jumlah + b.jumlahkoreksi) * c.hargajual) as TotalPenjualan,
                            a.pjkolektornota,
                            a.pjadminnota
                    FROM penjualanhds a
                    LEFT JOIN penjualandts b ON a.id = b.penjualanhdid
                    LEFT JOIN timsetuppakets c ON b.timsetuppaketid = c.id
                    LEFT JOIN timsetups d ON a.timsetupid = d.id
                    LEFT JOIN tims e ON d.timid = e.id
                    GROUP BY e.nama, a.tgljual, a.nota, a.customernama,a.pjkolektornota,a.pjadminnota
            ), ctePenjualanRet as (
                    SELECT
                            c.nama as Tim,
                            a.nota,
                            sum(a.qty*a.harga) as TotalRetur
                    FROM penjualanrets a
                    LEFT JOIN timsetups b ON a.timsetupid = b.id
                    LEFT JOIN tims c ON b.timid = c.id
                    GROUP BY c.nama, a.nota
            ), ctePenagihan AS (
                    SELECT
                            c.nama as Tim,
                            a.nota,
                            SUM(jumlahbayar + biayakomisi + biayaadmin) as TotalPenagihan
                    FROM penagihans a
                    LEFT JOIN timsetups b ON a.timsetupid = b.id
                    LEFT JOIN tims c ON b.timid = c.id
                    GROUP BY c.nama, a.nota
            )
            SELECT
                    a.*,
                    IFNULL(c.TotalRetur, 0) as TotalRetur,
                    IFNULL(b.TotalPenagihan, 0) as TotalPenagihan,
                    a.TotalPenjualan - IFNULL(c.TotalRetur, 0) - IFNULL(b.TotalPenagihan, 0) as Sisa
            FROM ctePenjualan a
            LEFT JOIN ctePenagihan b ON a.Tim = b.Tim AND a.nota = b.nota
            LEFT JOIN ctePenjualanRet c ON a.Tim = c.Tim AND a.nota = c.nota
            where 1=1
        ";

        if ($tim != 'Semua') {
            $query .= " and a.Tim = :tim";
        }

        if (!$this->chkFilterSisa) {
            $query .= " and a.TotalPenjualan - IFNULL(c.TotalRetur, 0) - IFNULL(b.TotalPenagihan, 0) > 0";
        }

        if (strlen($this->cari) >= 3) {
            $query .= " and (a.nota like '%" . $this->cari . "%' or a.customernama like '%" . $this->cari . "%' or a.pjkolektornota like '%" . $this->cari . "%' or a.pjadminnota like '%" . $this->cari . "%')";
        }

        $query .= " ORDER BY a.Tim, sisa desc";

        $salesData = DB::select($query, $tim != 'Semua' ? ['tim' => $tim] : []);

        // Mengelompokkan hasil berdasarkan 'Tim' dan mengurutkan berdasarkan 'Sisa' secara menurun dalam setiap kelompok
        $groupedData = collect($salesData)->groupBy('Tim')->map(function ($group) {
            return $group->sortByDesc('sisa');
        });

        return collect($groupedData);
    }

    public function render() {
        $salesData = $this->refresh();

        return view('livewire.main.penagihan.laporanpenagihannota', [
            'salesData' => $salesData,
        ])->layout('layouts.kai-layout', [
            'menu' => 'navmenu.main',
            'title' => $this->title,
        ]);
    }
}
