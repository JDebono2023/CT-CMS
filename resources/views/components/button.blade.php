<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-blue-6 mx-3 border border-transparent rounded-md font-semibold font-body text-xs text-white uppercase tracking-widest shadow shadow-gray-800 hover:bg-blue-2 active:bg-blue-3 focus:outline-none  transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
{{-- <button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-blue-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow shadow-gray-800 hover:bg-blue-4 focus:bg-blue-4 active:bg-blue-3 focus:outline-none focus:ring-2 focus:ring-blue-4 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button> --}}
