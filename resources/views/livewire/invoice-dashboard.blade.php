<div class="p-12">
    <div class="container mx-auto max-w-[75%]">
        @livewire('header')
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4 sm:gap-0">
            <h2 class="text-2xl font-bold">Invoices</h2>

            <!-- Action Buttons -->
            <div class="flex gap-2 w-full sm:w-auto">
                <button
                    class="flex-1 sm:flex-none px-2 py-1 bg-white border rounded-md text-xs hover:bg-gray-50 flex items-center gap-2 justify-center">
                    <i class="fas fa-filter"></i>
                    Filter
                </button>
                <button
                    class="flex-1 sm:flex-none px-2 py-1 bg-white border text-xs rounded-md hover:bg-gray-50 flex items-center gap-2 justify-center">
                    <i class="fas fa-download"></i>
                    Export
                </button>
                <button wire:click="$dispatch('openModal', 'create-invoice')"
                    class="flex-1 sm:flex-none px-2 py-1 bg-stripe-blue text-white rounded-md text-xs hover:bg-blue-700 flex items-center gap-2 justify-center">
                    <i class="fas fa-plus"></i>
                    Create invoice <span class="text-xs text-gray-200 rounded-md bg-[#8e7ffb] px-2 py-1">N</span>
                </button>
            </div>
        </div>

        <!-- Tabs -->
        @livewire('invoice-tabs')

        <!-- Table -->
        <div class="overflow-x-auto">
            @if (count($invoices) > 0)
                <div>
                    <!-- Desktop Table -->
                    <table class="hidden sm:table min-w-full divide-y">
                        <thead>
                            <tr>
                                <th class="w-1/6 px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase">
                                    Amount
                                </th>
                                <th class="w-1/6 py-3 text-left text-xs font-medium text-gray-900 uppercase">
                                    Invoice Number
                                </th>
                                <th class="w-1/3 py-3 text-left text-xs font-medium text-gray-900 uppercase">
                                    <div class="flex items-center gap-1">

                                        Customer
                                        <i class="fas fa-cog text-gray-500"></i>
                                    </div>
                                </th>
                                <th class="w-24 px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase">
                                    Due
                                </th>
                                <th class="w-1/6 py-3 text-left text-xs font-medium text-gray-900 uppercase">
                                    Created
                                </th>
                                <th class="w-2/6 relative px-6 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y">
                            @foreach ($invoices as $invoice)
                                <x-invoice-table-row :invoice="$invoice" :key="$invoice->id" />
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Mobile Card View -->
                    <div class="sm:hidden divide-y divide-gray-200">
                        @foreach ($invoices as $invoice)
                            <x-invoice-mobile-card :invoice="$invoice" />
                        @endforeach
                    </div>
                </div>
            @else
                <div class="text-center py-12 bg-white rounded-lg">
                    <p class="text-gray-500">No invoices found</p>
                </div>
            @endif
        </div>
    </div>
</div>
