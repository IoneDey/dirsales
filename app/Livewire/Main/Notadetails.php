<?php

namespace App\Livewire\Main;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Notadetails extends Component {
    public $timsetupid;
    public $nota;

    public $dbPenjualan;


    public $dbRetur;
    public $dbReturTotal;

    public $dbpenagihan;
    public $dbpenagihanTotal;

    public $Sisa;

    protected $listeners = ['showNotaDetails' => 'loadNotaDetails'];

    public function loadNotaDetails($timsetupid, $nota) {
        $this->timsetupid = $timsetupid;
        $this->nota = $nota;

        $this->dbPenjualan = DB::table('vwpenjualanpaket')
            ->select(
                'tim',
                'customernama',
                'jumlah',
                'Total',
            )
            ->where('timsetupid', $this->timsetupid)
            ->where('nota', $this->nota)
            ->first();

        $this->dbRetur = DB::table('vwpenjualanretrekaps')
            ->where('timsetupid', $this->timsetupid)
            ->where('nota', $this->nota)
            ->get();

        $this->dbReturTotal = DB::table('vwpenjualanretrekaps')
            ->where('timsetupid', $this->timsetupid)
            ->where('nota', $this->nota)
            ->sum('Total');

        $this->dbpenagihan = DB::table('vwpenagihans')
            ->where('timsetupid', $this->timsetupid)
            ->where('nota', $this->nota)
            ->get();

        $this->dbpenagihanTotal = DB::table('vwpenagihans')
            ->where('timsetupid', $this->timsetupid)
            ->where('nota', $this->nota)
            ->sum('Total');

        $this->Sisa = ($this->dbPenjualan->Total ?? 0) - $this->dbReturTotal - $this->dbpenagihanTotal;

        // $this->retur = Retur::where('nota_id', $this->nota_id)->get();
        // $this->penagihan = Penagihan::where('nota_id', $this->nota_id)->get();

        $this->dispatch('openModal');
    }

    public function render() {
        return view('livewire.main.notadetails');
    }
}
