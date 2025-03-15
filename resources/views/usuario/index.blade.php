@extends('layouts.usuario-template')
@section('title', 'CIS | Inicio')
@section('content')
    <section class="my-4">
        <div class="flex items-center gap-4 rounded-2xl border border-zinc-400 p-4 shadow-md dark:border-zinc-800">
            <img src="{{ asset('svg/tree.svg') }}" alt="Tree SVG" class="h-14 w-14 rounded-full object-cover">
            <h1 class="text-base font-bold uppercase text-zinc-800 dark:text-white sm:text-lg md:text-xl">
                Proyecto asignado:
                <br>
                <span class="bg-orange text-xl md:text-2xl">
                    {{ $user->scholarship->project->name }}
                </span>
            </h1>
        </div>
        <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
            <div class="mt-4 flex flex-col rounded-2xl border border-zinc-400 p-4 shadow-md dark:border-zinc-800">
                <div class="flex w-full items-center justify-center gap-2">
                    <x-icon icon="calendar" class="text- h-6 w-6 text-orange-500 dark:text-orange-600" />
                    <h2 class="text-2xl font-semibold text-orange-500 dark:text-orange-600">
                        Reportes mensuales
                    </h2>
                </div>
                <div class="mt-4">
                    <img src="{{ asset('svg/folders.svg') }}" alt="Report SVG" class="mx-auto h-72 w-72">
                </div>
                <div>
                    <p class="text-center text-zinc-800 dark:text-zinc-300">
                        Reporte del mes de {{ $mes }}:
                    </p>
                    @if ($monthReport)
                        <span
                            class="mt-4 flex flex-col items-start gap-2 rounded-2xl border border-dashed border-green-500 bg-green-100 p-4 dark:border-green-700 dark:bg-green-950/20">
                            <div class="flex items-center gap-1 text-sm text-green-500 dark:text-green-500">
                                <x-icon icon="circle-check" class="size-4 text-current" />
                                Reporte enviado
                            </div>
                            <div class="flex flex-col">
                                <h3 class="text-base font-semibold text-zinc-800 dark:text-zinc-100">
                                    {{ $monthReport->theme }}
                                </h3>
                                <p class="mt-1 flex items-center gap-1 text-xs text-zinc-800 dark:text-zinc-300">
                                    <x-icon icon="clock" class="h-4 w-4" />
                                    {{ $monthReport->created_at->setTimezone('America/El_Salvador')->format('M d, Y h:i A') }}
                                </p>
                            </div>
                        </span>
                    @else
                        <p
                            class="mt-4 flex items-center justify-center gap-2 rounded-2xl bg-red-100 p-4 text-center text-sm text-red-500 dark:bg-red-950 dark:bg-opacity-20 dark:text-red-500">
                            <x-icon icon="info-circle" class="h-6 w-6" />
                            No se ha subido ningún reporte
                        </p>
                    @endif
                </div>
                <div class="mt-4 flex flex-col items-center justify-center gap-4 sm:flex-row">
                    <x-button type="a" href="{{ Route('reportes.index') }}" typeButton="secondary" icon="eye"
                        text="Ver reportes" class="w-full sm:w-max" />
                    @if (!$monthReport)
                        <x-button type="a" href="{{ Route('reportes.create', ['mes' => $mes]) }}" icon="arrow-big-up"
                            typeButton="primary" text="Subir reporte" class="w-full sm:w-max" />
                    @endif
                </div>
            </div>
            <div class="mt-4 flex h-max flex-col rounded-2xl border border-zinc-400 p-4 shadow-md dark:border-zinc-800">
                <div class="flex w-full items-center justify-center gap-2">
                    <x-icon icon="users" class="h-6 w-6 text-orange-500 dark:text-orange-600" />
                    <h2 class="text-2xl font-semibold text-orange-500 dark:text-orange-600">
                        Integrantes
                    </h2>
                </div>
                <div class="mt-4">
                    @if ($proyecto->scholarships->count() > 0)
                        <ul class="flex flex-col gap-4 px-2 pb-2 sm:px-4 sm:pb-4">
                            @foreach ($proyecto->scholarships as $integrante)
                                <li
                                    class="flex items-center gap-2 rounded-2xl border border-dashed border-zinc-400 p-2 dark:border-zinc-800">
                                    <img src="{{ Storage::url($integrante->photo) }}" alt="User SVG"
                                        class="h-10 w-10 rounded-full object-cover">
                                    <div class="flex flex-col">
                                        <h3 class="text-base font-semibold text-zinc-800 dark:text-white">
                                            {{ $integrante->name }}
                                        </h3>
                                        <p class="text-sm text-zinc-800 dark:text-zinc-300">
                                            {{ $integrante->community->name }}
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
