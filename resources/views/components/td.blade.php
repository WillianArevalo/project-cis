@props([
    'wrapper' => true,
])

<td {{ $attributes->merge(['class' => $wrapper ? 'px-4 py-3 text-nowrap ' : 'px-4 py-3']) }}>
    {{ $slot }}
</td>
