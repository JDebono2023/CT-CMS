<div class="px-6 lg:px-8 bg-white pb-6  shadow shadow-gray-400">
    <div class="flex justify-center">
        <x-client-logo />
    </div>
    <h1 class="mb-6 text-2xl font-black text-blue-6 text-center">
        Welcome to the Admin Dashboard!
    </h1>
    {{-- {{ Auth::user()->allTeams() }} --}}
</div>

<div
    class=" bg-gray-600 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 lg:gap-4 p-6 lg:p-4 shadow shadow-gray-400 ">


    <div
        class="bg-white p-6 border border-blue-8 text-xl  grid grid-cols-4 content-center shadow shadow-gray-500 rounded">

        <div class="col-span-3  ">
            <h2 class="font-semibold text-base text-blue-6 md:text-xl border-b border-gray-500 pb-2 ">
                Store Manager
            </h2>
            <p class="mt-4 text-gray-600 text-sm md:text-base leading-relaxed">
                View, add new and manage store settings.
            </p>
        </div>
        <button class="col-span-1">
            <a href="{{ route('teams') }}">
                <span class="material-symbols-outlined  text-3xl text-blue-6">
                    move_item
                </span>
            </a>
        </button>

    </div>
    <div class="bg-white p-6 border border-gray-200 rounded text-xl  text-blue-8 grid grid-cols-4 content-center">
        <div class="col-span-3 ">
            <h2 class="font-semibold text-base text-blue-6 md:text-xl border-b border-gray-500 pb-2">
                User Manager
            </h2>
            <p class="mt-4 text-gray-600 text-sm md:text-base leading-relaxed">
                View and manage all users in the database.
            </p>
        </div>
        <button class="col-span-1">
            <a href="{{ route('all-users') }}">
                <span class="material-symbols-outlined text-blue-6 text-3xl">
                    move_item
                </span>
            </a>
        </button>
    </div>
    <div class="bg-white p-6 border border-gray-200 rounded text-xl  text-blue-2 grid grid-cols-4 content-center">
        <div class="col-span-3 ">
            <h2 class="font-semibold text-base text-blue-6 md:text-xl border-b border-gray-500 pb-2 ">
                Catagory Manager
            </h2>
            <p class="mt-4 text-gray-600 text-sm md:text-base leading-relaxed">
                View, add, edit and delete client categories.
            </p>
        </div>
        <button class="col-span-1">
            <a href="{{ route('categories') }}">
                <span class="material-symbols-outlined text-blue-6 text-3xl">
                    move_item
                </span>
            </a>
        </button>
    </div>
    <div class="bg-white p-6 border border-gray-200 rounded text-xl  text-blue-2 grid grid-cols-4 content-center">
        <div class="col-span-3 ">
            <h2 class="font-semibold text-base text-blue-6 md:text-xl border-b border-gray-500 pb-2 ">
                Media Content
            </h2>
            <p class="mt-4 text-gray-600 text-sm md:text-base leading-relaxed">
                View, add, edit and delete client media content.
            </p>
        </div>
        <button class="col-span-1">
            <a href="{{ route('media') }}">
                <span class="material-symbols-outlined text-blue-6 text-3xl">
                    move_item
                </span>
            </a>
        </button>
    </div>

    <div class="bg-white p-6 border border-gray-200 rounded text-xl  text-blue-2 grid grid-cols-4 content-center">
        <div class="col-span-3 ">
            <h2 class="font-semibold text-base text-blue-6 md:text-xl border-b border-gray-500 pb-2 ">
                Client View
            </h2>
            <p class="mt-4 text-gray-600 text-sm md:text-base leading-relaxed">
                View and interact with the client interface.
            </p>
        </div>
        <button class="col-span-1">
            <a href="{{ route('ctcategory') }}">
                <span class="material-symbols-outlined text-blue-6 text-3xl">
                    move_item
                </span>
            </a>
        </button>
    </div>


</div>
