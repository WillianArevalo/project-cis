@props([
    'type',
    'text',
    'icon',
    'typeButton',
    'class',
    'iconAlign' => 'left',
    'onlyIcon' => false,
    'size' => 'normal',
    'loading' => false, // Añadido para el estado de carga
])

@php
    // Definir las clases según el tamaño
    $sizes = [
        'small' => [
            'padding' => 'px-4 py-2',
            'text' => 'text-xs',
            'icon' => 'h-4 w-4',
        ],
        'normal' => [
            'padding' => 'px-5 py-2.5',
            'text' => 'text-sm',
            'icon' => 'h-5 w-5',
        ],
        'large' => [
            'padding' => 'px-6 py-3',
            'text' => 'text-lg',
            'icon' => 'h-6 w-6',
        ],
    ];

    // Establecer el padding dependiendo de si es solo ícono o no
    $padding = $onlyIcon ? 'p-2' : $sizes[$size]['padding'];

    // Clases base
    $baseClasses =
        'font-medium rounded-xl flex items-center justify-center gap-2 transition-colors transition duration-300 ' .
        $padding;

    // Tipos de botones
    $buttonTypes = [
        'primary' =>
            'bg-orange-500 text-white hover:bg-orange-600 dark:bg-orange-500 dark:text-white dark:hover:bg-orange-600',
        'secondary' =>
            'border text-zinc-600 hover:bg-zinc-100 border-zinc-400 dark:border-zinc-800 dark:text-white dark:hover:bg-zinc-900',
        'danger' =>
            'bg-red-50 border border border-red-500 text-red-500 hover:bg-red-100 dark:bg-red-950 dark:text-red-500 dark:hover:bg-opacity-30 dark:bg-opacity-10 dark:border-red-800',
        'warning' =>
            'bg-yellow-50 border border border-yellow-500 text-yellow-500 hover:bg-yellow-100 dark:bg-yellow-950 dark:text-yellow-500 dark:hover:bg-opacity-30 dark:bg-opacity-10 dark:border-yellow-800',
        'info' =>
            'bg-sky-50 border border border-sky-500 text-sky-500 hover:bg-sky-100 dark:bg-sky-950 dark:text-sky-500 dark:hover:bg-opacity-30 dark:bg-opacity-10 dark:border-sky-800',
        'success' =>
            'bg-emerald-50 border border border-emerald-500 text-emerald-500 hover:bg-emerald-100 dark:bg-emerald-950 dark:text-emerald-500 dark:hover:bg-opacity-30 dark:bg-opacity-10 dark:border-emerald-800',
        'default' =>
            'border text-zinc-600 hover:bg-zinc-100 border-zinc-400 dark:border-zinc-800 dark:text-white dark:hover:bg-zinc-900',
    ];

    // Clases finales para el botón
    $classes = $buttonTypes[$typeButton ?? 'default'] . ' ' . $baseClasses . ' ' . $class;

    // Estado de carga: cuando está cargando, añadimos opacidad
    $loadingClasses = $loading ? 'opacity-75 cursor-not-allowed' : '';
    $classes .= ' ' . $loadingClasses;
@endphp

@if ($type === 'a')
    <a href="{{ $attributes->get('href') }}" {{ $attributes->except('href') }} class="{{ $classes }}">
        @if ($loading)
            <!-- Spinner para estado de carga -->
            <x-icon icon="spinner" class="{{ $sizes[$size]['icon'] }} animate-spin text-white" />
        @else
            @if ($iconAlign === 'left' && !$onlyIcon)
                <x-icon :icon="$icon" class="{{ $sizes[$size]['icon'] }} text-current" />
            @endif
            @if (!$onlyIcon)
                <span class="{{ $sizes[$size]['text'] }}">{{ $text }}</span>
            @endif
            @if ($iconAlign === 'right' && !$onlyIcon)
                <x-icon :icon="$icon" class="{{ $sizes[$size]['icon'] }} text-current" />
            @endif
            @if ($onlyIcon)
                <x-icon :icon="$icon" class="{{ $sizes[$size]['icon'] }} text-current" />
            @endif
        @endif
    </a>
@else
    <button type="{{ $type }}" {{ $attributes }} class="{{ $classes }}"
        @if ($loading) disabled @endif>
        @if ($loading)
            <!-- Spinner para estado de carga -->
            <x-icon icon="spinner" class="{{ $sizes[$size]['icon'] }} animate-spin text-white" />
        @else
            @if ($iconAlign === 'left' && !$onlyIcon)
                <x-icon :icon="$icon" class="{{ $sizes[$size]['icon'] }} text-current" />
            @endif
            @if (!$onlyIcon)
                <span class="{{ $sizes[$size]['text'] }}">{{ $text }}</span>
            @endif
            @if ($iconAlign === 'right' && !$onlyIcon)
                <x-icon :icon="$icon" class="{{ $sizes[$size]['icon'] }} text-current" />
            @endif
            @if ($onlyIcon)
                <x-icon :icon="$icon" class="{{ $sizes[$size]['icon'] }} text-current" />
            @endif
        @endif
    </button>
@endif
