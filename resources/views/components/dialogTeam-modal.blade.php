@props(['id' => null, 'maxWidth' => null])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>

    <h2 class="text-lg font-bold text-blue-6 px-6 py-4 bg-gray-100 text-left ">
        {{ $title }}
    </h2>
    <div class="px-6 py-4">
        <div class="mt-4 text-sm text-gray-600">
            {{ $content }}
        </div>
    </div>

    <div class="flex flex-row justify-end px-6 py-4 bg-gray-100 text-right">
        {{ $footer }}
    </div>
</x-modal>
