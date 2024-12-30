@extends('layouts.admin-template')
@section('title', 'CIS | Reporte de ' . $report->month)
@section('content')
    <section class="my-4 px-4">
        <div class="flex flex-col items-start justify-center gap-2">
            <div class="flex w-full flex-col-reverse justify-between gap-y-4 sm:flex-row">
                <h1
                    class="flex items-center gap-2 text-lg font-bold uppercase text-zinc-800 dark:text-white sm:text-xl md:text-2xl lg:text-3xl">
                    Reporte de
                    {{ $report->month }}
                </h1>
                <x-button type="a" href="{{ Route('admin.reportes.index', $report->project->slug) }}"
                    typeButton="secondary" text="Regresar" icon="corner-down-left" />
            </div>
            <div class="flex items-center gap-2">
                <x-icon icon="folder" class="size-4 text-zinc-600 dark:text-zinc-300 sm:size-5 md:size-6" />
                <h2 class="font-plus text-sm font-bold text-zinc-600 dark:text-zinc-300 sm:text-base md:text-lg">
                    {{ $report->project->name }}
                </h2>
            </div>
        </div>
        <div class="mx-auto mt-4">
            <div>
                <h3 class="text-lg font-bold text-blue-500 dark:text-blue-500 sm:text-xl">
                    {{ $report->theme }}
                </h3>
                <div class="mt-2 flex justify-between">
                    <span class="flex items-center gap-2 text-sm text-zinc-700 dark:text-zinc-400">
                        <x-icon icon="user-group" class="size-4 text-zinc-700 dark:text-zinc-400" />
                        {{ $report->number_participants }} participantes
                    </span>
                    <span class="flex items-center gap-2 text-sm text-zinc-700 dark:text-zinc-400">
                        <x-icon icon="clock" class="size-4 text-zinc-700 dark:text-zinc-400" />
                        {{ $report->date->setTimezone('America/El_Salvador')->format('M d, Y') }}
                    </span>
                </div>
            </div>
            <p class="mt-4 w-full text-sm text-zinc-700 dark:text-zinc-400 sm:text-base lg:w-1/2">
                {{ $report->description }}
            </p>
            <p class="mt-4 w-full text-sm text-red-500 dark:text-red-500 sm:text-base lg:w-1/2">
                {{ $report->obstacles }}
            </p>
        </div>

        <div class="mt-4">
            <h3 class="mx-auto text-base font-bold uppercase text-zinc-800 dark:text-white sm:text-lg md:text-xl">
                Asistencia
            </h3>
            <div class="mt-2 flex flex-col flex-wrap gap-4">
                @foreach ($report->project->scholarships as $scholarship)
                    @php
                        $assisted = $report->assits->firstWhere('scholarship_id', $scholarship->id);
                    @endphp
                    <div class="flex items-center gap-2">
                        <img src="{{ Storage::url($scholarship->photo) }}" alt="User SVG"
                            class="size-10 rounded-full object-cover">
                        <div class="flex flex-col gap-1">
                            <span class="text-sm font-bold text-zinc-700 dark:text-zinc-400">
                                {{ $scholarship->name }}
                            </span>
                            @if ($assisted)
                                <span
                                    class="flex w-max items-center gap-1 rounded-full bg-green-100 px-2 py-1 text-xs text-green-500 dark:bg-green-950/30 dark:text-green-400">
                                    <x-icon icon="circle-check" class="size-4" />
                                    Asistió
                                </span>
                            @else
                                <span
                                    class="flex w-max items-center gap-1 rounded-full bg-red-100 px-2 py-1 text-xs text-red-500 dark:bg-red-950/30 dark:text-red-400">
                                    <x-icon icon="circle-x" class="size-4" />
                                    No asistió
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mt-4">
            <h3 class="text-base text-zinc-800 dark:text-white">
                Enviado por
            </h3>
            <div class="mt-2 flex items-center gap-2">
                <img src="{{ Storage::url($report->user->scholarship->photo) }}" alt="User SVG"
                    class="size-10 rounded-full object-cover">
                <div class="flex flex-col gap-1">
                    <span class="text-sm font-bold text-zinc-700 dark:text-zinc-400">
                        {{ $report->user->scholarship->name }}
                    </span>
                    <span class="flex items-center gap-2 text-xs text-zinc-700 dark:text-zinc-400">
                        <x-icon icon="clock" class="size-4 text-zinc-700 dark:text-zinc-400" />
                        {{ $report->created_at->setTimezone('America/El_Salvador')->format('M d, Y h:i:A') }}
                    </span>
                </div>
            </div>
        </div>
        <div class="mx-auto mt-6">
            <h3 class="mx-auto text-base font-bold uppercase text-zinc-800 dark:text-white sm:text-lg md:text-xl">
                Imágenes
            </h3>
            <div class="mt-2 flex flex-wrap gap-4">
                @foreach ($report->images as $image)
                    <div class="flex flex-wrap items-center justify-center gap-2">
                        <img src="{{ Storage::url($image->path) }}" alt="Imagen {{ $loop->index }}"
                            class="h-36 w-full rounded-lg object-cover hover:cursor-zoom-in" />
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
