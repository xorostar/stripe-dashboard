<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Invoice;
use Livewire\Attributes\On;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceDashboard extends Component
{

    public $searchTerm = '';
    public $activeTab = 'all';

    #[On('search')]
    public function handleSearch($searchTerm)
    {
        $this->searchTerm = $searchTerm;
    }

    #[On('tabChanged')]
    public function handleTabChanged($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        $query = Invoice::query()
            ->with('user')
            ->when($this->searchTerm, function ($query) {
                $query->where(function ($query) {
                    $query->where('status', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('number', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('amount_due', 'like', '%' . $this->searchTerm . '%')
                        ->orWhereHas('user', function ($query) {
                            $query->where('email', 'like', '%' . $this->searchTerm . '%');
                        });
                });
            })
            ->when($this->activeTab !== 'all', function ($query) {
                $query->where('status', $this->activeTab);
            });

        $invoices = $query->latest()->get();

        return view('livewire.invoice-dashboard', [
            'invoices' => $invoices,
            'tabs' => [
                'all' => 'All Invoices',
                'pending' => 'Pending',
                'paid' => 'Paid'
            ]
        ])->layout('layouts.app');
    }

    public function downloadPDF($invoiceId)
    {
        $invoice = Invoice::findOrFail($invoiceId);
        try {
            $invoice->load('user');

            $pdf = Pdf::loadView('pdfs.invoice', [
                'invoice' => $invoice
            ]);

            $this->dispatch('invoice-generated');

            return response()->streamDownload(
                function () use ($pdf) {
                    echo $pdf->output();
                },
                "invoice-{$invoice->number}.pdf",
                [
                    'Content-Type' => 'application/pdf',
                ]
            );
        } catch (\Exception $e) {
            $this->dispatch('error', message: 'Failed to generate invoice PDF.');
        }
    }



    public function deleteDraft($invoiceId)
    {
        // TODO: Implement delete draft functionality
    }
}
