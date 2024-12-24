@extends('layouts.admin-template')
@section('title', 'Reporte')
@section('content')
    <section class="my-4 px-4">
        <div class="flex flex-col items-start justify-center gap-2">
            <div class="flex w-full justify-between">
                <h1 class="flex items-center gap-2 text-3xl font-bold uppercase text-zinc-800 dark:text-white">Reporte de
                    {{ $report->month }}
                </h1>
                <x-button type="a" href="{{ Route('admin.proyectos.reportes', $report->project->slug) }}"
                    typeButton="secondary" text="Regresar" icon="corner-down-left" />
            </div>
            <div class="flex items-center gap-2">
                <x-icon icon="folder" class="size-6 text-zinc-600 dark:text-zinc-300" />
                <h2 class="font-plus text-lg font-bold text-zinc-600 dark:text-zinc-300">
                    {{ $report->project->name }}
                </h2>
            </div>
        </div>
        <div class="mx-auto mt-4">
            <div>
                <h3 class="text-xl font-bold text-blue-500 dark:text-blue-500">
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
            <p class="mt-4 text-zinc-700 dark:text-zinc-400">
                {{ $report->description }}
            </p>
            <p class="mt-4 text-red-500 dark:text-red-500">
                {{ $report->obstacles }}
            </p>
        </div>
        <div class="mt-4">
            <h3 class="text-base text-zinc-800 dark:text-white">
                Enviado por
            </h3>
            <div class="mt-2 flex items-center gap-2">
                <img src="{{ Storage::url($report->user->scholarship->photo) }}" alt="User SVG"
                    class="h-8 w-8 rounded-full object-cover">
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
            <h3 class="mx-auto text-xl font-bold uppercase text-zinc-800 dark:text-white">
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
