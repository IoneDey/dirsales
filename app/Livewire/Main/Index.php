<?php

namespace App\Livewire\Main;

use Livewire\Component;

class Index extends Component {
    public $title = 'Home';

    // public function login() {
    //     dd('xx');
    //     try {
    //         // $this->timerNotLogin = 0;
    //         // $throttleKey = $this->throttlekey();
    //         // Ratelimiter::hit($throttleKey);
    //         // if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
    //         //     $this->timerStart = true;
    //         //     throw ValidationException::withMessages([
    //         //         'username' => 'Anda telah mencoba login terlalu banyak.'
    //         //     ]);
    //         // }

    //         $credentials = $this->only('username', 'password');
    //         if (!Auth::attempt($credentials)) {
    //             throw ValidationException::withMessages([
    //                 'password' => 'Kombinasi nama pengguna dan kata sandi tidak valid.'
    //             ]);
    //         }
    //         // RateLimiter::clear($throttleKey);
    //         dd('ok');
    //         return redirect(route('penjualandashboard'));
    //     } catch (ValidationException $e) {
    //         // Tangani pengecualian validasi
    //         throw $e;
    //     } catch (\Exception $e) {
    //         // Tangani pengecualian umum
    //         throw ValidationException::withMessages([
    //             'password' => 'Login gagal.'
    //         ]);
    //     }
    // }

    public function render() {
        return view('livewire.main.index')->layout('layouts.kai-layout', [
            'menu' => 'navmenu.main',
            'title' => $this->title,
        ]);
    }
}
