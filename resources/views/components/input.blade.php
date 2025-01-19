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
    'legend' => '',
    'className' => '',
    'readonly' => false,
    'accept' => '',
])

@php
    // Determinar la clase de error si existe
    $errorClass = $errors->has($name) ? 'is-invalid' : '';

    // Agregar a la clase del label si es requerido
    $labelClass = $required ? "after:content-['*'] after:ml-0.5 after:text-red-500" : '';

    // Construir clases dinámicas para el input
    $classes = collect([
        'bg-zinc-50 border border-zinc-400 text-zinc-900 text-sm rounded-xl block w-full p-2.5 px-5',
        'focus:ring-4 focus:ring-zinc-200 focus:border-zinc-600',
        'dark:bg-transparent dark:border-zinc-800 dark:placeholder-zinc-400 dark:text-white',
        'dark:focus:ring-zinc-950 dark:focus:border-zinc-500',
        'transition duration-300',
        $class,
        $errorClass,
    ])
        ->filter()
        ->join(' ');
@endphp

<div class="{{ $className }}">
    @if ($label && $type !== 'checkbox' && $type !== 'radio' && $type !== 'file')
        <div class="mb-1 flex flex-col gap-1">
            <label for="{{ $id }}"
                class="{{ $labelClass }} block text-sm font-semibold text-zinc-600 dark:text-zinc-300">
                {{ $label }}
            </label>
            @if ($legend ?? false)
                <span class="ms-1 text-xs text-zinc-500 dark:text-zinc-400">({{ $legend }})</span>
            @endif
        </div>
    @endif

    <div class="relative w-full">
        @if ($icon && $type !== 'file')
            <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3.5">
                <span class="font-medium text-zinc-500 dark:text-zinc-400">
                    <x-icon icon="{{ $icon }}" class="h-5 w-5 text-current" />
                </span>
            </div>
        @endif

        @if ($type === 'textarea')
            <textarea id="{{ $id }}" {{ $attributes }} name="{{ $name }}" rows="8"
                class="{{ $classes }} {{ $icon ? 'ps-10' : '' }}" data-container=".error-{{ $name }}"
                placeholder="{{ $placeholder }}" @if ($required) required @endif
                @if ($readonly) readonly @endif>{{ $value }}</textarea>
        @elseif($type === 'file')
            <div>
                <span
                    class="{{ $required ? 'after:content-["*"] after:text-red-500' : '' }} mb-1 block text-sm font-medium text-zinc-500 after:ml-0.5 dark:text-zinc-300">
                    {{ $label }}
                </span>
                <div
                    class="flex flex-col items-start justify-between overflow-hidden rounded-xl border border-dashed border-zinc-400 dark:border-zinc-800">
                    <div class="flex w-full justify-between">
                        <div class="flex items-center">
                            <label
                                class="flex cursor-pointer items-center gap-1 border-e border-dashed border-zinc-400 p-3 px-5 text-xs text-zinc-600 hover:bg-zinc-200/50 dark:border-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-900/50">
                                <input type="file" name="{{ $name }}e" id="input-{{ $id }}"
                                    class="input-doc hidden" accept="{{ $accept }}"
                                    data-name="#file-name-{{ $id }}" {{ $attributes }}
                                    data-button-remove="#remove-file-{{ $id }}" />
                                <x-icon icon="{{ $icon }}" class="h-4 w-4 text-zinc-600 dark:text-zinc-300" />
                                {{ $placeholder }}
                            </label>
                            <p id="file-name-{{ $id }}"
                                class="font-dine-r px-5 text-[10px] text-zinc-600 dark:text-zinc-300">
                                Formatos permitidos: {{ $accept ?? '' }}
                            </p>
                        </div>
                        <button class="remove-file hidden pe-2" id="remove-file-{{ $id }}" type="button"
                            data-input="#input-{{ $id }}">
                            <x-icon icon="close" class="h-4 w-4 text-red-500" />
                        </button>
                    </div>
                </div>
            </div>
        @elseif ($type === 'checkbox' || $type === 'radio')
            <div class="flex items-center gap-1">
                <input type="checkbox" value="{{ $value }}" name="{{ $name }}"
                    id="{{ $id }}" {{ $attributes }} {{ $checked ? 'checked' : '' }}
                    class="{{ $class }} h-4 w-4 rounded border-2 border-zinc-400 bg-zinc-100 text-orange-500 focus:ring-2 focus:ring-orange-500 dark:border-zinc-800 dark:bg-zinc-950 dark:ring-offset-zinc-800 dark:focus:ring-orange-600"
                    @if ($required) required @endif>
                <label for="{{ $id }}"
                    class="{{ $labelClass }} ms-1 inline-block text-sm font-medium text-zinc-500 dark:text-zinc-300">
                    {{ $label }}
                    @if ($legend ?? false)
                        <span class="text-xs text-zinc-400 dark:text-zinc-500">({{ $legend }})</span>
                    @endif
                </label>
            </div>
        @elseif ($type === 'password')
            <div class="relative w-full">
                @if ($icon)
                    <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3.5">
                        <span class="font-medium text-zinc-500 dark:text-zinc-400">
                            <x-icon icon="{{ $icon }}" class="h-5 w-5 text-current" />
                        </span>
                    </div>
                @endif

                <input type="password" name="{{ $name }}" id="{{ $id }}"
                    data-container=".error-{{ $name }}" placeholder="{{ $placeholder }}"
                    value="{{ $value ?? old($name) }}" class="{{ $classes }} {{ $icon ? 'ps-10' : '' }} pe-10"
                    {{ $attributes }} @if ($required) required @endif>

                <button type="button"
                    class="toggle-password absolute inset-y-0 end-0 flex items-center pe-3 text-zinc-500 dark:text-zinc-400">
                    <span id="eye-icon">
                        <x-icon icon="eye" class="h-5 w-5 text-current" />
                    </span>
                    <span id="eye-closed-icon" class="hidden">
                        <x-icon icon="eye-closed" class="h-5 w-5 text-current" />
                    </span>
                </button>
            </div>
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
            <span class="mt-1 flex items-center gap-1 text-sm text-red-500">
                <x-icon icon="exclamation-circle" class="h-4 w-4" />
                <span class="error-msg text-red-500">
                    {{ $message }}
                </span>
            </span>
        @enderror
    @endif
</div>
