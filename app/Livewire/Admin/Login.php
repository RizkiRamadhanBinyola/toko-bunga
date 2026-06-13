<?php

namespace App\Livewire\Admin;

use App\Models\AdminLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest')]
class Login extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;

    public function login(): void
    {
        $this->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        $key = 'login_attempts_' . request()->ip();
        $attempts = (int) Cache::get($key, 0);

        if ($attempts >= 5) {
            $this->addError('email', 'Terlalu banyak percobaan login. Silakan coba lagi dalam 5 menit.');
            return;
        }

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            Cache::put($key, $attempts + 1, 300);
            $this->addError('email', 'Email atau password salah.');
            return;
        }

        Cache::forget($key);
        session()->regenerate();

        AdminLog::log('login', 'Admin login');

        $this->redirect(route('admin.dashboard'), navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.login');
    }
}
