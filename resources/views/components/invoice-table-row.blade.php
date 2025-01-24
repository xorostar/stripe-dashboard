@props(['invoice'])

<tr class="border-b hover:bg-gray-50 group" wire:key="row-{{ $invoice->id }}">
    <td class="px-6 whitespace-nowrap">
        <div class="flex items-center gap-2">
            <span class="text-sm font-medium text-gray-900 w-16 text-center">
                ${{ number_format($invoice->amount_due, 2) }}
            </span>
            <span class="text-sm text-gray-light w-16 text-center">
                {{ strtoupper($invoice->currency) }}
            </span>
            <span class="text-xs text-gray-light w-4 text-left">
                @if ($invoice->recurring_payment)
                    <i class="fas fa-repeat"></i>
                @endif
            </span>
            <span
                class="inline-flex text-xs leading-5 font-semibold rounded-md w-16 justify-center
                {{ match ($invoice->status) {
                    'pending' => 'bg-yellow-500 text-white',
                    'paid' => 'bg-green-200 text-green-800',
                    'draft' => 'bg-gray-200 text-gray-800',
                    'open' => 'bg-blue-200 text-blue-800',
                    'past due' => 'bg-red-200 text-red-800',
                    default => 'bg-gray-100 text-gray-800',
                } }}">
                {{ ucfirst($invoice->status) }}
            </span>
        </div>
    </td>
    <td class="whitespace-nowrap text-sm text-gray-light font-medium font-inter">
        {{ $invoice->number }}
    </td>
    <td class="whitespace-nowrap text-sm text-gray-light">
        {{ $invoice->user->email }}
    </td>
    <td class="px-6 py-1 whitespace-nowrap text-sm text-gray-light">
        {{ $invoice->due ?? '—' }}
    </td>
    <td class="py-1 whitespace-nowrap text-sm text-gray-light">
        {{ $invoice->created_at->format('M j, g:i A') }}
    </td>
    <td class="px-1 py-1 whitespace-nowrap text-right text-sm font-medium w-80">
        <div class="flex items-center justify-end gap-2">
            <div class="relative" x-data="{ open: false, position: 'bottom' }" x-init="() => {
                $watch('open', value => {
                    if (value) {
                        const dropdown = $refs.dropdown;
                        const button = $refs.button;
                        const buttonRect = button.getBoundingClientRect();
                        const spaceBelow = window.innerHeight - buttonRect.bottom;
                        position = spaceBelow < 320 ? 'top' : 'bottom';
                    }
                })
            }"
                wire:key="dropdown-{{ $invoice->id }}">
                <div class="flex gap-2 border border-transparent w-[68px]" :class="{ 'border-gray-400 rounded': open }">
                    <button x-show="open" wire:click="downloadPDF('{{ $invoice->id }}')"
                        class="text-gray-400 hover:text-gray-600 rounded w-7" :class="{ 'border-gray-300': open }">
                        <i class="fas fa-download"></i>
                    </button>
                    <button @click="open = !open" x-ref="button"
                        class="text-gray-400 hover:text-gray-600 p-1 w-7 ml-auto"
                        :class="{ 'border-l border-gray-400': open }">
                        <i class="fas fa-ellipsis-h"></i>
                    </button>
                </div>
                <div x-show="open" @click.away="open = false" x-cloak x-ref="dropdown"
                    :class="{ 'bottom-full mb-2': position === 'top', 'top-full mt-2': position === 'bottom' }"
                    class="absolute right-0 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5"
                    style="z-index: 50;">
                    <!-- Arrow -->
                    <div class="absolute w-3 h-3 bg-white transform rotate-45"
                        :class="{
                            'bottom-[-6px] right-[11px]': position === 'top',
                            'top-[-6px] right-[11px]': position === 'bottom'
                        }"
                        style="box-shadow: 1px 1px 0 0 rgba(0, 0, 0, 0.05);"></div>
                    <div class="relative bg-white rounded-md">
                        <div class="px-4 py-2">
                            <p class="text-xs text-left font-semibold text-gray-500 uppercase">Actions</p>
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
                            <button x-show="'{{ $invoice->status }}' === 'draft'"
                                wire:click="deleteDraft({{ $invoice->id }})" x-on:click="open = false"
                                class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                Delete draft
                            </button>
                            <div class="border-b border-gray-200"></div>
                        </div>
                        <div class="px-4 py-2">
                            <p class="text-xs text-left font-semibold text-gray-500 uppercase">Connections</p>
                        </div>
                        <div class="py-1">
                            <button wire:click="viewCustomer({{ $invoice->id }})" x-on:click="open = false"
                                class="w-full text-left px-4 py-2 text-sm text-blue-600 hover:bg-gray-100 flex items-center">
                                View customer
                                <i class="fas fa-arrow-right ml-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </td>
</tr>
