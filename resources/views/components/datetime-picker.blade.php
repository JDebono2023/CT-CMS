@props([
    'options' =>
        "{dateFormat:'Y-m-d', altFormat:'F j, Y ', altInput:true, minDate: new Date().fp_incr(1), defaultDate: null, }",
])

<div wire:ignore>
    {{-- <input x-data=" flatpickr($refs.input, {{ $options }})" x-ref="input" type="text" data-input {{ $attributes }} /> --}}
    {{-- <input x-data="{ value: @entangle($attributes->wire('model')), instance: undefined }" x-init="() => {
        $watch('value', value => instance.setDate(value, true))
        instance = flatpickr($refs.input, {{ $options }});
    }" x-ref="input" type="text" data-input {{ $attributes }} /> --}}

    <input x-data=" flatpickr($refs.input, {{ $options }})" x-ref="input" type="text" data-input placeholder="Select Date"
        class="text-grey-600 text-sm xl:text-xs text-gray-900 bg-white border-gray-400 rounded shadow-sm w-full"
        {{ $attributes }} />

</div>
