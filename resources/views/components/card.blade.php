@props(['month', 'send', 'report', 'index', 'limitMonth'])

@php
    // Definimos el estilo base para los reportes enviados y pendientes.
    $valid = $send ? 'success' : 'danger';
    $style = [
        'success' =>
            'bg-green-100 text-green-500 dark:bg-green-950/30 dark:text-green-300 border-green-500 dark:border-green-900',
        'danger' => 'bg-red-100 text-red-500 dark:bg-red-950/30 dark:text-red-300 border-red-500 dark:border-red-900',
        'disabled' =>
            'bg-gray-100 text-gray-500 dark:bg-gray-950/30 dark:text-gray-300 border-gray-500 dark:border-gray-900',
    ];

    // Obtener el índice del mes actual.
    $monthIndex = array_search($month, [
        'enero',
        'febrero',
        'marzo',
        'abril',
        'mayo',
        'junio',
        'julio',
        'agosto',
        'septiembre',
        'octubre',
        'noviembre',
        'diciembre',
    ]);

    // Obtener el índice del mes límite.
    $limiteIndex = array_search($limitMonth, [
        'enero',
        'febrero',
        'marzo',
        'abril',
        'mayo',
        'junio',
        'julio',
        'agosto',
        'septiembre',
        'octubre',
        'noviembre',
        'diciembre',
    ]);

    // Si el mes es posterior al mes límite, aplicamos un estilo de "deshabilitado".
    $disabled = $monthIndex > $limiteIndex;

    // Determinamos si el mes está dentro del límite o si es posterior (y debe tener un estilo diferente).
    $cardStyle = $disabled ? 'disabled' : $valid; // Si el mes es posterior, usa el estilo 'disabled'.
@endphp

<div
    class="card {{ $style[$cardStyle] }} {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }} overflow-hidden rounded-xl border shadow-md">
    <div class="p-4 text-center">
        <h3 class="text-lg font-bold uppercase text-zinc-800 dark:text-white">
            {{ $month }}
        </h3>
    </div>
    <div class="{{ $style[$cardStyle] }} flex h-36 flex-col items-center justify-center gap-2 border-t p-4 text-center">
        @if ($send)
            <span
                class="flex items-center gap-2 rounded-full bg-green-100 px-2 py-1 text-sm text-green-500 dark:bg-green-950/30 dark:text-green-300">
                <x-icon icon="calendar-check" class="size-4 text-green-500" />
                Reporte enviado
            </span>
            <p class="text-sm text-zinc-800 dark:text-white">
                {{ $report->theme }}
            </p>
            <p class="text-sm text-zinc-800 dark:text-white">
                {{ $report->created_at->setTimezone('America/El_Salvador')->format('M d, Y h:i A') }}
            </p>
        @else
            @if ($disabled)
                <span
                    class="flex h-full w-full items-center justify-center gap-2 px-2 py-1 text-sm text-gray-500 dark:text-gray-300">
                    <x-icon icon="calendar-clock" class="size-4 text-gray-500" />
                    Reporte pendiente
                </span>
            @else
                <span
                    class="flex h-full w-full items-center justify-center gap-2 px-2 py-1 text-sm text-red-500 dark:text-red-300">
                    <x-icon icon="calendar-clock" class="size-4 text-red-500" />
                    Reporte pendiente
                </span>
            @endif
        @endif
    </div>
    <div class="{{ $style[$cardStyle] }} border-t p-4 text-center">
        @if ($send)
            <x-button type="a" href="{{ Route('reportes.show', ['mes' => $month]) }}" typeButton="success"
                text="Ver reporte" icon="eye" />
        @else
            @if ($disabled)
                <x-button type="button" typeButton="secondary" text="Enviar reporte" icon="send"
                    class="w-full cursor-not-allowed" />
            @else
                <x-button type="a" href="{{ Route('reportes.create', ['mes' => $month]) }}" typeButton="primary"
                    text="Enviar reporte" icon="send" :disabled="$disabled" />
            @endif
        @endif
    </div>
</div>
