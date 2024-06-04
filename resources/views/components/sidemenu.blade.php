<x-filterdropdown align="right" width="60">
    <x-slot name="trigger">
        <button
            class="inline-flex items-center justify-center p-2 rounded-md text-blue-8 hover:text-blue-3 hover:bg-blue-2 focus:outline-none transition duration-150 ease-in-out">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16" />

            </svg>
        </button>

    </x-slot>

    <x-slot name="content">
        <div class="ml-5">

            @livewire('media-filter')
        </div>
        <div class="ml-5">

            @livewire('category-filter')
        </div>
    </x-slot>
</x-filterdropdown>
