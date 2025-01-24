<?php

namespace App\Livewire;

use Livewire\Component;

class InvoiceTabs extends Component
{
    public $activeTab = 'all';

    protected $queryString = ['activeTab'];

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->dispatch('tabChanged', tab: $tab);
    }

    public function render()
    {
        return view('livewire.invoice-tabs', [
            'tabs' => [
                'all' => 'All invoices',
                'draft' => 'Draft',
                'open' => 'Outstanding',
                'past due' => 'Past due',
                'paid' => 'Paid',
            ]
        ])->layout('layouts.app');
    }
}
