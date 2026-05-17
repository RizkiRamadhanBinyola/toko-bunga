<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Logout extends Component
{
    public function logout(): void
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        $this->redirect(route('admin.login'), navigate: false);
    }

    public function render()
    {
        return <<<'BLADE'
        <button wire:click="logout" class="{{ $class ?? '' }}">
            {{ $slot ?? 'Logout' }}
        </button>
        BLADE;
    }
}
