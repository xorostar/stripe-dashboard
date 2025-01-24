<div class="border-b mb-1 -mt-6">
    <nav class="-mb-px flex flex-wrap gap-4 sm:gap-8" aria-label="Tabs">
        @foreach ($tabs as $key => $label)
            <button wire:click="setActiveTab('{{ $key }}')"
                class="whitespace-nowrap py-3 sm:py-4 px-1 border-b-2 font-medium text-xs sm:text-sm
                {{ $activeTab === $key
                    ? 'border-stripe-blue text-stripe-blue'
                    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                {{ $label }}
            </button>
        @endforeach
    </nav>
</div>
