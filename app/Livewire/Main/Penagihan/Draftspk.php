<?php

namespace App\Livewire\Main\Penagihan;

use App\Exports\Draftspkexport;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class Draftspk extends Component {
    public $title = 'Draft SPK';

    public $mode = 'row';
    public $tglangsuran;

    public $notasString;

    public function mount() {
        $this->tglangsuran = date('Y-m-d');
    }

    public function exportExcel() {
        $dataExcel = DB::table('vwpenagihanresumenota')
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
            ->get();
        return Excel::download(new Draftspkexport($dataExcel), 'Draftspk.xlsx');
    }

    public function render() {
        // $data = DB::table('vwpenagihanresumenota')
        //     ->get();

        if ($this->mode == 'column') {
            $data = DB::table('vwpenagihanresumenota')
                ->where(function ($query) {
                    $query->where('angsuran_date_1', $this->tglangsuran)
                        ->orWhere('angsuran_date_2', $this->tglangsuran)
                        ->orWhere('angsuran_date_3', $this->tglangsuran)
                        ->orWhere('angsuran_date_4', $this->tglangsuran)
                        ->orWhere('angsuran_date_5', $this->tglangsuran)
                        ->orWhere('angsuran_date_6', $this->tglangsuran)
                        ->orWhere('angsuran_date_7', $this->tglangsuran)
                        ->orWhere('angsuran_date_8', $this->tglangsuran);
                })
                ->get();
        }

        // if ($this->mode == 'row') {
        //     $Query = DB::table('vwpenagihanresumenota')
        //         ->select(
        //             'tim',
        //             'nota',
        //             'customernama',
        //             'customeralamat',
        //             'pjkolektornota',
        //             'pjadminnota',
        //             'tgljual',
        //             'angsuranhari',
        //             'angsuranperiode',
        //             'omset',
        //             'perangsuran',
        //             DB::raw(1 . ' as Ke'),
        //             'angsuran_date_1 AS angsuran_date',
        //             'Penagihan_1_date AS penagihan_date',
        //             'h1 AS h',
        //             'penagihan_1 AS penagihan',
        //             'retur_1 AS retur',
        //             'A1 AS A'
        //         )
        //         ->where('angsuran_date_1', $this->tglangsuran)
        //         ->unionAll(
        //             DB::table('vwpenagihanresumenota')
        //                 ->select(
        //                     'tim',
        //                     'nota',
        //                     'customernama',
        //                     'customeralamat',
        //                     'pjkolektornota',
        //                     'pjadminnota',
        //                     'tgljual',
        //                     'angsuranhari',
        //                     'angsuranperiode',
        //                     'omset',
        //                     'perangsuran',
        //                     DB::raw(2 . ' as Ke'),
        //                     'angsuran_date_2 AS angsuran_date',
        //                     'Penagihan_2_date AS penagihan_date',
        //                     'h2 AS h',
        //                     'penagihan_2 AS penagihan',
        //                     'retur_2 AS retur',
        //                     'A2 AS A'
        //                 )
        //                 ->where('angsuran_date_2', $this->tglangsuran)
        //         )
        //         ->unionAll(
        //             DB::table('vwpenagihanresumenota')
        //                 ->select(
        //                     'tim',
        //                     'nota',
        //                     'customernama',
        //                     'customeralamat',
        //                     'pjkolektornota',
        //                     'pjadminnota',
        //                     'tgljual',
        //                     'angsuranhari',
        //                     'angsuranperiode',
        //                     'omset',
        //                     'perangsuran',
        //                     DB::raw(3 . ' as Ke'),
        //                     'angsuran_date_3 AS angsuran_date',
        //                     'Penagihan_3_date AS penagihan_date',
        //                     'h3 AS h',
        //                     'penagihan_3 AS penagihan',
        //                     'retur_3 AS retur',
        //                     'A3 AS A'
        //                 )
        //                 ->where('angsuran_date_3', $this->tglangsuran)
        //         )
        //         ->unionAll(
        //             DB::table('vwpenagihanresumenota')
        //                 ->select(
        //                     'tim',
        //                     'nota',
        //                     'customernama',
        //                     'customeralamat',
        //                     'pjkolektornota',
        //                     'pjadminnota',
        //                     'tgljual',
        //                     'angsuranhari',
        //                     'angsuranperiode',
        //                     'omset',
        //                     'perangsuran',
        //                     DB::raw(4 . ' as Ke'),
        //                     'angsuran_date_4 AS angsuran_date',
        //                     'Penagihan_4_date AS penagihan_date',
        //                     'h4 AS h',
        //                     'penagihan_4 AS penagihan',
        //                     'retur_4 AS retur',
        //                     'A4 AS A'
        //                 )
        //                 ->where('angsuran_date_4', $this->tglangsuran)
        //         )
        //         ->unionAll(
        //             DB::table('vwpenagihanresumenota')
        //                 ->select(
        //                     'tim',
        //                     'nota',
        //                     'customernama',
        //                     'customeralamat',
        //                     'pjkolektornota',
        //                     'pjadminnota',
        //                     'tgljual',
        //                     'angsuranhari',
        //                     'angsuranperiode',
        //                     'omset',
        //                     'perangsuran',
        //                     DB::raw(5 . ' as Ke'),
        //                     'angsuran_date_5 AS angsuran_date',
        //                     'Penagihan_5_date AS penagihan_date',
        //                     'h5 AS h',
        //                     'penagihan_5 AS penagihan',
        //                     'retur_5 AS retur',
        //                     'A5 AS A'
        //                 )
        //                 ->where('angsuran_date_5', $this->tglangsuran)
        //         )
        //         ->unionAll(
        //             DB::table('vwpenagihanresumenota')
        //                 ->select(
        //                     'tim',
        //                     'nota',
        //                     'customernama',
        //                     'customeralamat',
        //                     'pjkolektornota',
        //                     'pjadminnota',
        //                     'tgljual',
        //                     'angsuranhari',
        //                     'angsuranperiode',
        //                     'omset',
        //                     'perangsuran',
        //                     DB::raw(6 . ' as Ke'),
        //                     'angsuran_date_6 AS angsuran_date',
        //                     'Penagihan_6_date AS penagihan_date',
        //                     'h6 AS h',
        //                     'penagihan_6 AS penagihan',
        //                     'retur_6 AS retur',
        //                     'A6 AS A'
        //                 )
        //                 ->where('angsuran_date_6', $this->tglangsuran)
        //         )
        //         ->unionAll(
        //             DB::table('vwpenagihanresumenota')
        //                 ->select(
        //                     'tim',
        //                     'nota',
        //                     'customernama',
        //                     'customeralamat',
        //                     'pjkolektornota',
        //                     'pjadminnota',
        //                     'tgljual',
        //                     'angsuranhari',
        //                     'angsuranperiode',
        //                     'omset',
        //                     'perangsuran',
        //                     DB::raw(7 . ' as Ke'),
        //                     'angsuran_date_7 AS angsuran_date',
        //                     'Penagihan_7_date AS penagihan_date',
        //                     'h7 AS h',
        //                     'penagihan_7 AS penagihan',
        //                     'retur_7 AS retur',
        //                     'A7 AS A'
        //                 )
        //                 ->where('angsuran_date_7', $this->tglangsuran)
        //         )
        //         ->unionAll(
        //             DB::table('vwpenagihanresumenota')
        //                 ->select(
        //                     'tim',
        //                     'nota',
        //                     'customernama',
        //                     'customeralamat',
        //                     'pjkolektornota',
        //                     'pjadminnota',
        //                     'tgljual',
        //                     'angsuranhari',
        //                     'angsuranperiode',
        //                     'omset',
        //                     'perangsuran',
        //                     DB::raw(8 . ' as Ke'),
        //                     'angsuran_date_8 AS angsuran_date',
        //                     'Penagihan_8_date AS penagihan_date',
        //                     'h8 AS h',
        //                     'penagihan_8 AS penagihan',
        //                     'retur_8 AS retur',
        //                     'A8 AS A'
        //                 )
        //                 ->where('angsuran_date_8', $this->tglangsuran)
        //         );

        //     if ($this->notasString) {
        //         $notasArray = explode(',', $this->notasString);
        //         $Query->whereIn('nota', $notasArray);
        //         dump($notasArray);
        //     }

        //     $data = $Query->get();
        // }

        if ($this->mode == 'row') {
            $notasArray = $this->notasString ? explode(',', $this->notasString) : [];

            $subQueries = [];

            for ($i = 1; $i <= 8; $i++) {
                $subQuery = DB::table('vwpenagihanresumenota')
                    ->select(
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
                        DB::raw("$i as Ke"),
                        DB::raw("angsuran_date_$i AS angsuran_date"),
                        DB::raw("Penagihan_{$i}_date AS penagihan_date"),
                        DB::raw("h$i AS h"),
                        DB::raw("penagihan_$i AS penagihan"),
                        DB::raw("retur_$i AS retur"),
                        DB::raw("A$i AS A")
                    )
                    ->where(DB::raw("angsuran_date_$i"), $this->tglangsuran);

                if (!empty($notasArray)) {
                    $subQuery->whereIn('nota', $notasArray);
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
        ])->layout('layouts.app-layout', [
            'menu' => 'navmenu.main',
            'title' => $this->title,
        ]);
    }
}
