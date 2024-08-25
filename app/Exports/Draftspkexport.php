<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Draftspkexport implements FromCollection, WithHeadings {
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $data;
    protected $mode;

    public function __construct(Collection $data, $mode) {
        $this->data = $data;
        $this->mode = $mode;
    }

    public function headings(): array {
        if ($this->mode == 'column') {
            return [
                'Tim',
                'Nota',
                'Customer Nama',
                'Customer Alamat',
                'PJ Kurir Nota',
                'PJ Admin Nota',
                'Tanggal Jual',
                'Angsuran Hari',
                'Angsuran Periode',
                'Omset',
                'Per Angsuran',
                'Penagihan 0',
                'Angsuran Date 1',
                'Penagihan 1 Date',
                'H1',
                'Penagihan 1',
                'Retur 1',
                'A1',
                'Angsuran Date 2',
                'Penagihan 2 Date',
                'H2',
                'Penagihan 2',
                'Retur 2',
                'A2',
                'Angsuran Date 3',
                'Penagihan 3 Date',
                'H3',
                'Penagihan 3',
                'Retur 3',
                'A3',
                'Angsuran Date 4',
                'Penagihan 4 Date',
                'H4',
                'Penagihan 4',
                'Retur 4',
                'A4',
                'Angsuran Date 5',
                'Penagihan 5 Date',
                'H5',
                'Penagihan 5',
                'Retur 5',
                'A5',
                'Angsuran Date 6',
                'Penagihan 6 Date',
                'H6',
                'Penagihan 6',
                'Retur 6',
                'A6',
                'Angsuran Date 7',
                'H7',
                'Penagihan 7',
                'Retur 7',
                'A7',
                'Angsuran Date 8',
                'Penagihan 8 Date',
                'H8',
                'Penagihan 8',
                'Retur 8',
                'A8',
                'Penagihan X',
                'Total Tagihan',
                'Total Retur',
                'Total'
            ];
        }
        if ($this->mode == 'row') {
            return [
                'Tim',
                'Nota',
                'Nama Customer',
                'Alamat Customer',
                'Kurir',
                'PJ Admin Nota',
                'Tgl Jual',
                'Angsuran Hari',
                'Angsuran Periode',
                'Penjualan',
                'Perangsuran',
                'Ke',
                'Angsuran Date',
                'Penagihan Date',
                'H',
                'Penagihan',
                'Retur',
                'Total A',
                'Kategori',
                'Catatan',
                'Rating'
            ];
        }
    }

    public function collection() {
        //
        return $this->data;
    }
}
