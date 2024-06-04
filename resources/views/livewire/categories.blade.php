<div>
    <div class="pb-6 px-6 bg-white shadow shadow-gray-400">
        <div class="flex justify-center">
            <x-client-logo />
        </div>

        <h1 class="mb-6 text-lg lg:text-xl xl:text-2xl font-bold text-blue-6 text-center">
            Content Category Manager
        </h1>

        <p class="mt-6 text-gray-600 leading-relaxed text-center text-sm xl:text-base">
            View, add, edit or delete categories; view content counts for each category.
        </p>


    </div>
    <div class="p-2 lg:p-8 shadow shadow-gray-400 border border-gray-200  bg-gray-200">

        <x-button class="mb-4 mt-4" wire:click="createShowModal">
            {{ __('Add New Category') }}
        </x-button>


        {{-- data table --}}
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class=" overflow-hidden sm:rounded shadow-lg shadow-gray-400">
                        <table class="  w-full 0">
                            <thead>
                                <tr
                                    class="px-6 py-3 bg-gray-600 text-[10px] xl:text-xs leading-4 font-black text-white uppercase tracking-wider ">
                                    <th class="px-6 text-left">
                                        Image</th>
                                    <th class="px-2 lg:px-6 text-left">
                                        Name</th>
                                    <th class="px-2 lg:px-6 py-3">
                                        Content Count</th>
                                    <th class="px-2 lg:px-6 ">
                                        Visible</th>
                                    <th class="px-2 lg:px-6 py-3">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @if ($allCategories->count())
                                    @foreach ($allCategories as $item)
                                        <tr
                                            class="px-6 text-[10px] xl:text-xs leading-4 font-medium uppercase tracking-wider text-center {{ $item->visible != 1 ? 'text-gray-200' : 'text-blue-9' }}">
                                            <td class="text-left">
                                                <div
                                                    class="flex  place-content-center mx-2 {{ $item->visible != 1 ? 'contrast-50  grayscale invert' : '' }} ">
                                                    <img class="md:h-14 xl:h-16  "
                                                        src="{{ Storage::disk('s3')->url('canadiantirecms/categoryimages/' . $item->image) }}">
                                                </div>
                                            </td>
                                            <td class="px-2 lg:px-6 text-left ">
                                                {{ $item->name }}
                                            </td>
                                            <td class="px-2 lg:px-6 ">
                                                @if ($item->media)
                                                    {{ $item->media->count() }}
                                                @endif
                                            </td>
                                            <td class="px-2 lg:px-6 text-center ">
                                                @if ($item->visible == 1)
                                                    <span class="material-symbols-outlined text-sm lg:text-base">
                                                        visibility
                                                    </span>
                                                @else
                                                    <span class="material-symbols-outlined text-sm lg:text-base">
                                                        visibility_off
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-2 lg:px-6">
                                                <button
                                                    class="material-symbols-outlined  py-3 text-base lg:text-lg leading-4 font-medium text-blue-9 tracking-wider text-center  hover:text-blue-2 active:bg-blue-3 transition ease-in-out duration-150"
                                                    wire:click="updateShowModal({{ $item->id }})">
                                                    edit
                                                </button>
                                                <button
                                                    class="material-symbols-outlined  py-3 text-base lg:text-lg leading-4 font-medium text-blue-9 tracking-wider text-center  hover:text-blue-2 active:bg-blue-3 transition ease-in-out duration-150"
                                                    wire:click="deleteShowModal({{ $item->id }})">
                                                    delete
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap" colspan="4">No Results
                                            Found
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

        {{-- modal form --}}
        <x-dialog-modal wire:model="modalFormVisible">
            <x-slot name="title">
                @if ($modelId)
                    {{ __('Update Category') }}
                @else
                    {{ __('Add New Category') }}
                @endif
            </x-slot>

            <x-slot name="content">
                <div class=" mt-4">

                    <input type="file" wire:model="image"
                        class="text-sm text-grey-500
                        file:mr-4 file:py-2 file:px-6
                        file:rounded-l-md file:border-0
                        file:text-sm file:font-medium
                        file:bg-gray-200 file:text-blue-6
                        hover:file:cursor-pointer hover:file:bg-gray-400
                        hover:file:text-white focus:border-gray-300 focus:ring-0 mb-4 form-input flex-1 block w-full rounded-md text-gray-500 transition duration-150 ease-in-out border border-gray-300 p-0 sm:text-sm sm:leading-5"
                        id="upload{{ $iteration }}" />
                    <x-input-error for="image" class="mt-2" />
                </div>
                <div class=" my-4">

                    @if (!$image)
                        <div class="my-4">

                        </div>
                    @elseif($image && !is_string($image))
                        <div class="my-4">
                            <x-label for="image" value="{{ __('Image Preview') }}" />
                            <img src="{{ $image->temporaryUrl() }}">
                        </div>
                    @elseif ($modelId)
                        <div class="z-depth-1-half mb-2">
                            <x-label for="image" value="{{ __('Image Preview') }}" />
                            <img src="{{ Storage::disk('s3')->url('canadiantirecms/categoryimages/' . $image) }}">
                        </div>
                    @endif
                </div>

                {{-- @if ($modelId)
                    <div class="mb-4">
                        <div class="text-base">Category: <span class="font-light">{{ $name }}</span></div>
                        <x-input id="name" type="hidden" class="" wire:model.debonce.800ms="name" />
                    </div>
                @else
                    <div class="mb-4">
                        <x-label for="name" value="{{ __('Category Name') }}" />
                        <x-input id="name" type="text" class="mt-1 block w-full "
                            wire:model.debonce.800ms="name" />
                        <x-input-error for="name" class="mt-2" />
                    </div>
                @endif --}}
                <div class="mb-4">
                    <x-label for="name" value="{{ __('Category Name') }}" />
                    <x-input id="name" type="text" class="mt-1 block w-full" wire:model.debonce.800ms="name" />
                    <x-input-error for="name" class="mt-2" />
                </div>

                <div class="mt-6">
                    <x-label for="visible" value="{{ __('Display Category for Clients') }}" />
                    <div class=" mb-4 mt-2 text-sm text-gray-900 flex content-start align-middle">
                        <x-input id="visible" wire:model='visible' value="1" type="checkbox"
                            class="rounded border-gray-500 text-gray-900 shadow-sm  focus:ring-white focus:border-gray-300 hover:text-gray-700 mr-2 p-2" />

                        Show Visible
                        {{-- Show Visible: {{ var_export($visible) }} --}}
                        <x-input-error for="visible" class="mt-2" />
                    </div>

                </div>


            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="close" wire:loading.attr="disabled">
                    {{ __('Close') }}
                </x-secondary-button>

                @if ($modelId)
                    <x-button wire:click="update" wire:loading.attr="disabled">
                        {{ __('Update') }}
                    </x-button>
                @else
                    <x-button wire:click="create" wire:loading.attr="disabled">
                        {{ __('Create') }}
                    </x-button>
                @endif

            </x-slot>
        </x-dialog-modal>

        {{-- The Delete Modal --}}

        <x-dialog-modal wire:model="modalConfirmDeleteVisible">
            <x-slot name="title">
                {{ __('Delete Category') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you want to delete this category? Once deleted, all of its resources and data will be permanently deleted.') }}
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('modalConfirmDeleteVisible')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                    {{ __('Delete') }}
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
        {{-- <div>
            <button type="button" data-mdb-ripple="true" data-mdb-ripple-color="light"
                class="inline-block p-3 bg-slate-800 text-white font-medium text-xs border border-gray-400 leading-tight uppercase rounded-full shadow-xl hover:bg-gray-400 hover:shadow-lg focus:bg-slate-800 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-slate-600 active:shadow-lg transition duration-150 ease-in-out bottom-5 lg:bottom-16 right-5 fixed aria-hidden:hidden"
                id="btn-back-to-top">
                <svg aria-hidden="true" focusable="false" data-prefix="fas" class="w-4 h-4" role="img"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                    <path fill="currentColor"
                        d="M34.9 289.5l-22.2-22.2c-9.4-9.4-9.4-24.6 0-33.9L207 39c9.4-9.4 24.6-9.4 33.9 0l194.3 194.3c9.4 9.4 9.4 24.6 0 33.9L413 289.4c-9.5 9.5-25 9.3-34.3-.4L264 168.6V456c0 13.3-10.7 24-24 24h-32c-13.3 0-24-10.7-24-24V168.6L69.2 289.1c-9.3 9.8-24.8 10-34.3.4z">
                    </path>
                </svg>
            </button>
        </div> --}}


    </div>

    {{-- <script>
        // Get the button
        let mybutton = document.getElementById("btn-back-to-top");

        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function() {
            scrollFunction();
        };

        function scrollFunction() {
            if (
                document.body.scrollTop > 20 ||
                document.documentElement.scrollTop > 20
            ) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
        }
        // When the user clicks on the button, scroll to the top of the document
        mybutton.addEventListener("click", backToTop);

        function backToTop() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script> --}}
</div>
