<?php

namespace App\Livewire\Panel\Utility;

use App\Http\Controllers\SendWaMessage;
use App\Models\Timsetup;
use App\customClass\myNumber;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Sendwatagihan extends Component {
    public $title = 'Send WA';

    public $mode = 'row';

    public $timsetupid;
    public $tglangsuran;
    public $notasString;
    public $dbTimsetups;

    public $nohptest;

    public $waNumberKey = "gRGKgrAvjMBALPaP";
    public $data;

    // per nomor
    public $tim;
    public $nota;
    public $messagewa1;
    public $nohptujuan1;
    public $cattambahan = [];

    //--cari + paginate
    public $cari = '';
    public function updatedcari() {
    }
    //--end cari + paginate

    public function sendWA1Confirm($tim, $nota) {
        $this->messagewa1 = null;
        $this->tim = $tim;
        $this->nota = $nota;

        switch ($this->waNumberKey) {
            case "gRGKgrAvjMBALPaP":
                $surveyor = "Gandhi";
                break;
            case "XquzwRWepBwQ1DoK":
                $surveyor = "Riski";
                break;
            case "If320nKuXNaWj3Iq":
                $surveyor = "Gusti";
                break;
            default:
        }

        foreach ($this->data as $data) {

            if ($data->tim == $tim && $data->nota == $nota) {

                $tglangsuran = Carbon::parse($data->angsuran_date)->format('d-m-Y');;
                $angsuran = number_format($data->perangsuran, 0, '', '.');
                $this->nohptujuan1 = $data->customernotelp;
                $catatan = (string) $this->cattambahan[$data->tim . $data->nota];

                $message = <<<EOD
                Assalamualaikum, Bu $data->customernama,

                Perkenalkan saya Admin surveyor dari $surveyor, kami ingin mengingatkan bahwa pembayaran untuk pesanan dengan nomor $data->nota. Dengan rincian sebagai berikut :

                Jumlah Pembelian : $data->jumlah pcs
                Angsuran Ke : $data->Ke
                Tanggal Angsuran : $tglangsuran
                Jumlah Tagihan : Rp. $angsuran

                Demikian informasi dari kami, *kami mohon untuk menyiapkan pembayaran sejumlah rincian tertera* yang selanjutnya petugas kami akan mengunjungi bu $data->customernama pada tanggal $tglangsuran
                Silahkan tanggapi pesan ini dengan kata *"Siap"* jika ibu telah memahami pesan ini dan apabila terdapat kesalahan informasi silahkan balas dengan kata *"Perbaikan"* 😊

                _"Setiap pembayaran tepat waktu adalah wujud dari tanggung jawab. Kita tidak hanya menjaga kepercayaan orang lain, tetapi juga memberikan kedamaian dan kelegaan untuk diri sendiri."_

                $catatan
                EOD;

                $this->messagewa1 = $message;
            }
        }

        if (($this->nohptest ?? '') != '') {
            $this->nohptujuan1 = $this->nohptest;
        }
    }

    public function sendWA1() {
        if ($this->messagewa1) {
            $whatsAppController = new SendWaMessage();
            $response = $whatsAppController->sendMessage($this->waNumberKey, $this->nohptujuan1, $this->messagewa1);

            $dataresponse = json_decode($response, true);
            foreach ($this->data as $data) {
                if ($data->tim == $this->tim && $data->nota == $this->nota) {

                    if (is_array($dataresponse) && isset($dataresponse['ack'])) {
                        $data->status = $dataresponse['ack'];
                    } else {
                        $data->status = $response;
                    }
                }
            }
        }
    }

    public function sendWA() {
        switch ($this->waNumberKey) {
            case "gRGKgrAvjMBALPaP":
                $surveyor = "Gandhi";
                break;
            case "XquzwRWepBwQ1DoK":
                $surveyor = "Riski";
                break;
            case "If320nKuXNaWj3Iq":
                $surveyor = "Gusti";
                break;
            default:
        }

        foreach ($this->data as $data) {

            $tglangsuran = Carbon::parse($data->angsuran_date)->format('d-m-Y');;
            $angsuran = number_format($data->perangsuran, 0, '', '.');
            $nohptujuan = $data->customernotelp;

            $catatan = (string) $this->cattambahan[$data->tim . $data->nota];

            $message = <<<EOD
            Assalamualaikum, Bu $data->customernama,

            Perkenalkan saya Admin surveyor dari $surveyor, kami ingin mengingatkan bahwa pembayaran untuk pesanan dengan nomor $data->nota. Dengan rincian sebagai berikut :

            Jumlah Pembelian : $data->jumlah pcs
            Angsuran Ke : $data->Ke
            Tanggal Angsuran : $tglangsuran
            Jumlah Tagihan : Rp. $angsuran

            Demikian informasi dari kami, *kami mohon untuk menyiapkan pembayaran sejumlah rincian tertera* yang selanjutnya petugas kami akan mengunjungi bu $data->customernama pada tanggal $tglangsuran
            Silahkan tanggapi pesan ini dengan kata *"Siap"* jika ibu telah memahami pesan ini dan apabila terdapat kesalahan informasi silahkan balas dengan kata *"Perbaikan"* 😊

            _"Setiap pembayaran tepat waktu adalah wujud dari tanggung jawab. Kita tidak hanya menjaga kepercayaan orang lain, tetapi juga memberikan kedamaian dan kelegaan untuk diri sendiri."_

            $catatan
            EOD;

            if (($this->nohptest ?? '') != '') {
                $nohptujuan = $this->nohptest;
            }

            $whatsAppController = new SendWaMessage();
            $response = $whatsAppController->sendMessage($this->waNumberKey, $nohptujuan, $message);


            $dataresponse = json_decode($response, true);
            if (is_array($dataresponse) && isset($dataresponse['ack'])) {
                $data->status = $dataresponse['ack'];
            } else {
                $data->status = $response;
            }

            // $response = $whatsAppController->sendMessageWithImage('6287701666286', $imageUrl, 'Test Kirim Gambar', 'Logo Dinasty');
            // $this->js('alert("Respose Kirim WA: ' . $response . '")');
        }
    }

    public function mount() {
        $this->tglangsuran = Date('Y-m-d');
        $this->dbTimsetups = Timsetup::get();
        $this->refresh();
    }

    public function updated($property) {
        if ($property === 'tglangsuran' || $property === 'timsetupid' || $property === 'notasString' || $property === 'cari') {
            $this->refresh();
        }
    }

    public function refresh() {
        if ($this->mode == 'row') {
            $notasArray = $this->notasString ? explode(',', $this->notasString) : [];

            $subQueries = [];

            for ($i = 1; $i <= 8; $i++) {
                $subQuery = DB::table('vwpenagihanresumenota as a')
                    ->leftJoin('vwpenjualanpaketnominal as b', function ($join) use ($i) {
                        $join->on('a.timsetupid', '=', 'b.timsetupid')
                            ->on('a.nota', '=', 'b.nota');
                    })
                    ->select(
                        'b.namasurveyors',
                        'a.tim',
                        'a.nota',
                        'a.customernama',
                        'a.customeralamat',
                        'b.customernotelp',
                        'a.tgljual',
                        'a.omset',
                        'a.perangsuran',
                        'b.jumlah',
                        DB::raw("$i as Ke"),
                        DB::raw("a.angsuran_date_$i AS angsuran_date"),
                        DB::raw("a.Penagihan_{$i}_date AS penagihan_date"),
                        DB::raw("a.h$i AS h"),
                        DB::raw("a.penagihan_$i AS penagihan"),
                        DB::raw("a.retur_$i AS retur"),
                        DB::raw("a.A$i AS A"),
                        DB::raw("'' AS status")
                    )
                    ->where(DB::raw("a.angsuran_date_$i"), $this->tglangsuran)
                    ->where(function ($query) {
                        $query->where('b.namasurveyors', 'like', '%' . $this->cari . '%')
                            ->orWhere('a.nota', 'like', '%' . $this->cari . '%')
                            ->orWhere('a.customernama', 'like', '%' . $this->cari . '%');
                    });

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
            $this->data = $Query->get();

            foreach ($this->data as $data) {
                $this->cattambahan[$data->tim . $data->nota] = '';
            }


            // $this->data = $Query->get()->map(function ($item) {
            //     // Tambahkan kolom status default
            //     $item->status = '';
            //     return $item;
            // });

            // Debugging: dump the resulting query and notasArray
            // dump($Query->toSql());
            // dump($notasArray);
        }
    }

    public function render() {


        return view('livewire.panel.utility.sendwatagihan', [
            'datas' => $this->data,
        ])
            ->layout('layouts.app-layout', [
                'menu' => 'navmenu.panel',
                'title' => $this->title,
            ]);
    }
}
