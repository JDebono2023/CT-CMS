<div class="sm:pb-8 md:max-lg:pb-16 lg:max-2xl:pb-10 sm:max-md:min-h-screen 2xl:pb-10">
    <div class="">

        <div class="">
            @foreach ($recent as $recent)
                <div class="relative border border-gray-500 h-26 ">
                    <a href='ctcatrecent/{{ $recent->id }}'>
                        <div class="w-full h-20  bg-gradient-to-b from-[#AB1C1C] to-[#DB2322] ">
                            <h2
                                class="absolute font-bold text-md sm:text-lg lg:text-xl text-center text-white top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 hover:underline">
                                {{ $recent->name }}</h2>
                        </div>

                    </a>

                </div>
            @endforeach



            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 grid-flow-row h-1/2 ">

                @if ($category->count())
                    @foreach ($category as $data)
                        <div class="relative border border-gray-500  ">
                            <img class="w-full hover:blur "
                                src="{{ Storage::disk('s3')->url('canadiantirecms/categoryimages/' . $data->image) }}">

                            <x-ct-button
                                class="absolute text-sm  lg:text-base xl:text-sm 2xl:text-base place-content-center text-red top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2  sm:mb-15 w-2/4 ">
                                <a href='ctcontent/{{ $data->id }}'
                                    class="hover:font-bold hover:text-xl p-2">{{ $data->name }}
                                </a>

                            </x-ct-button>

                            {{-- <a href='ctcatsingle/{{ $data->id }}'><img class="w-full hover:blur "
                                    src="{{ Storage::disk('s3')->url('canadiantirecms/categoryimages/' . $data->image) }}">
 <h2
                                    class="absolute font-bold text-md sm:text-lg lg:text-xl text-center text-white top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2  ">
                                    {{ $data->name }}
                                </h2>
</a> --}}

                        </div>
                    @endforeach
                @else
                    <p>No content available.</p>
                @endif


            </div>


        </div>


    </div>

</div>
