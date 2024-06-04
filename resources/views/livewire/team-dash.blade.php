<div class="">
    <div class="pb-6 px-6 bg-white shadow shadow-gray-400">
        <div class="flex justify-center">
            <x-client-logo />
        </div>

        <h1 class="mb-6 text-2xl font-bold text-blue-6 text-center">
            Store Manager
        </h1>

        <p class="mt-6 text-gray-600 leading-relaxed text-center text-xs lg:text-sm">
            All stores in the database are displayed. Administrators may add new stores to access the individual store
            settings and invite or remove users for each store, navigate to each store page via the View Store action .
        </p>


    </div>

    <div class="p-6 lg:p-8 shadow shadow-gray-400 border border-gray-200  bg-gray-200 h-full">
        <x-button class="mb-4" wire:click="createShowModal">
            {{ __('Add New Store') }}
        </x-button>

        {{-- The data table --}}
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class=" overflow-hidden sm:rounded shadow-lg shadow-gray-400">
                        <table class=" w-full 0">
                            <thead>
                                <tr
                                    class="px-6 py-3 bg-gray-600 text-center text-[10px] xl:text-xs leading-4 font-black text-white uppercase tracking-wider">
                                    <th class="px-6 text-left ">
                                        Store Name</th>
                                    <th class="px-6 text-left">
                                        Store #</th>

                                    <th class="px-3 py-3 text-center">
                                        View Store
                                    </th>

                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @if ($teams->count())
                                    @foreach ($teams as $item)
                                        <tr
                                            class="px-6 py-3 text-[10px] xl:text-xs leading-4 font-medium text-blue-9 uppercase tracking-wider text-left">
                                            <td class="px-6 py-2">{{ $item->name }}</td>
                                            <td class="px-6 py-2">{{ $item->store_number }}</td>
                                            <td class="px-3 py-2 text-center">
                                                <button>
                                                    <a href="{{ route('teams.show', $item->id) }}">
                                                        <span class="material-symbols-outlined">
                                                            move_item
                                                        </span>
                                                    </a>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap" colspan="4">No Results Found
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <br />
                    @if ($links->links())
                        {{ $links->links() }}
                    @endif
                </div>
            </div>
        </div>

        <x-dialogTeam-modal wire:model="modalFormVisible" class="py-0">
            <x-slot name="title">

                {{ __('Add New Store') }}

            </x-slot>

            <x-slot name="content">
                @livewire('teams.create-team-form')

            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="close" wire:loading.attr="disabled" class="mr-4">
                    {{ __('Close') }}
                </x-secondary-button>

            </x-slot>
        </x-dialogTeam-modal>
    </div>
</div>
