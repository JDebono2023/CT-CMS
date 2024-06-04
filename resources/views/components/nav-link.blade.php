@props(['active'])

@php
    $classes = $active ?? false ? 'inline-flex items-center px-1 pt-1 border-b-2 border-blue-2 text-sm font-bold leading-5 text-blue-8 focus:outline-none focus:border-blue-8 transition duration-150 ease-in-out font-body' : 'font-body inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-blue-5 hover:text-blue-2 hover:border-blue-2 focus:outline-none focus:text-blue-2 focus:border-blue-2 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
