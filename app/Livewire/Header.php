<?php

namespace App\Livewire;

use Livewire\Component;

class Header extends Component
{
    public string $searchTerm = '';

    public function updatedSearchTerm($value)
    {
        $this->dispatch('search', searchTerm: $value ?? '');
    }

    public function render()
    {
        return view('livewire.header');
    }
}
