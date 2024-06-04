<nav x-data="{ open: false }" class="bg-white border-b sm:border-0">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 ">
        <div class="flex justify-between h-24 sm:h-16 ">
            {{-- <div class="flex"> --}}
            <!-- Logo -->
            <div class="flex items-center flex-wrap ">
                <a href="{{ route('dashboard') }}">
                    <x-application-mark class="" />
                </a>
                <div class="sm:ml-4 md:ml-8 text-xl md:text-2xl font-bold ">
                    Digital Signage Ad Manager
                </div>
            </div>

            <!-- Navigation Links -->
            {{-- <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                @if (Auth::user()->teams->where('name', '=', 'EyeLook Administration')->first())
                    
                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('teams') }}" :active="request()->routeIs('teams')">
                        {{ __('Stores') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('all-users') }}" :active="request()->routeIs('all-users')">
                        {{ __('Users') }}
                    </x-nav-link>

                    <x-nav-link href="{{ route('categories') }}" :active="request()->routeIs('categories')">
                        {{ __('Categories') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('images') }}" :active="request()->routeIs('images')">
                        {{ __('Image Content') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('videos') }}" :active="request()->routeIs('videos')">
                        {{ __('Video Content') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('ctcategory') }}" :active="request()->routeIs('ctcategory')">
                        {{ __('Client View') }}
                    </x-nav-link>
                   
                @else
                    
                @endif

            </div> --}}

            <div class="hidden sm:items-center sm:ml-6 sm:flex justify-end">

                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    <x-dropdown align="right" width="60">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center justify-center p-2 rounded-md text-blue-8 hover:text-blue-3 hover:bg-blue-2 focus:outline-none transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path class="inline-flex" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />

                                </svg>
                            </button>

                        </x-slot>

                        <x-slot name="content">
                            @if (Auth::user()->teams->where('name', '=', 'EyeLook Administration')->first())
                                <div class="pt-2 space-y-1">
                                    <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                                        {{ __('Dashboard') }}
                                    </x-responsive-nav-link>
                                </div>
                                <x-responsive-nav-link href="{{ route('teams') }}" :active="request()->routeIs('teams')">
                                    {{ __('Stores') }}
                                </x-responsive-nav-link>
                                <x-responsive-nav-link href="{{ route('all-users') }}" :active="request()->routeIs('all-users')">
                                    {{ __('Users') }}
                                </x-responsive-nav-link>

                                <x-responsive-nav-link href="{{ route('categories') }}" :active="request()->routeIs('categories')">
                                    {{ __('Categories') }}
                                </x-responsive-nav-link>
                                {{-- <x-responsive-nav-link href="{{ route('images') }}" :active="request()->routeIs('images')">
                                    {{ __('Image Content') }}
                                </x-responsive-nav-link>
                                <x-responsive-nav-link href="{{ route('videos') }}" :active="request()->routeIs('videos')">
                                    {{ __('Video Content') }}
                                </x-responsive-nav-link> --}}
                                <x-responsive-nav-link href="{{ route('media') }}" :active="request()->routeIs('media')">
                                    {{ __('Media Content') }}
                                </x-responsive-nav-link>
                                <x-responsive-nav-link href="{{ route('ctcategory') }}" :active="request()->routeIs('ctcategory')">
                                    {{ __('Client View') }}
                                </x-responsive-nav-link>
                            @else
                                <x-responsive-nav-link href="{{ route('ctcategory') }}" :active="request()->routeIs('ctcategory')">
                                    {{ __('Categories') }}
                                </x-responsive-nav-link>
                            @endif

                            <!-- Settings Options -->
                            <div class="pt-2 rounded-md border-t border-gray-200">
                                {{-- <div class="flex items-center px-4">
                                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                        <div class="shrink-0 mr-3">
                                            <img class="h-10 w-10 rounded-full object-cover"
                                                src="{{ Auth::user()->profile_photo_url }}"
                                                alt="{{ Auth::user()->name }}" />
                                        </div>
                                    @endif

                                    <div>
                                        <div class="font-medium text-base text-blue-8">{{ Auth::user()->name }}
                                        </div>

                                    </div>
                                </div> --}}

                                <div class="space-y-1">
                                    <!-- Account Management -->
                                    <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                                        {{ __('Profile') }}
                                    </x-responsive-nav-link>

                                    <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}" x-data>
                                        @csrf

                                        <x-responsive-nav-link href="{{ route('logout') }}"
                                            @click.prevent="$root.submit();">
                                            {{ __('Log Out') }}
                                        </x-responsive-nav-link>
                                    </form>

                                </div>
                                <div class="pt-2 border-t rounded-md border-gray-200 text-blue-4">

                                    <div class="text-center  text-xs">Contact Technical Support
                                    </div>
                                    <div class="text-center text-xs">519-913-3169 ext. 206
                                    </div>
                                    <div class="text-center text-xs">support@eyelookmedia.com
                                    </div>

                                </div>

                                <div
                                    class="items-center flex justify-center bg-blue-8 text-xs text-white mt-2 pt-2 py-3 rounded-b-md">
                                    <a class="" href="http://www.eyelookmedia.com"><span
                                            class="hover:text-gray-400">www.eyelookmedia.com</span>
                                    </a>
                                </div>

                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden ">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-blue-8 hover:text-blue-3 hover:bg-blue-2 focus:outline-none focus:bg-blue-2 focus:text-blue-3 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            {{-- </div> --}}
        </div>
    </div>
    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden  border-gray-200 border-x sm:border-0 rounded-b-md">

        @if (Auth::user()->teams->where('name', '=', 'EyeLook Administration')->first())
            <div class="pb-3 space-y-1">
                <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            </div>
            <x-responsive-nav-link href="{{ route('teams') }}" :active="request()->routeIs('teams')">
                {{ __('Stores') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('all-users') }}" :active="request()->routeIs('all-users')">
                {{ __('Users') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link href="{{ route('categories') }}" :active="request()->routeIs('categories')">
                {{ __('Categories') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('media') }}" :active="request()->routeIs('media')">
                {{ __('Media Content') }}
            </x-responsive-nav-link>
            {{-- <x-responsive-nav-link href="{{ route('images') }}" :active="request()->routeIs('images')">
                {{ __('Image Content') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('videos') }}" :active="request()->routeIs('videos')">
                {{ __('Video Content') }}
            </x-responsive-nav-link> --}}
            <x-responsive-nav-link href="{{ route('ctcategory') }}" :active="request()->routeIs('ctcategory')">
                {{ __('Client View') }}
            </x-responsive-nav-link>
        @else
            <div class="pt-2 pb-3 space-y-1">
                <x-nav-link href="{{ route('ctcategory') }}" :active="request()->routeIs('ctcategory')">
                    {{ __('Categories') }}
                </x-nav-link>
            </div>
        @endif

        <!-- Responsive Settings Options -->
        <div class="pt-4 border-t border-gray-200">


            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>

            </div>

            <div class="pt-2 border-t rounded-md border-gray-200 text-blue-4">

                <div class="text-center  text-xs">Contact Technical Support
                </div>
                <div class="text-center text-xs">519-913-3169 ext. 206
                </div>
                <div class="text-center text-xs">support@eyelookmedia.com
                </div>

            </div>

            <div class="items-center flex justify-center bg-blue-8 text-xs text-white mt-2 pt-2 py-3 rounded-b-md">
                <a class="" href="http://www.eyelookmedia.com"><span
                        class="hover:text-gray-400">www.eyelookmedia.com</span>
                </a>
            </div>


        </div>
    </div>



</nav>
