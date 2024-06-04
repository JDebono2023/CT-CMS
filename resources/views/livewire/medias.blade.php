<div>
    <div class="pb-6 px-6 bg-white shadow shadow-gray-400">
        <div class="flex justify-center">
            <x-client-logo />
        </div>

        <h1 class="mb-6 text-lg lg:text-xl xl:text-2xl font-bold text-blue-6 text-center">
            Media Content Manager
        </h1>

        <p class="mt-6 text-gray-600 leading-relaxed text-center text-sm xl:text-base">
            View, add, edit or delete image and video content.
        </p>

    </div>
    <div class="p-2 lg:p-4 shadow shadow-gray-400 border border-gray-200  bg-gray-200 grid grid-cols-10">
        <div class="col-span-2 ">
            <button
                class="inline-flex items-center px-4 py-1 bg-blue-6 border border-transparent rounded-md font-body text-xs text-white uppercase tracking-widest shadow shadow-gray-800 hover:bg-blue-2  active:bg-blue-3 focus:outline-none  transition ease-in-out duration-150 mb-2 "
                wire:click="createMediaModal">
                {{ __('Add New') }}
            </button>
            <button
                class="inline-flex items-center px-4 py-1 bg-gray-700 border border-transparent rounded-md font-body text-xs text-white uppercase tracking-widest shadow shadow-gray-800 hover:bg-blue-2  active:bg-blue-3 focus:outline-none  transition ease-in-out duration-150 "
                wire:click="resetFilters">
                {{ __('Clear Filters') }}
            </button>
            <div class="flex flex-col mt-4">

                <div class="flex w-full">
                    <x-tni-search-circle-o
                        class="text-sm h-8 text-gray-600 border border-gray-300 bg-white -mr-1 py-1 px-1 rounded-l-md z-10 " />

                    <x-input wire:model='searchTerm' type="search" placeholder="Search by file or client name"
                        class="w-3/4 mr-3 h-8  text-gray-700 text-xs" />

                    <x-input-error for="searchTerm" class="mt-2" />
                </div>

                <div class="mt-5">
                    <div class="text-[12px] xl:text-sm">
                        Media Type
                        @foreach ($typeList as $info)
                            <div>
                                <x-checkbox wire:model="mediaType" value="{{ $info->type_id }}"
                                    class=""></x-checkbox>
                                <span class="ml-1 mr-5 text-gray-600">{{ $info->types->name }}</span>
                            </div>
                        @endforeach

                    </div>
                    <div class="mt-3"></div>

                    <div class="text-[12px] xl:text-sm">
                        Category
                        @foreach ($mediaCategories as $info)
                            <div>
                                <x-checkbox wire:model="categoryFilter" value="{{ $info->id }}"
                                    class=""></x-checkbox>
                                <span class="ml-1 mr-5 text-gray-600">{{ $info->name }}</span>
                            </div>
                        @endforeach

                    </div>

                </div>
            </div>

        </div>

        {{-- data table --}}
        <div class="flex flex-col col-span-8">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="overflow-hidden sm:rounded shadow-lg shadow-gray-400">
                        <table class="w-full 0">
                            <thead>
                                <tr
                                    class="px-6 py-3 bg-gray-600 text-center text-[10px] xl:text-xs leading-4 font-black text-white uppercase tracking-wider">
                                    <th class="px-2 lg:px-4 text-left">
                                        File Name</th>
                                    <th class="px-2 lg:px-4 text-left">
                                        Client File Name</th>
                                    <th class="px-2 lg:px-4">
                                        Media</th>
                                    <th class="px-2 ">
                                        Type</th>
                                    <th class="px-2 text-left">
                                        Category</th>
                                    <th class="px-2 lg:pr-6 py-3">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @if ($allMedia->count())
                                    @foreach ($allMedia as $item)
                                        <tr
                                            class="text-[10px] xl:text-xs leading-4 font-medium text-blue-9 tracking-wider text-left">
                                            <td class="px-2 lg:px-4 text-left ">
                                                {{ $item->file_name }}
                                            </td>
                                            <td class="px-2 lg:px-4 text-left ">
                                                {{ $item->user_file_name }}
                                            </td>
                                            <td class="text-left">
                                                <div class="flex  place-content-center 2xl:mx-2 lg:py-1">
                                                    @if ($item->thumb)
                                                        <img class="h-8 md:h-10 2xl:h-16 hover:cursor-pointer"
                                                            wire:click="mediaPreviewModal({{ $item->id }})"
                                                            src="{{ Storage::disk('s3')->url('canadiantirecms/videothumbs/' . $item->thumb) }}">
                                                    @else
                                                        <img class="h-8 md:h-10 lg:h-12 2xl:h-12 hover:cursor-pointer"
                                                            wire:click="mediaPreviewModal({{ $item->id }})"
                                                            src="{{ Storage::disk('s3')->url('canadiantirecms/ctMedia/' . $item->media) }}">
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-1 lg:px-4 text-left "> {{ $item->types->name }}
                                            </td>

                                            <td class="px-2  text-left ">
                                                @foreach ($item->category as $cat)
                                                    @if ($cat->name)
                                                        <span class="mb-2">{{ $cat->name }}</span> </br>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td class="px-2 lg:pr-6 text-center">
                                                <button
                                                    class="material-symbols-outlined py-3 text-base lg:text-lg leading-4 font-medium text-blue-9 tracking-wider text-center  hover:text-blue-2 active:bg-blue-3 transition ease-in-out duration-150"
                                                    wire:click="updateMediaModal({{ $item->id }})">
                                                    edit
                                                </button>
                                                <button
                                                    class="material-symbols-outlined  py-3 text-base lg:text-lg leading-4 font-medium text-blue-9 tracking-wider text-center  hover:text-blue-2 active:bg-blue-3 transition ease-in-out duration-150"
                                                    wire:click="deleteMediaModal({{ $item->id }})">
                                                    delete
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="px-2 lg:px-6 text-sm whitespace-no-wrap" colspan="4">No Results
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

        {{-- add-edit modal --}}
        <x-dialog-modal wire:model="addMediaModal">
            <x-slot name="title">
                @if ($modelId)
                    {{ __('Update Media') }}
                @else
                    {{ __('Add New Media') }}
                @endif
            </x-slot>

            <x-slot name="content">
                <div class=" mt-4" x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
                    x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false"
                    x-on:livewire-upload-progress="progress = $event.detail.progress">
                    <!-- File Input -->
                    <input type="file" wire:model="media"
                        class="text-sm text-grey-500
                    file:mr-4 file:py-2 file:px-6
                    file:rounded-l-md file:border-0
                    file:text-sm file:font-medium
                    file:bg-gray-200 file:text-blue-6
                    hover:file:cursor-pointer hover:file:bg-gray-400
                    hover:file:text-white focus:border-gray-300 focus:ring-0 mb-4 form-input flex-1 block w-full rounded-md text-gray-500 transition duration-150 ease-in-out border border-gray-300 p-0 sm:text-sm sm:leading-5"
                        id="upload{{ $iteration }}" />
                    <x-input-error for="media" class="mt-2" />
                    <!-- Progress Bar -->

                    <div wire:loading wire:target="media">
                        <progress max="100" x-bind:value="progress"></progress>
                    </div>
                    {{-- <div x-show="isUploading">
                        <progress max="100" x-bind:value="progress"></progress>
                    </div> --}}
                </div>

                <div class=" my-4">
                    @if (!$media)
                        <div class="my-4">
                        </div>
                    @elseif($media && !is_string($media))
                        <div class="my-4">
                            <x-label for="media" value="{{ __('Media Preview') }}" />
                            @if (substr($media->getMimeType(), 0, 5) == 'image')
                                <img width="200" src="{{ $media->temporaryUrl() }}">
                            @else
                                <video width="200" controls class="border">
                                    <source src="{{ $media->temporaryUrl() }}" type="video/mp4">
                                </video>
                            @endif
                        </div>
                    @elseif ($modelId)
                        <div class="z-depth-1-half mb-2">
                            <x-label for="media" value="{{ __('Media Preview') }}" />

                            @if ($thumb)
                                <img class="h-10 md:h-14 2xl:h-16"
                                    src="{{ Storage::disk('s3')->url('canadiantirecms/videothumbs/' . $thumb) }}">
                            @else
                                <img class="h-12 md:h-14 lg:h-16 2xl:h-24"
                                    src="{{ Storage::disk('s3')->url('canadiantirecms/ctMedia/' . $media) }}">
                            @endif

                        </div>
                    @endif
                </div>
                <div class="mb-4">
                    <div class="z-depth-1-half mb-2">
                        <x-label for="type_id" value="{{ __('File Type') }} 
                            " />
                        <div>

                            @if ($type_id == 1)
                                {{ 'Video' }}
                            @elseif ($type_id == 2)
                                {{ 'Image' }}
                            @else
                                {{ '' }}
                            @endif
                        </div>
                        <x-input id="type_id" type="hidden" class="mt-1 block w-full"
                            wire:model.debonce.800ms="type_id" />

                    </div>

                    <x-input-error for="type_id" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-label for="file_name" value="{{ __('File Name') }}" />

                    <x-input id="file_name" type="text" class="mt-1 block w-full"
                        wire:model.debonce.800ms="file_name" />
                    <x-input-error for="file_name" class="mt-2" />
                </div>
                <div class=" mt-4">
                    <x-label for="user_file_name" value="{{ __('Client File Name') }}" />
                    <x-input wire:model="user_file_name" id="user_file_name" type="text"
                        class="mt-1 block w-full" wire:model.debonce.800ms="user_file_name" />
                    <x-input-error for="user_file_name" class="mt-2" />
                </div>
                <div class=" mt-6">
                    <select id="cat_id" name="cat_id"
                        class="form-input border border-gray-300 rounded-md font-medium text-sm text-gray-700 "
                        wire:model.defer='cat_id'>
                        @if (!$cat_id)
                            <option value="" selected class=""> Select Category</option>
                            @foreach ($allCategories as $cat)
                                <option value="{{ $cat->id }}"> {{ $cat->name }}</option>
                            @endforeach
                        @else
                            @if ($modelId)
                                @foreach ($allCategories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ $cat->id == $cat_id ? 'selected="selected"' : '' }}>
                                        {{ $cat->name }}</option>
                                @endforeach
                            @endif
                        @endif
                    </select>
                </div>
                <div class=" mt-6">
                    <select id="cat_id2" name="cat_id2"
                        class="form-input border border-gray-300 rounded-md font-medium text-sm text-gray-700 "
                        wire:model.defer='cat_id2'>
                        @if (!$cat_id2)
                            <option value="" selected class=""> Select Category 2</option>
                            @foreach ($allCategories as $cat)
                                <option value="{{ $cat->id }}"> {{ $cat->name }}</option>
                            @endforeach
                        @else
                            @if ($modelId)
                                @foreach ($allCategories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ $cat->id == $cat_id2 ? 'selected="selected"' : '' }}>
                                        {{ $cat->name }}</option>
                                @endforeach
                            @endif
                        @endif
                    </select>
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

        {{-- preview media modal --}}
        <x-dialog-modal wire:model="mediaPreviewModal">
            <x-slot name="title">
                {{ __('View Media: ') }}{{ $this->user_file_name }}
            </x-slot>

            <x-slot name="content">
                <div class=" flex place-content-center sm:w-3/4 lg:auto mx-auto">
                    @if ($type_id == 2)
                        <img src="{{ Storage::disk('s3')->url('canadiantirecms/ctMedia/' . $media) }}">
                    @elseif ($type_id == 1)
                        <video width="800" controls class="border">
                            <source src="{{ Storage::disk('s3')->url('canadiantirecms/ctMedia/' . $media) }}"
                                type="video/mp4">
                        </video>
                    @endif
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('mediaPreviewModal')" wire:loading.attr="disabled">
                    {{ __('Close') }}
                </x-secondary-button>
            </x-slot>
        </x-dialog-modal>

        {{-- delete media modal --}}
        <x-dialog-modal wire:model="deleteMediaModal">
            <x-slot name="title">
                {{ __('Delete Media') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you want to delete this content? Once deleted, all of its resources and data will be permanently deleted.') }}
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('deleteMediaModal')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                    {{ __('Delete') }}
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>

    </div>
</div>
