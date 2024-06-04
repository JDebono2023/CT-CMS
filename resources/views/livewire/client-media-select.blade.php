<div class="">
    {{-- page header & search bar --}}
    <div class="relative ">
        <div class="static inset-x-0 top-0">

            <div
                class="h-26 sm:h-18 md:h-20 py-2 2xl:py-4 bg-gradient-to-b from-[#AB1C1C] to-[#DB2322]  sm:items-center text-white relative sm:grid sm:grid-cols-7 md:grid-cols-6 ">

                <div class="flex items-center sm:col-span-3 md:col-span-2 ">

                    <a href="{{ route('ctcategory') }}" class="pl-2 lg:pl-4 pr-2 md:pr-3">
                        <span class="material-symbols-outlined text-3xl sm:text-4xl">
                            arrow_circle_left
                        </span>
                    </a>

                    <h1 class=" text-lg md:text-xl lg:text-2xl font-bold text-white ">
                        {{ $category->name }}
                    </h1>

                </div>
                {{-- filters --}}

                <div
                    class="mt-4 md:mt-3 mb-2 sm:col-start-4 sm:col-span-2 md:col-start-4 md:col-span-1  grid grid-cols-2  lg:mr-4 pl-4 md:pl-0">
                    <button
                        class="self-center h-6  text-gray-700 border border-gray-400 shadow-md bg-white font-body text-xs uppercase rounded-md hover:bg-blue-2  active:bg-blue-3 focus:outline-none  transition ease-in-out duration-150  px-1 md:px-2 lg:px-3  py-1  lg:py-1 xl:px-2 leading-none tracking-wide sm:mr-2 md:mr-2 lg:mr-2"
                        wire:click="resetFilters">
                        {{ __('Reset') }}
                    </button>

                    <div class="sm:justify-self-end ml-2">
                        @foreach ($cTypeList as $info)
                            <label class="sm:flex sm:items-center ">
                                <x-checkbox wire:model="cMediaType" value="{{ $info->type_id }}"></x-checkbox>
                                <span class=" ml-1 md:ml-2 text-sm text-white">{{ $info->types->name }}</span>
                            </label>
                        @endforeach
                    </div>

                </div>
                {{-- search bar --}}

                <div class="flex w-full sm:col-start-6 md:col-start-5 col-span-2 sm:px-3">
                    <x-tni-search-circle-o
                        class="text-base h-8 text-gray-600 border border-gray-300 bg-white -mr-1 py-1 px-2 rounded-l-md z-10 " />

                    <x-input wire:model.debonce.800ms='searchTerm' type="text"
                        class="w-full md:w-5/6   h-8  text-gray-700" />
                    <x-input-error for="searchTerm" class="mt-2" />
                </div>

            </div>
        </div>
    </div>
    {{-- page content --}}
    <div class="p-4 xl:p-2 w-full text-gray-900 font-semibold ">
        <div class="px-3 xl:px-0 2xl:pb-8">
            <div class="mb-10 ">
                <div
                    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 2xl:grid-cols-5 grid-flow-row gap-3 lg:gap-1 xl:gap-2 ">

                    @if ($category->count())

                        {{-- {{ $images }} --}}
                        @foreach ($allMedia as $medias)
                            @foreach ($medias->category as $cat)
                                @if ($cat->id == $category->id)
                                    <div class="w-full ">

                                        <div class="bg-white border border-gray-400 grid grid-rows-3">
                                            <div class="grid grid-cols-2 row-span-2">
                                                @if ($medias->thumb)
                                                    <img class="h-16 md:h-14 lg:h-16 2xl:h-20 justify-self-center mt-1 border border-gray-100"
                                                        src="{{ Storage::disk('s3')->url('canadiantirecms/videothumbs/' . $medias->thumb) }}">
                                                @else
                                                    <img class="h-16 md:h-14 lg:h-16 2xl:h-20 justify-self-center mt-1 border border-gray-100"
                                                        src="{{ Storage::disk('s3')->url('canadiantirecms/ctMedia/' . $medias->media) }}">
                                                @endif
                                                <div>
                                                    <h2
                                                        class="font-bold mt-3 mr-2 lg:mx-2 lg:mt-1 xl:mt-3 text-wrap text-xs ">
                                                        {{ $medias->user_file_name }}
                                                    </h2>

                                                </div>

                                            </div>
                                            <div class="grid grid-cols-2 row-start-3 pt-1">
                                                <div class="justify-self-center">
                                                    <button
                                                        class=" h-5 px-2 md:px-3 xl:px-2 leading-none bg-blue-6 text-white rounded-xl md:rounded-full font-semibold uppercase tracking-wide text-xs  "
                                                        wire:click="mediaRequestModal({{ $medias->id }})">
                                                        {{ __('Select') }}
                                                    </button>
                                                </div>
                                                <div class="justify-self-center col-start-2 col-span-1">
                                                    <div class="flex items-center">
                                                        <div class="text-xs">View
                                                            {{ $medias->types->name }}
                                                        </div>
                                                        <button
                                                            class="material-symbols-outlined  px-1 text-lg  md:text-xl leading-4 font-medium text-gray-700 tracking-wider text-center  hover:text-gray-400 active:text-gray-900 transition ease-in-out duration-150"
                                                            wire:click="mediaPreviewModal({{ $medias->id }})">
                                                            play_circle
                                                        </button>
                                                    </div>

                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endforeach
                    @endif
                </div>
                <br />
                @if ($links->links())
                    {{ $links->links() }}
                @endif
            </div>
        </div>


        {{-- The Media Preview Modal --}}
        <x-dialog-modal wire:model="mediaPreviewModal">
            <x-slot name="title">
                {{ __('Content: ') }}{{ $this->user_file_name }}
            </x-slot>

            <x-slot name="content">
                <div class=" flex place-content-center ">
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
                <x-secondary-button wire:click="closePreview" wire:loading.attr="disabled">
                    {{ __('Close') }}
                </x-secondary-button>
            </x-slot>
        </x-dialog-modal>

        <x-selectcontent-modal wire:model="mediaRequestModal">

            <x-slot name="title">
                <div class="">
                    AD REQUEST ~ {{ $user_file_name }}</div>
            </x-slot>

            <x-slot name="content">
                <div class=" mx-4 mb-4 mt-4 divide-y-2 divide-gray-300 ">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-center">
                        <div class="">
                            @foreach ($allMedia as $media)
                                @if ($media->id == $modelId)
                                    @if ($media->thumb)
                                        <img class=""
                                            src="{{ Storage::disk('s3')->url('canadiantirecms/videothumbs/' . $media->thumb) }}">
                                    @else
                                        <img class=""
                                            src="{{ Storage::disk('s3')->url('canadiantirecms/ctMedia/' . $media->media) }}">
                                    @endif
                                @endif
                            @endforeach
                        </div>
                        <div class="text-sm text-left text-gray-900 mt-2 sm:ml-2">
                            {{-- <div class=" text-left text-gray-900 mb-3">Ad Details </div> --}}
                            {{-- user freindly file name --}}
                            <div class="">
                                <div class="">File Name: <span class="font-light">{{ $user_file_name }}</span>
                                </div>
                                <input id="user_file_name" type="hidden" class=""
                                    wire:model.debonce.800ms="user_file_name" />
                                <x-input-error for="user_file_name" class="mt-2" />

                            </div>
                            <div class="mt-4">
                                <div class="">Media Type: <span class="font-light">{{ $type_id }}</span>
                                </div>
                                <input id="type_id" type="hidden" class=""
                                    wire:model.debonce.800ms="type_id" />
                                <x-input-error for="type_id" class="mt-2" />

                            </div>

                            {{-- team/store name --}}
                            <div class="mt-4 ">
                                <div class="">Your Store: <span class="font-light">{{ $store_name }}</span>
                                </div>
                                <x-input id="store_name" type="hidden" class=""
                                    wire:model.debonce.800ms="store_name" />

                            </div>
                            {{-- category --}}
                            <div class="mt-4">
                                <div class="">Category: <span class="font-light">{{ $category->name }}</span>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="mt-6 text-sm ">
                        <div class="mb-4 mt-6  text-gray-900 flex flex-wrap  ">
                            <x-input id="confirm" wire:model.debonce.800ms='confirm' value="1" type="checkbox"
                                class="border-gray-500 mr-2 p-2.5 self-center " />{{ 'confirm' == 1 ? 'checked' : '' }}
                            <x-input-error for="confirm" class="mt-2" />
                            <div class="self-center">Ad approved. No edits required.</div>

                        </div>
                        @if ($confirm == 0)
                            <div class="my-4 text-gray-900 flex flex-wrap  ">
                                <x-input id="edits" wire:model.debonce.800ms='edits' value="1"
                                    type="checkbox"
                                    class="border-gray-500 mr-2 p-2.5 self-center" />{{ 'edits' == 1 ? 'checked' : '' }}
                                <x-input-error for="edits" class="mt-2" />
                                <div class="self-center">Edits Required</div>
                            </div>
                            @if ($edits == 1)
                                <div class=" mt-1 ">
                                    <textarea name="edit_text" rows="5" id="edit_text" wire:model.debonce.800ms='edit_text'
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        placeholder="Add edit request details here." style=""></textarea>
                                    <x-input-error for="edit_text" class="mt-2" />
                                </div>
                            @endif
                        @endif
                    </div>
                    <div class="my-6 text-sm">
                        <div class="mb-4 mt-4 text-gray-900">I would like this Ad to be live
                            on these dates:
                        </div>

                        <!-- start date -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 sm:gap-4 mb-4 mt-4">

                            <div class="">
                                <div class="font-light">Start Date: </div>
                                <x-datetime-picker wire:model="starts_at" class=" " />
                                <x-input-error for="starts_at" class="mt-2" />
                            </div>
                            <!-- end date -->
                            <div class="mt-4 sm:mt-0">

                                <div class="font-light">End Date: </div>
                                <x-datetime-picker wire:model="ends_at"
                                    class="border-gray-300 rounded-md shadow-sm w-full " />
                                <x-input-error for="ends_at" class="mt-2" />
                            </div>
                        </div>
                        @if ($ends_at == null)
                            <div class="mb-4 mt-4 text-gray-900 flex flex-wrap">
                                <x-input id="no_end" wire:model.debonce.800ms='no_end' value="1"
                                    type="checkbox"
                                    class="border-gray-500 mr-2 p-2.5 self-center" />{{ 'no_end' == 1 ? 'checked' : '' }}
                                <x-input-error for="no_end" class="mt-2" />

                                <div class="self-center">This ad has no end date.</div>
                            </div>
                        @endif
                        <div class="mb-4 mt-4 text-xs font-light italic">Notice: If this Ad needs to be
                            live today, please calls us at 519-913-3169.
                        </div>
                    </div>


                    {{-- internal file name --}}
                    <x-input id="file_name" type="hidden" class="" wire:model.debonce.800ms="file_name" />
                    {{-- internal store id --}}
                    <x-input id="store_id" type="hidden" class="" wire:model.debonce.800ms="store_id" />

                    {{-- device --}}
                    {{-- <div class="mb-4">
                                            <x-label for="device" value="{{ __('Device drop menu') }}" />
                                            <div class="">
                                                <select id="device" name="device"
                                                    class="form-input border border-gray-300 rounded-md font-medium text-sm text-gray-700 w-full "
                                                    wire:model.defer='device'>
                                                    <option value="" selected class="">
                                                        Select Device
                                                    </option>
                                                    <option value="Dev 1"> Device Name</option>
                                                    <option value="dev 2"> Device Name</option>
                                                    <option value="dev 3"> Device Name</option>
                                                </select>
                                            </div>
                                       </div> --}}
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="closeMediaRequest" wire:loading.attr="disabled" class="mr-2">
                    {{ __('Close') }}
                </x-secondary-button>

                @if (Auth::user()->teams->where('name', '=', 'Sales Team')->first())
                    {{-- sales team button -> does not send data --}}
                    <x-secondary-button wire:click="closeMediaRequest" wire:loading.attr="disabled">
                        {{ __('Send Request') }}
                    </x-secondary-button>
                @else
                    <x-secondary-button wire:click="createMessage" wire:loading.attr="disabled">
                        {{ __('Send Request') }}
                    </x-secondary-button>
                @endif

            </x-slot>
        </x-selectcontent-modal>


    </div>

</div>
