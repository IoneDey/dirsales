<?php

namespace App\Livewire\Main\Penagihan;

use Livewire\Component;

class Laporanpenagihantim extends Component {
    public $title = 'Rekap Pertim';

    public function render() {
        return view('livewire.main.penagihan.laporanpenagihantim')->layout('layouts.kai-layout', [
            'menu' => 'navmenu.main',
            'title' => $this->title,
        ]);
    }
}
