@php
    $alertType = '';
    $icon = '';
    $bgColor = '';
    $textColor = '';
    $title = '';
    $message = '';

    if (Session::has('success_title') && Session::has('success_message')) {
        $alertType = 'success';
        $icon = 'circle-check'; // Icono para éxito
        $bgColor = 'bg-green-500';
        $textColor = 'text-green-500 dark:text-green-400';
        $title = Session::get('success_title');
        $message = Session::get('success_message');
    } elseif (Session::has('error_title') && Session::has('error_message')) {
        $alertType = 'error';
        $icon = 'exclamation-circle'; // Icono para error
        $bgColor = 'bg-red-500';
        $textColor = 'text-red-500 dark:text-red-400';
        $title = Session::get('error_title');
        $message = Session::get('error_message');
    } elseif (Session::has('warning_title') && Session::has('warning_message')) {
        $alertType = 'warning';
        $icon = 'info-circle'; // Icono para advertencia
        $bgColor = 'bg-yellow-500';
        $textColor = 'text-yellow-500 dark:text-yellow-400';
        $title = Session::get('warning_title');
        $message = Session::get('warning_message');
    }
@endphp

@if ($alertType)
    <div
        class="alert fixed right-10 top-10 z-[100] flex w-full max-w-sm animate-fade-left overflow-hidden rounded-lg bg-white shadow-md animate-duration-300 dark:bg-zinc-950">
        <div class="{{ $bgColor }} flex w-12 items-center justify-center">
            <x-icon icon="{{ $icon }}" class="size-6 min-w-6 max-w-6 text-white" />
        </div>
        <div class="-mx-3 px-4 py-2">
            <div class="mx-3 flex items-center justify-between">
                <div>
                    <span class="{{ $textColor }} text-sm font-semibold sm:text-base">
                        {{ $title }}
                    </span>
                    <p class="text-xs text-zinc-600 dark:text-zinc-200 sm:text-sm">
                        {{ $message }}
                    </p>
                </div>
                <x-button type="button" icon="close" typeButton="secondary" onlyIcon
                    class="alert-close {{ $textColor }} ms-4" size="small" />
            </div>
        </div>
    </div>
@endif
