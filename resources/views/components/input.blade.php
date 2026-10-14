@props([
    'type' => 'text',
    'placeholder' => null,
    'autocomplete' => null,
])

<input
    type="{{ $type }}"
    placeholder="{{ $placeholder }}"
    autocomplete="{{ $autocomplete }}"
    {{ $attributes->merge([
        'class' => 'w-full rounded-lg border px-3 py-2.5 text-sm outline-none focus:ring-1 transition'
    ]) }}
>
