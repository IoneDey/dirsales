<?php

namespace App\Livewire\Main\Penjualan;

use DateTime;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Cetakinvoicedsg extends Component {
    public $title = "Cetak Invoice";

    public $model;
    public $id;
    public $nota;
    public $namacustomer;
    public $tgljual;
    public $totalqty;
    public $grandtotal;

    public $datas;
    public $qrCodeBase64;
    public $pathToImage;

    public function createBarcode2D() {
        $qrContent = implode("\n", [
            $this->nota,
            'https://tokodinasty.com/home-site/',
        ]);

        // ------
        // Membuat QR Code tanpa icon ditengah
        try {
            $qrCode = QrCode::size(50)->generate($qrContent);
            $this->qrCodeBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrCode);
        } catch (\Exception  $e) {
            dd($e->getMessage());
        }
        // ------

        // try {
        //     $this->pathToImage = public_path('img/aku.jpg');
        //     $qrCode = QrCode::format('png')
        //         ->size(150)
        //         ->merge(asset('img/aku.jpg'), 0.2, true)
        //         ->generate($qrContent);
        //     $this->qrCodeBase64 = 'data:image/png;base64,' . base64_encode($qrCode);
        // } catch (\Exception $e) {
        //     dd($e->getMessage());
        // }
    }

    public function mount($id, $model) {
        $this->model = $model;
        $this->id = $id;
        $query = DB::select(
            "
            SELECT
                a.nota, a.customernama as NamaCustomer, a.TglJual,
                b.jumlah+b.jumlahkoreksi as Qty,c.nama as NamaBarang,c.hargajual as Harga,
                (b.jumlah+b.jumlahkoreksi) * c.hargajual as Total
            FROM `penjualanhds` a
            left join penjualandts b on b.penjualanhdid=a.id
            left join timsetuppakets c on c.id=b.timsetuppaketid
            where a.id=$this->id
            "
        );
        $this->datas = $query;
        $this->nota = $this->datas[0]->nota;
        $this->namacustomer = $this->datas[0]->NamaCustomer;
        $this->tgljual = $this->datas[0]->TglJual;
        $date = new DateTime($this->tgljual);
        $formattedDate = $date->format('d M Y');
        $this->tgljual = $formattedDate;

        $queryTotal = DB::select(
            "
            SELECT
                sum(b.jumlah+b.jumlahkoreksi) as TotalQty,
                sum((b.jumlah+b.jumlahkoreksi) * c.hargajual) as GrandTotal
            FROM `penjualanhds` a
            left join penjualandts b on b.penjualanhdid=a.id
            left join timsetuppakets c on c.id=b.timsetuppaketid
            where a.id=$this->id
            group by a.id
            "
        );

        $this->totalqty = $queryTotal[0]->TotalQty;
        $this->grandtotal = $queryTotal[0]->GrandTotal;

        $this->createBarcode2D();
    }

    public function render() {
        return view('livewire.main.penjualan.cetakinvoicedsg', [
            'id' => $this->id,
        ])->layout('layouts.nomenu-layout', [
            'title' => $this->title,
        ]);
    }
}
