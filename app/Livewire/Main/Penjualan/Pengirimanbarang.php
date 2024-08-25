<?php

namespace App\Livewire\Main\Penjualan;

use App\Models\Penjualandt;
use App\Models\Penjualanhd;
use App\Models\Timsetuppaket;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Pengirimanbarang extends Component {
    public $title = 'Pengiriman Barang';

    // pencarian by nota
    public $isNota = false;
    public $results;
    public $dbDetailJual;

    public $nota = '';
    public $tgljual;
    public $timsetupid;
    public $tim;
    public $pt;
    public $kota;
    public $customernama;
    public $customeralamat;
    public $totaljual = 0;
    public $totaljualRp;

    public $dbKartuPiutang;

    // db
    public $dbDrivers;

    // tabel pengiriman
    public $tglpengiriman;
    public $namadriver;
    public $foto;

    // lain2x
    public $isUpdatePaket;

    public function mount() {
        $this->dbDrivers = DB::select("SELECT nama FROM `karyawans` where void=0 and flagdriver=1");
    }

    public function getKartuPiutangNota($nota) {
        $escNota = $this->esc_chars($nota);
        $Sql = "
            SELECT
                X.*,
                @saldo := @saldo + (IFNULL(x.debet, 0) - x.kredit) AS saldo
            FROM
            (
            SELECT
                a.tgljual, a.timsetupid, g.nama AS tim,a.nota,SUM((b.jumlah+b.jumlahkoreksi)*c.hargajual) AS debet, 0 AS kredit
            FROM penjualanhds a
            LEFT JOIN penjualandts b ON b.penjualanhdid=a.id
            LEFT JOIN timsetups f ON f.id=a.timsetupid
            LEFT JOIN tims g ON g.id=f.timid
            LEFT JOIN timsetuppakets c ON c.id=b.timsetuppaketid
            WHERE a.nota = '$escNota' and a.timsetupid='$this->timsetupid'
            GROUP BY a.tgljual, a.timsetupid, g.nama,a.nota
            UNION ALL
            SELECT
                tglretur, timsetupid, '' as tim,noretur,0 as debet,sum(qty*harga) as kredit
            FROM penjualanrets
            where nota='$escNota' and timsetupid='$this->timsetupid'
            group by tglretur,timsetupid,noretur
            UNION ALL
            SELECT
                tglpenagihan, a.timsetupid, g.nama AS Tim,CONCAT(nota,'-', DATE_FORMAT(tglpenagihan, '%Y%m%d')) AS nota,0 AS debet, (jumlahbayar+biayakomisi+biayaadmin) AS kredit
            FROM penagihans a
            LEFT JOIN timsetups f ON f.id=a.timsetupid
            LEFT JOIN tims g ON g.id=f.timid
            WHERE a.nota = '$escNota' and a.timsetupid='$this->timsetupid'
            ) X
            CROSS
            JOIN (
            SELECT @saldo := 0) AS vars
            ORDER BY X.tgljual
        ";
        $this->dbKartuPiutang = DB::select($Sql);
    }

    public function resetErrors() {
        $this->resetErrorBag();
    }

    public function terbilang($number) {
        $number = abs($number);
        $words = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
        $result = "";

        if ($number < 12) {
            $result = " " . $words[$number];
        } elseif ($number < 20) {
            $result = $this->terbilang($number - 10) . " Belas ";
        } elseif ($number < 100) {
            $result = $this->terbilang(intval($number / 10)) . " Puluh " . $this->terbilang($number % 10);
        } elseif ($number < 200) {
            $result = " Seratus " . $this->terbilang($number - 100);
        } elseif ($number < 1000) {
            $result = $this->terbilang(intval($number / 100)) . " Ratus " . $this->terbilang($number % 100);
        } elseif ($number < 2000) {
            $result = " Seribu " . $this->terbilang($number - 1000);
        } elseif ($number < 1000000) {
            $result = $this->terbilang(intval($number / 1000)) . " Ribu " . $this->terbilang($number % 1000);
        } elseif ($number < 1000000000) {
            $result = $this->terbilang(intval($number / 1000000)) . " Juta " . $this->terbilang($number % 1000000);
        } elseif ($number < 1000000000000) {
            $result = $this->terbilang(intval($number / 1000000000)) . " Miliar " . $this->terbilang($number % 1000000000);
        } else {
            $result = "Angka terlalu besar";
        }

        return trim($result);
    }

    public function getDetailBarang($nota) {
        $escnota = $this->esc_chars($nota);
        $partimsetupid = $this->timsetupid ?? -1;

        $this->dbDetailJual = DB::select(
            "
            SELECT
                b.nota,c.nama as namapaket,e.nama as namabarang,
                a.jumlah,a.jumlahkoreksi, a.jumlah+a.jumlahkoreksi as jmljual,
                c.hargajual,
                COALESCE(f.qtyret,0) as qtyret,
                COALESCE(f.totalret,0) as totalret,
                (a.jumlah+a.jumlahkoreksi) - COALESCE(f.qtyret,0) as maxretur,
                d.barangid,
                d.timsetuppaketid
                FROM `penjualandts` a
                left join penjualanhds b on a.penjualanhdid=b.id
                left join timsetuppakets c on a.timsetuppaketid=c.id
                left join timsetupbarangs d on c.id=d.timsetuppaketid
                left join barangs e on d.barangid=e.id
                left join (
                    select
                        nota,timsetuppaketid,barangid,sum(qty) as qtyret,sum(qty*harga) totalret
                    from penjualanrets
                    group by nota,timsetuppaketid,barangid
                ) f on b.nota=f.nota and d.timsetuppaketid=f.timsetuppaketid and d.barangid=f.barangid
            where b.nota='$escnota' and b.timsetupid='$partimsetupid'
            "
        );
    }

    // pilih nota
    function esc_chars($input) {
        $special_chars = [
            '\\' => '\\\\',
            '\'' => '\\\'',
            '"' => '\\"',
            '%' => '\\%',
            '_' => '\\_',
            ';' => '\\;',
            '--' => '\\--',
            '#' => '\\#'
        ];
        foreach ($special_chars as $char => $escaped_char) {
            $input = str_replace($char, $escaped_char, $input);
        }
        return $input;
    }

    public function updatednota() {
        $this->isNota = false;
        $this->clearDataNota();
        if (strlen($this->nota) >= 5) {
            $this->results = Penjualanhd::where('nota', 'like', '%' . $this->nota . '%')
                ->orWhere('customernama', 'like', '%' . $this->nota . '%')
                ->get();
        } else {
            $this->results = null;
        }
    }

    public function clearDataNota() {
        $this->resetErrors();
        $this->tgljual = "";
        $this->timsetupid = "";
        $this->tim = '';
        $this->pt = '';
        $this->kota = '';
        $this->customernama = '';
        $this->customeralamat = '';
        $this->dbKartuPiutang = null;
        $this->dbDetailJual = null;
    }

    public function selectNota($timsetupid, $nota) {
        $this->nota = $nota;
        $this->timsetupid = $timsetupid;
        $this->isNota = true;

        $data = Penjualanhd::select(
            'penjualanhds.timsetupid',
            'penjualanhds.nota',
            'penjualanhds.tgljual',
            'penjualanhds.angsuranhari',
            'penjualanhds.angsuranperiode',
            'tims.nama as tim',
            'pts.nama as pt',
            'kotas.nama as kota',
            'penjualanhds.customernama',
            'penjualanhds.customeralamat',
            'penjualanhds.status',
            DB::raw('SUM((penjualandts.jumlah + penjualandts.jumlahkoreksi) * timsetuppakets.hargajual) as totaljual')
        )
            ->leftJoin('timsetups', 'timsetups.id', '=', 'penjualanhds.timsetupid')
            ->leftJoin('tims', 'tims.id', '=', 'timsetups.timid')
            ->leftJoin('pts', 'pts.id', '=', 'tims.ptid')
            ->leftJoin('kotas', 'kotas.id', '=', 'timsetups.kotaid')
            ->leftJoin('penjualandts', 'penjualanhds.id', '=', 'penjualandts.penjualanhdid')
            ->leftJoin('timsetuppakets', 'timsetuppakets.id', '=', 'penjualandts.timsetuppaketid')
            ->where('penjualanhds.nota', $this->nota)
            ->where('penjualanhds.timsetupid', $this->timsetupid)
            ->groupBy(
                'penjualanhds.timsetupid',
                'penjualanhds.nota',
                'penjualanhds.tgljual',
                'penjualanhds.angsuranhari',
                'penjualanhds.angsuranperiode',
                'tims.nama',
                'pts.nama',
                'kotas.nama',
                'penjualanhds.customernama',
                'penjualanhds.customeralamat',
                'penjualanhds.status'
            )
            ->first();
        if ($data) {
            $this->tgljual = $data->tgljual;
            $this->timsetupid = $data->timsetupid;
            $this->tim = $data->tim;
            $this->pt = $data->pt;
            $this->kota = $data->kota;
            $this->customernama = $data->customernama;
            $this->customeralamat = $data->customeralamat;
            $this->totaljual = $data->totaljual;
            $this->totaljualRp = $this->terbilang($data->totaljual);
        }

        $this->getDetailBarang($nota);


        //ambil nilai jual
        // $datajmljual = DB::select('
        //                 SELECT
        //                     SUM((b.jumlah+b.jumlahkoreksi)*c.hargajual) AS totaljual
        //                 FROM penjualanhds a
        //                 LEFT JOIN penjualandts b ON a.id=b.penjualanhdid
        //                 LEFT JOIN timsetuppakets c ON c.id=b.timsetuppaketid
        //                 WHERE a.nota=?
        //         ', [$nota]);
        // $this->jmljual = $datajmljual[0]->totaljual;
    }
    // end pilih nota

    public function render() {
        $this->getKartuPiutangNota($this->nota);
        $dbTimssetuppakets = Timsetuppaket::where('timsetupid', $this->timsetupid)->get();
        $dbPengirimans = Penjualandt::where('penjualanhdid', 0)->get();

        return view('livewire.main.penjualan.pengirimanbarang', [
            'dbTimssetuppakets' => $dbTimssetuppakets,
            'dbPengirimans' => $dbPengirimans,
        ])->layout('layouts.app-layout', [
            'menu' => 'navmenu.main',
            'title' => $this->title,
        ]);
    }
}
