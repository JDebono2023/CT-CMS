<div class="px-6 lg:px-8 bg-white border-b border-gray-200">
    <div class="flex justify-center">
        <x-client-logo />
    </div>
    <h1 class="mb-6 text-2xl font-medium text-gray-900 text-center">
        Welcome to the Client Dashboard!
    </h1>
    {{-- {{ Auth::user()->allTeams() }} --}}
</div>

<div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 p-6 lg:p-8">



    <div
        class="bg-white p-6 border border-gray-200 sm:rounded-lg text-xl  text-gray-900 grid grid-cols-4 content-center">
        <div class="col-span-3 ">
            <h2 class="font-semibold text-base md:text-xl divide-solid">
                Catagory Menu
            </h2>
            <p class="mt-4 text-gray-500 text-sm md:text-base leading-relaxed">
                Access digital media content
            </p>
        </div>
        <button class="col-span-1">
            <a href="{{ route('ctcategory') }}">
                <span class="material-symbols-outlined text-gray-900 text-3xl">
                    move_item
                </span>
            </a>
        </button>
    </div>

    <div
        class="bg-white p-6 border border-gray-200 sm:rounded-lg text-xl  text-gray-900 grid grid-cols-4 content-center">
        <div class="col-span-3 ">
            <h2 class="font-semibold text-base md:text-xl divide-solid">
                Profile
            </h2>
            <p class="mt-4 text-gray-500 text-sm md:text-base leading-relaxed">
                View and manage your personal profile.
            </p>
        </div>
        <button class="col-span-1">
            <a href="{{ route('profile.show') }}">
                <span class="material-symbols-outlined text-gray-900 text-3xl">
                    move_item
                </span>
            </a>
        </button>
    </div>


</div>
