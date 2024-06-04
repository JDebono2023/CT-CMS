@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-blue-5']) }}>
    {{ $value ?? $slot }}
</label>
