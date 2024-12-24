@props([
    'type' => 'text',
    'name',
    'id' => '',
    'label' => '',
    'checked' => false,
    'placeholder' => '',
    'value' => '',
    'class' => '',
    'required' => false,
    'icon' => '',
    'error' => true,
])

@php
    // Determinar la clase de error si existe
    $errorClass = $errors->has($name) ? 'is-invalid' : '';

    // Agregar a la clase del label si es requerido
    $labelClass = $required ? "after:content-['*'] after:ml-0.5 after:text-red-500" : '';

    // Construir clases dinámicas para el input
    $classes = collect([
        'bg-zinc-50 border border-zinc-400 text-zinc-900 text-sm rounded-xl  block w-full p-3 px-4  ',
        'focus:ring-4 focus:ring-zinc-200 focus:border-zinc-600',
        'dark:bg-zinc-950 dark:border-zinc-800 dark:placeholder-zinc-400 dark:text-white',
        'dark:focus:ring-zinc-950 dark:focus:border-zinc-500',
        'transition duration-300',
        $class,
        $errorClass,
    ])
        ->filter()
        ->join(' ');
@endphp

@if ($label && $type !== 'checkbox' && $type !== 'radio' && $type !== 'file')
    <label for="{{ $id }}"
        class="{{ $labelClass }} mb-2 block text-sm font-medium text-zinc-500 dark:text-zinc-300">
        {{ $label }}
    </label>
@endif

<div class="relative w-full">
    @if ($icon)
        <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3.5">
            <span class="font-medium text-zinc-500 dark:text-zinc-400">
                <x-icon icon="{{ $icon }}" class="h-5 w-5 text-current" />
            </span>
        </div>
    @endif

    @if ($type === 'textarea')
        <textarea id="{{ $id }}" {{ $attributes }} name="{{ $name }}" rows="8"
            class="{{ $classes }} {{ $icon ? 'ps-10' : '' }}" data-container=".error-{{ $name }}"
            placeholder="{{ $placeholder }}" @if ($required) required @endif>{{ $value }}</textarea>
    @elseif ($type === 'checkbox' || $type === 'radio')
        <input type="checkbox" value="{{ $value }}" name="{{ $name }}" id="{{ $id }}"
            {{ $attributes }} {{ $checked ? 'checked' : '' }}
            class="{{ $class }} focus:ring-primary-500 dark:focus:ring-primary-600 h-4 w-4 rounded border-2 border-zinc-400 bg-zinc-100 focus:ring-2 dark:border-zinc-800 dark:bg-zinc-950 dark:ring-offset-zinc-800"
            @if ($required) required @endif>
        <label for="{{ $id }}"
            class="{{ $labelClass }} ms-1 inline-block text-sm font-medium text-zinc-500 dark:text-zinc-300">
            {{ $label }}
        </label>
    @else
        <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}"
            data-container=".error-{{ $name }}" placeholder="{{ $placeholder }}"
            value="{{ $value ?? old($name) }}" class="{{ $classes }} {{ $icon ? 'ps-10' : '' }}"
            {{ $attributes }} @if ($required) required @endif>
    @endif
</div>

<span class="error-{{ $name }} mt-2 hidden items-center gap-1 text-sm text-red-500">
    <x-icon icon="exclamation-circle" class="h-4 w-4" />
    <span class="error-msg text-red-500">Este campo es obligatorio</span>
</span>

@if ($error === true)
    @error($name)
        <span class="text-sm text-red-500">{{ $message }}</span>
    @enderror
@endif
