@props(['invoice'])

<div class="p-4 space-y-3" wire:key="row-{{ $invoice->id }}">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="text-sm font-medium text-gray-900">${{ number_format($invoice->amount_due, 2) }}</span>
            <span class="text-sm text-gray-500">{{ strtoupper($invoice->currency) }}</span>
        </div>
        <span
            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
            {{ match ($invoice->status) {
                'pending' => 'bg-yellow-500 text-white',
                'paid' => 'bg-green-200 text-green-800',
                'draft' => 'bg-gray-200 text-gray-800',
                'open' => 'bg-blue-200 text-blue-800',
                'past_due' => 'bg-red-200 text-red-800',
                default => 'bg-gray-100 text-gray-800',
            } }}">
            {{ ucfirst($invoice->status) }}
        </span>
    </div>

    <!-- Invoice Details -->
    <div class="space-y-1">
        <div class="flex justify-between">
            <span class="text-xs text-gray-500">Invoice Number</span>
            <span class="text-sm text-gray-900">{{ $invoice->number }}</span>
        </div>
        <div class="flex justify-between">
            <span class="text-xs text-gray-500">Customer</span>
            <span class="text-sm text-gray-900">{{ $invoice->user->email }}</span>
        </div>
        <div class="flex justify-between">
            <span class="text-xs text-gray-500">Due Date</span>
            <span class="text-sm text-gray-900">{{ $invoice->due ?? '—' }}</span>
        </div>
        <div class="flex justify-between">
            <span class="text-xs text-gray-500">Created</span>
            <span class="text-sm text-gray-900">{{ $invoice->created_at }}</span>
        </div>
    </div>

    <!-- Actions -->
    <div class="pt-2 flex justify-end">
        <div class="flex items-center justify-end gap-2">
            <div class="relative" x-data="{ open: false }" wire:key="dropdown-{{ $invoice->id }}">
                <button @click="open = !open" class="text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path
                            d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                    </svg>
                </button>

                <div x-show="open" @click.away="open = false" x-cloak
                    class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100"
                    style="z-index: 50;">
                    <div class="px-4 py-2">
                        <p class="text-xs font-semibold text-gray-500 uppercase">Actions</p>
                    </div>
                    <div class="py-1">
                        <button wire:click="downloadPDF('{{ $invoice->id }}')" x-on:click="open = false"
                            class="block w-full text-left px-4 py-2 text-sm text-blue-600 hover:bg-gray-100">
                            Download PDF
                        </button>
                        <button wire:click="duplicateInvoice({{ $invoice->id }})" x-on:click="open = false"
                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Duplicate invoice
                        </button>
                        <button wire:click="deleteDraft({{ $invoice->id }})" x-on:click="open = false"
                            class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                            Delete draft
                        </button>
                    </div>
                    <div class="px-4 py-2">
                        <p class="text-xs font-semibold text-gray-500 uppercase">Connections</p>
                    </div>
                    <div class="py-1">
                        <button wire:click="viewCustomer({{ $invoice->id }})" x-on:click="open = false"
                            class="w-full text-left px-4 py-2 text-sm text-blue-600 hover:bg-gray-100 flex items-center">
                            View customer
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
