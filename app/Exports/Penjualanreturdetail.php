<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Penjualanreturdetail implements FromCollection, WithHeadings {
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $data;

    public function __construct(Collection $data) {
        $this->data = $data;
    }

    public function headings(): array {
        return [
            'Tim',
            'Timestamp',
            'Tgl Retur',
            'Nota',
            'Nama Customer',
            'Barang',
            'Qty',
            '@Harga',
            'Total Retur',
            'Foto'
        ];
    }

    public function collection() {
        // $db = DB::select('select * from users');
        // return collect($db);
        return $this->data;
    }
}
