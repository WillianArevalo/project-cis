@props(['month', 'send', 'reports', 'index', 'limitMonth'])

@php
    $valid = $send ? 'success' : 'danger';
    $style = [
        'success' =>
            'bg-green-100 text-green-500 dark:bg-green-950/30 dark:text-green-300 border-green-500 dark:border-green-900',
        'danger' => 'bg-red-100 text-red-500 dark:bg-red-950/30 dark:text-red-300 border-red-500 dark:border-red-900',
        'disabled' =>
            'bg-gray-100 text-gray-500 dark:bg-gray-950/30 dark:text-gray-300 border-gray-500 dark:border-gray-900',
    ];

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

    $disabled = $monthIndex > $limiteIndex;
    $cardStyle = $disabled ? 'disabled' : $valid;

    $reportCount = count($reports);
@endphp
<div
    class="card {{ $style[$cardStyle] }} {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }} overflow-hidden rounded-xl border shadow-md">
    <div class="p-4 text-center">
        <h3 class="text-lg font-bold uppercase text-zinc-800 dark:text-white">
            {{ $month }}
        </h3>
    </div>
    <div class="{{ $style[$cardStyle] }} flex h-32 flex-col items-center justify-center gap-4 border-t p-4 text-center">
        @if ($send)
            <div class="flex flex-col items-center gap-2">
                <span
                    class="flex items-center gap-1 rounded-full bg-green-100 px-2 py-1 text-sm text-green-500 dark:bg-green-950/30 dark:text-green-300">
                    <x-icon icon="circle-check" class="size-4 text-green-500" />
                    {{ $reportCount }} reporte{{ $reportCount > 1 ? 's' : '' }}
                    enviado{{ $reportCount > 1 ? 's' : '' }}
                </span>
                <ul class="list-none text-left text-sm text-zinc-800 dark:text-zinc-300">
                    @foreach ($reports as $report)
                        <li class="mt-1 flex items-center gap-1 text-xs">
                            <x-icon icon="calendar" class="size-4 text-zinc-500 dark:text-zinc-300" />
                            {{ $report->created_at->locale('es')->setTimeZone('America/El_Salvador')->translatedFormat('d \d\e F \d\e Y h:i A') }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            @if ($disabled)
                <span
                    class="flex h-full w-full items-center justify-center gap-2 px-2 py-1 text-xs text-gray-500 dark:text-gray-300">
                    Todavía no puedes enviar reportes para este mes
                </span>
            @else
                <span
                    class="flex h-full w-full items-center justify-center gap-2 px-2 py-1 text-sm text-red-500 dark:text-red-300">
                    <x-icon icon="calendar-clock" class="size-4 text-red-500" />
                    Reportes pendientes
                </span>
            @endif
        @endif
    </div>
    <div class="{{ $style[$cardStyle] }} border-t p-4 text-center">
        @if ($disabled)
            <x-button type="button" typeButton="secondary" text="Enviar reporte" icon="send"
                class="w-full cursor-not-allowed" />
        @else
            <x-button type="a" href="{{ Route('reportes.create', ['mes' => $month]) }}" typeButton="primary"
                text="Enviar reporte" icon="send" :disabled="$disabled" />
        @endif
    </div>
</div>
