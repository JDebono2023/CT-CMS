<button
    {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-2 py-1 md:py-1 lg:py-0 bg-white border border-gray-300 rounded-md font-semibold font-body text-xs text-[#AB1C1C] uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
