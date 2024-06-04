<x-app-layout>

    <div>

        @if (Auth::user()->teams->where('name', '=', 'EyeLook Administration')->first())
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="max-w-7xl bg-white mt-3 sm:mt-6 sm:max-md:pb-14 ">
                    <x-admindash />
                </div>

            </div>
        @else
            @livewire('client-category')
        @endif
    </div>

</x-app-layout>
