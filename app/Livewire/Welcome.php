<?php

namespace App\Livewire;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

//#[\Livewire\Attributes\layout('layouts.main-layout')]
class Welcome extends Component {
    public string $username = '';
    public string $password = '';
    public $isLogin = false;

    public function loginpopup($bol) {
        $this->isLogin = $bol;
    }

    public function login() {
        $credentials = $this->only('username', 'password');
        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'password' => 'Kombinasi nama pengguna dan kata sandi tidak valid.'
            ]);
        }
        // RateLimiter::clear($throttleKey);
        return redirect(route('main'));
    }

    public function render() {
        return view('livewire.welcome')->layout('layouts.blank-layout');
    }
}
