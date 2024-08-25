<?php

namespace App\Livewire\Main\Penagihan;

use App\Models\Penagihanreschedule;
use App\Models\Penjualanhd;
use App\customClass\myNumber;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Rescheduleangsuran extends Component {
    public $title = "Reschedule Angsuran";

    // pencarian by nota
    public $isNota = false;
    public $results;

    // field cari
    public $timsetupid;
    public $nota = '';
    public $tim;
    public $pt;
    public $kota;
    public $customernama;
    public $customeralamat;

    public $tgljual;
    public $jmljual;
    public $tglAngsuranAkhir;

    public $dbKartuPiutang;
    public $dbInfoAngsuran;

    public $dbKolektors;

    public $selectedOption = 'Up';

    //field reschedule
    public $tglreschedule;
    public $angsuranhari;
    public $angsuranperiode;
    public $kurir;
    public $penjualan;

    public function mount() {
        $this->dbKolektors = DB::select("SELECT nama FROM `karyawans` where void=0 and flagkolektor=1");
    }

    public function resetErrors() {
        $this->resetErrorBag();
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
        $this->timsetupid = "";
        $this->tim = '';
        $this->pt = '';
        $this->kota = '';
        $this->customernama = '';
        $this->customeralamat = '';

        $this->angsuranhari = "";
        $this->angsuranperiode = "";
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
            'penjualanhds.status'
        )
            ->leftJoin('timsetups', 'timsetups.id', '=', 'penjualanhds.timsetupid')
            ->leftJoin('tims', 'tims.id', '=', 'timsetups.timid')
            ->leftJoin('pts', 'pts.id', '=', 'tims.ptid')
            ->leftJoin('kotas', 'kotas.id', '=', 'timsetups.kotaid')
            ->where('nota', $this->nota)
            ->where('timsetupid', $this->timsetupid)
            ->first();
        if ($data) {
            $this->timsetupid = $data->timsetupid;
            $this->tim = $data->tim;
            $this->pt = $data->pt;
            $this->kota = $data->kota;
            $this->customernama = $data->customernama;
            $this->customeralamat = $data->customeralamat;
            $this->tgljual = $data->tgljual;
            $this->angsuranhari = $data->angsuranhari;
            $this->angsuranperiode = $data->angsuranperiode;
        }


        //ambil nilai jual dan sisa
        $datajmljual = DB::select('
                select
                    omset as totaljual,omset-ifnull(totretur,0)-ifnull(tottagihan,0) as penjualan
                from vwpenagihanresumenota where nota=? and timsetupid=?
                ', [$nota, $timsetupid]);
        $this->jmljual = $datajmljual[0]->totaljual;
        $this->penjualan = number_format(floatval($datajmljual[0]->penjualan), 0, '', '.');
    }
    // end pilih nota

    public function getKartuPiutangNota($nota) {
        $escNota = $this->esc_chars($nota);
        $Sql = "
            SELECT
                X.*,
                @saldo := @saldo + (IFNULL(X.debet, 0) - X.kredit) AS saldo
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

    public function getInformasiAngsuran($nota) {
        $escNota = $this->esc_chars($nota);

        // reschedule angsuran rata2
        if ($this->selectedOption == 'Avg') {
            $Sql = "
            WITH RECURSIVE cteAngsuran AS (
                SELECT
                    timsetupid,
                    nota,
                    tgljual,
                    DATE_ADD( tgljual, INTERVAL angsuranhari DAY ) AS tglangsuran,
                    angsuranhari,
                    angsuranperiode,
                    1 AS noawal
                FROM
                    penjualanhds UNION ALL
                SELECT
                    t1.timsetupid,
                    t1.nota,
                    t1.tgljual,
                    DATE_ADD( t2.tglangsuran, INTERVAL t1.angsuranhari DAY ) AS tglangsuran,
                    t1.angsuranhari,
                    t1.angsuranperiode,
                    t2.noawal + 1 AS noawal
                FROM
                    penjualanhds t1
                    LEFT JOIN cteAngsuran t2 ON t1.nota = t2.nota and t1.timsetupid=t2.timsetupid
                WHERE
                    t2.noawal < t1.angsuranperiode
                ),
                cteAngsuranTagih AS (
                SELECT
                    a.timsetupid,
                    a.nota,
                    a.noawal,
                    a.tgljual,
                    a.tglangsuran,
                    b.tglpenagihan,
                    a.angsuranhari,
                    a.angsuranperiode,
                    (b.jumlahbayar+b.biayakomisi+b.biayaadmin) AS jmlpenagihan
                FROM
                    cteAngsuran a
                    LEFT JOIN penagihans b ON a.nota = b.nota and a.timsetupid=b.timsetupid
                    AND b.tglpenagihan BETWEEN a.tglangsuran
                    AND DATE_ADD( a.tglangsuran, INTERVAL a.angsuranhari - 1 DAY )
                ),
                cteFinalAngsuranProses AS (
                SELECT
                    *
                FROM
                    cteAngsuranTagih UNION ALL
                SELECT
                    a.timsetupid,
                    a.nota,
                    0 AS noawal,
                    b.tgljual,
                    COALESCE ( b.tglangsuran, a.tglpenagihan ) AS tglangsuran,
                    a.tglpenagihan,
                    NULL AS angsuranhari,
                    NULL AS angsuranperiode,
                    (a.jumlahbayar+a.biayakomisi+a.biayaadmin) AS jmlpenagihan
                FROM
                    penagihans a
                    LEFT JOIN cteAngsuranTagih b ON a.tglpenagihan = b.tglpenagihan
                    AND (a.jumlahbayar+a.biayakomisi+a.biayaadmin) = b.jmlpenagihan
                WHERE
                    b.tglpenagihan IS NULL
                ),
                cteDataAngsuran AS (
                SELECT
                    a.timsetupid,
                    a.nota,
                    SUM(( b.jumlah + b.jumlahkoreksi )* c.hargajual ) AS totaljual,
                    a.angsuranhari,
                    a.angsuranperiode,
                    SUM(( b.jumlah + b.jumlahkoreksi ) * c.hargajual ) / a.angsuranperiode AS perangsuran,
                    CEIL( SUM(( b.jumlah + b.jumlahkoreksi ) * c.hargajual ) / a.angsuranperiode / 1 ) * 1 AS perangsuranUp,
                    FLOOR( SUM(( b.jumlah + b.jumlahkoreksi ) * c.hargajual ) / a.angsuranperiode / 1 ) * 1 AS perangsuranDown,
                    FLOOR( SUM(( b.jumlah + b.jumlahkoreksi ) * c.hargajual ) / a.angsuranperiode ) AS perangsuranBulat,
                    a.STATUS
                FROM
                    penjualanhds a
                    LEFT JOIN penjualandts b ON a.id = b.penjualanhdid
                    LEFT JOIN timsetuppakets c ON c.id = b.timsetuppaketid
                GROUP BY
                    a.timsetupid,
                    a.nota,
                    a.angsuranhari,
                    a.angsuranperiode,
                    a.STATUS
                ),
                cteNormalAngsuran AS (
                SELECT
                    a.timsetupid,
                    a.nota,
                    b.totaljual,
                    b.perangsuran,
                    a.noawal AS angsuranke,
                    a.tglangsuran,
                    a.tglpenagihan,
                    a.jmlpenagihan,
                    b.STATUS AS statuspenjualan
                FROM
                    cteFinalAngsuranProses a
                    LEFT JOIN cteDataAngsuran b ON a.nota = b.nota and a.timsetupid=b.timsetupid
                    AND a.angsuranperiode = b.angsuranperiode
                    WHERE a.nota = '$escNota' and a.timsetupid='$this->timsetupid'
                ),
                cteTotalTagih AS (
                    SELECT
                        timsetupid, nota, max( tglpenagihan ) AS tglTerakhir, sum(jumlahbayar+biayakomisi+biayaadmin) AS totTertagih
                    FROM penagihans
                    WHERE nota = '$escNota' and timsetupid='$this->timsetupid'
                    GROUP BY timsetupid,nota
                ), cteSisaPeriodeAngsuran AS
                (
                    select
                        a.timsetupid, a.nota,count(a.nota) as reAngsuranperiode
                    from cteNormalAngsuran a
                    left join cteTotalTagih b on a.nota=b.nota and a.timsetupid=b.timsetupid
                    where a.angsuranke<>0 and a.tglpenagihan is NULL
                    and a.tglangsuran > b.tglTerakhir
                    group by a.timsetupid,a.nota
                ), cteDataReschedulePenagihan AS
                (
                select
                    a.*,b.reAngsuranperiode
                from cteTotalTagih a
                left join cteSisaPeriodeAngsuran b on a.nota=b.nota and a.timsetupid=b.timsetupid
                ), cteReScheduleAngsuran AS
                (
                    SELECT
                        a.timsetupid, a.nota,a.totaljual,perangsuran,angsuranke,tglangsuran,tglpenagihan,jmlpenagihan,statuspenjualan
                    FROM
                        cteNormalAngsuran a
                    where a.tglangsuran <= COALESCE((select tglTerakhir from cteDataReschedulePenagihan),a.tglangsuran)
                    union all
                    SELECT
                        a.timsetupid, a.nota,a.totaljual,(a.totaljual-b.totTertagih) / reAngsuranperiode as perangsuran,a.angsuranke,a.tglangsuran,a.tglpenagihan,
                        a.jmlpenagihan,a.statuspenjualan
                    FROM cteNormalAngsuran a
                    left join cteDataReschedulePenagihan b on a.nota=b.nota and a.timsetupid=b.timsetupid
                    where a.tglangsuran > COALESCE((select tglTerakhir from cteDataReschedulePenagihan),a.tglangsuran)
            )
            select * from cteReScheduleAngsuran
            ORDER BY
                tglangsuran,
                tglpenagihan,
                nota;
        ";
        };

        if ($this->selectedOption == 'Up' || $this->selectedOption == 'Down') {
            $Sql = "
                select * from vwlistangsuran
                WHERE nota = '$escNota' and timsetupid='$this->timsetupid'
            ";
        };
        $this->dbInfoAngsuran = DB::select($Sql);
    }

    public function clear() {
        $this->tglreschedule = '';
        $this->angsuranhari = '';
        $this->angsuranperiode = '';
        $this->kurir = '';
        $this->penjualan = '';

        $this->timsetupid = null;
        $this->nota = '';

        $this->tim = '';
        $this->pt = '';
        $this->kota = '';
        $this->customernama = '';
        $this->customeralamat = '';

        $this->tgljual = null;
        $this->jmljual = null;
        $this->tglAngsuranAkhir = null;
    }

    public function create() {

        $this->penjualan = myNumber::str2Float($this->penjualan);

        $rules = [
            'timsetupid' => ['required', 'numeric'],
            'nota' => [
                'required',
                'min:15',
                'max:15',
                Rule::unique('penagihanreschedules')->where(function ($query) {
                    return $query->where('timsetupid', $this->timsetupid);
                })
            ],
            'tglreschedule' => [
                'required', 'date',
                function ($attribute, $value, $fail) {
                    if (strtotime($value) < strtotime(Carbon::now()->startOfDay())) {
                        $fail('Tanggal reschedule harus lebih besar atau sama dengan tanggal sekarang.');
                    }
                }
            ],
            'angsuranhari' => ['required', 'numeric', 'min:1', 'max:31'],
            'angsuranperiode' => ['required', 'numeric', 'min:1', 'max:10'],
            'penjualan' => ['required', 'numeric', 'min:1'],
            'kurir' => ['required', 'string', 'max:150'],
        ];

        $validate = $this->validate($rules);
        $validate['userid'] = auth()->user()->id;

        Penagihanreschedule::create($validate);
        $this->penjualan = number_format(floatval($this->penjualan), 0, '', '.');
        $this->js('alert("Reschedule angsuran nota: ' . $this->nota . ' berhasil.")');
    }

    public function render() {
        $this->getKartuPiutangNota($this->nota);
        $this->getInformasiAngsuran($this->nota);

        return view('livewire.main.penagihan.rescheduleangsuran', [
            'dbKartus' => $this->dbKartuPiutang,
        ])->layout('layouts.kai-layout', [
            'menu' => 'navmenu.main',
            'title' => $this->title,
        ]);
    }
}