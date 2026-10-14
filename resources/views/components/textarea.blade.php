{{-- resources/views/components/textarea.blade.php --}}
@props([
    'rows' => 3,
    'placeholder' => null,
])

<textarea
    rows="{{ $rows }}"
    placeholder="{{ $placeholder }}"
    {{ $attributes->merge([
        'class' => 'w-full rounded-lg border outline-none focus:ring-1 transition'
    ]) }}
></textarea>
