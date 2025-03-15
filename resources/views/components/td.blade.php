@props([
    'wrapper' => true,
])

<td {{ $attributes->merge(['class' => $wrapper ? 'px-4 py-3 ' : 'px-4 py-3']) }}>
    {{ $slot }}
</td>
