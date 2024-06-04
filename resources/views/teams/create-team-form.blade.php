<x-formTeam-section submit="createTeam">

    <x-slot name="form">

        <div class="col-span-6 sm:col-span-6">
            <x-label for="name" value="{{ __('Store Name') }}" />
            <x-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" autofocus />
            <x-input-error for="name" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-6">
            <x-label for="store_number" value="{{ __('Store Number') }}" />
            <x-input id="store_number" type="text" class="mt-1 block w-full" wire:model.defer="state.store_number"
                autofocus />
            <x-input-error for="store_number" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-button>
            {{ __('Create') }}
        </x-button>

    </x-slot>
</x-formTeam-section>
