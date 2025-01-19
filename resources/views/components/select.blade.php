<div class="w-full">
    @if (!empty($label))
        <label for="{{ $id }}"
            class="{{ $required ? "after:content-['*'] after:ml-0.5 after:text-red-500" : '' }} mb-1 block text-sm font-semibold text-zinc-600 dark:text-zinc-300">
            {{ ucfirst($label) }}
        </label>
    @endif
    <input type="hidden" id="{{ $id }}" name="{{ $name }}" value="{{ $value }}">
    <div class="relative">
        <div
            class="selected @error($name) is-invalid @enderror flex w-full items-center justify-between rounded-xl border border-zinc-400 bg-zinc-50 px-5 py-2.5 text-sm dark:border-zinc-800 dark:bg-transparent dark:text-white">
            <span class="itemSelected truncate" id="{{ $id }}_selected">
                {{ $selected && isset($options[$selected]) ? $options[$selected] : ($text ?: 'Seleccionar') }}
            </span>
            <x-icon icon="arrow-down"
                class="arrow-down-select arrow-down-select h-5 w-5 text-zinc-500 dark:text-white" />
        </div>
        <ul
            class="selectOptions {{ count($options) > 6 ? 'h-64 overflow-auto' : '' }} absolute z-10 mb-8 mt-2 hidden w-full rounded-xl border border-zinc-400 bg-white p-2 shadow-lg dark:border-zinc-800 dark:bg-zinc-950">
            @if (count($options) === 0)
                <li
                    class="itemOption pointer-events-none rounded-xl px-4 py-3 text-sm text-zinc-900 dark:text-white dark:hover:bg-zinc-900">
                    No hay opciones disponibles
                </li>
            @else
                @foreach ($options as $value => $label)
                    <li class="itemOption cursor-default truncate rounded-xl px-4 py-3 text-sm text-zinc-900 hover:bg-zinc-100 dark:text-white dark:hover:bg-zinc-900/50"
                        title="{{ $label }}" data-value="{{ $value }}"
                        data-input="#{{ $id }}">
                        {{ $label }}
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
    @error($name)
        <small class="message-error mt-1 flex items-center gap-2 text-sm text-red-500 dark:text-red-400">
            <x-icon icon="exclamation-circle" class="h-4 w-4 text-red-500 dark:text-red-400" />
            {{ $message }}
        </small>
    @enderror
</div>
