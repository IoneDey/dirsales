<?php

namespace App\Livewire\Main\Penagihan;

use App\Exports\Draftspkexport;
use App\Models\Timsetup;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class Draftspk extends Component {
    public $title = 'Draft SPK';

    public $mode = 'row';
    public $tglangsuran;
    public $tglangsuranakhir;

    public $notasString;

    public $dbTimsetups;
    public $timsetupid;

    public function mount() {
        $this->tglangsuran = date('Y-m-d');
        $this->tglangsuranakhir = date('Y-m-d');
        $this->dbTimsetups = Timsetup::get();
    }

    public function exportExcel() {
        $notasArray = $this->notasString ? explode(',', $this->notasString) : [];
        $subQueries = [];

        if ($this->mode == 'column') {
            $Query = DB::table('vwpenagihanresumenota')
                ->select([
                    'tim',
                    'nota',
                    'customernama',
                    'customeralamat',
                    'pjkolektornota',
                    'pjadminnota',
                    'tgljual',
                    'angsuranhari',
                    'angsuranperiode',
                    'omset',
                    'perangsuran',
                    'penagihan_0',
                    'angsuran_date_1',
                    'Penagihan_1_date',
                    'h1',
                    'penagihan_1',
                    'retur_1',
                    'A1',
                    'angsuran_date_2',
                    'Penagihan_2_date',
                    'h2',
                    'penagihan_2',
                    'retur_2',
                    'A2',
                    'angsuran_date_3',
                    'Penagihan_3_date',
                    'h3',
                    'penagihan_3',
                    'retur_3',
                    'A3',
                    'angsuran_date_4',
                    'Penagihan_4_date',
                    'h4',
                    'penagihan_4',
                    'retur_4',
                    'A4',
                    'angsuran_date_5',
                    'Penagihan_5_date',
                    'h5',
                    'penagihan_5',
                    'retur_5',
                    'A5',
                    'angsuran_date_6',
                    'Penagihan_6_date',
                    'h6',
                    'penagihan_6',
                    'retur_6',
                    'A6',
                    'angsuran_date_7',
                    'h7',
                    'penagihan_7',
                    'retur_7',
                    'A7',
                    'angsuran_date_8',
                    'Penagihan_8_date',
                    'h8',
                    'penagihan_8',
                    'retur_8',
                    'A8',
                    'penagihan_x',
                    'TotTagihan',
                    'TotRetur',
                    'Total'
                ])
                ->where(function ($query) {
                    $query->whereBetween('angsuran_date_1', [$this->tglangsuran, $this->tglangsuranakhir])
                        ->orwhereBetween('angsuran_date_2', [$this->tglangsuran, $this->tglangsuranakhir])
                        ->orwhereBetween('angsuran_date_3', [$this->tglangsuran, $this->tglangsuranakhir])
                        ->orwhereBetween('angsuran_date_4', [$this->tglangsuran, $this->tglangsuranakhir])
                        ->orwhereBetween('angsuran_date_5', [$this->tglangsuran, $this->tglangsuranakhir])
                        ->orwhereBetween('angsuran_date_6', [$this->tglangsuran, $this->tglangsuranakhir])
                        ->orwhereBetween('angsuran_date_7', [$this->tglangsuran, $this->tglangsuranakhir])
                        ->orwhereBetween('angsuran_date_8', [$this->tglangsuran, $this->tglangsuranakhir]);
                });

            if (!empty($notasArray)) {
                $Query->whereIn('nota', $notasArray);
            }

            if ($this->timsetupid) {
                $Query->where('timsetupid', $this->timsetupid);
            }

            $dataExcel = $Query->get();
        }

        if ($this->mode == 'row') {
            $notasArray = $this->notasString ? explode(',', $this->notasString) : [];

            $subQueries = [];

            for ($i = 1; $i <= 8; $i++) {
                $subQuery = DB::table('vwpenagihanresumenota as a')
                    ->leftJoin('penagihans as b', function ($join) use ($i) {
                        $join->on('a.timsetupid', '=', 'b.timsetupid')
                            ->on('a.nota', '=', 'b.nota')
                            ->on(DB::raw("a.Penagihan_{$i}_date"), '=', 'b.tglpenagihan');
                    })
                    ->select(
                        'a.tim',
                        'a.nota',
                        'a.customernama',
                        'a.customeralamat',
                        'a.pjkolektornota',
                        'a.pjadminnota',
                        'a.tgljual',
                        'a.angsuranhari',
                        'a.angsuranperiode',
                        'a.omset',
                        'a.perangsuran',
                        DB::raw("$i as Ke"),
                        DB::raw("a.angsuran_date_$i AS angsuran_date"),
                        DB::raw("a.Penagihan_{$i}_date AS penagihan_date"),
                        DB::raw("a.h$i AS h"),
                        DB::raw("a.penagihan_$i AS penagihan"),
                        DB::raw("a.retur_$i AS retur"),
                        DB::raw("a.A$i AS A"),
                        'b.namapenagih',
                        'b.kategori',
                        'b.rating',
                        'b.catatan'
                    )
                    ->whereBetween(DB::raw("a.angsuran_date_$i"), [$this->tglangsuran, $this->tglangsuranakhir]);

                if (!empty($notasArray)) {
                    $subQuery->whereIn('a.nota', $notasArray);
                }

                if ($this->timsetupid) {
                    $subQuery->where('a.timsetupid', $this->timsetupid);
                }

                $subQueries[] = $subQuery;
            }

            $Query = array_shift($subQueries);
            foreach ($subQueries as $subQuery) {
                $Query->unionAll($subQuery);
            }

            $dataExcel = $Query->get();
        }


        return Excel::download(new Draftspkexport($dataExcel, $this->mode), 'Draftspk.xlsx');
    }

    public function render() {
        $notasArray = $this->notasString ? explode(',', $this->notasString) : [];
        $subQueries = [];

        if ($this->mode == 'column') {
            $Query = DB::table('vwpenagihanresumenota')
                ->where(function ($query) {
                    $query->whereBetween('angsuran_date_1', [$this->tglangsuran, $this->tglangsuranakhir])
                        ->orwhereBetween('angsuran_date_2', [$this->tglangsuran, $this->tglangsuranakhir])
                        ->orwhereBetween('angsuran_date_3', [$this->tglangsuran, $this->tglangsuranakhir])
                        ->orwhereBetween('angsuran_date_4', [$this->tglangsuran, $this->tglangsuranakhir])
                        ->orwhereBetween('angsuran_date_5', [$this->tglangsuran, $this->tglangsuranakhir])
                        ->orwhereBetween('angsuran_date_6', [$this->tglangsuran, $this->tglangsuranakhir])
                        ->orwhereBetween('angsuran_date_7', [$this->tglangsuran, $this->tglangsuranakhir])
                        ->orwhereBetween('angsuran_date_8', [$this->tglangsuran, $this->tglangsuranakhir]);
                });

            if (!empty($notasArray)) {
                $Query->whereIn('nota', $notasArray);
            }
            if ($this->timsetupid) {
                $Query->where('timsetupid', $this->timsetupid);
            }
            $data = $Query->get();
        }

        if ($this->mode == 'row') {
            $notasArray = $this->notasString ? explode(',', $this->notasString) : [];

            $subQueries = [];

            for ($i = 1; $i <= 8; $i++) {
                $subQuery = DB::table('vwpenagihanresumenota as a')
                    ->leftJoin('penagihans as b', function ($join) use ($i) {
                        $join->on('a.timsetupid', '=', 'b.timsetupid')
                            ->on('a.nota', '=', 'b.nota')
                            ->on(DB::raw("a.Penagihan_{$i}_date"), '=', 'b.tglpenagihan');
                    })
                    ->select(
                        'a.tim',
                        'a.nota',
                        'a.customernama',
                        'a.customeralamat',
                        'a.pjkolektornota',
                        'a.pjadminnota',
                        'a.tgljual',
                        'a.angsuranhari',
                        'a.angsuranperiode',
                        'a.omset',
                        'a.perangsuran',
                        DB::raw("$i as Ke"),
                        DB::raw("a.angsuran_date_$i AS angsuran_date"),
                        DB::raw("a.Penagihan_{$i}_date AS penagihan_date"),
                        DB::raw("a.h$i AS h"),
                        DB::raw("a.penagihan_$i AS penagihan"),
                        DB::raw("a.retur_$i AS retur"),
                        DB::raw("a.A$i AS A"),
                        'b.namapenagih',
                        'b.kategori',
                        'b.rating',
                        'b.catatan'
                    )
                    ->whereBetween(DB::raw("a.angsuran_date_$i"), [$this->tglangsuran, $this->tglangsuranakhir]);

                if (!empty($notasArray)) {
                    $subQuery->whereIn('a.nota', $notasArray);
                }
                if ($this->timsetupid) {
                    $subQuery->where('a.timsetupid', $this->timsetupid);
                }
                $subQueries[] = $subQuery;
            }

            // Gabungkan semua sub-query menggunakan unionAll
            $Query = array_shift($subQueries);
            foreach ($subQueries as $subQuery) {
                $Query->unionAll($subQuery);
            }

            // Eksekusi query
            $data = $Query->get();

            // Debugging: dump the resulting query and notasArray
            // dump($Query->toSql());
            // dump($notasArray);
        }

        return view('livewire.main.penagihan.draftspk', [
            'data' => $data,
        ])->layout('layouts.kai-layout', [
            'menu' => 'navmenu.main',
            'title' => $this->title,
        ]);
    }
}
