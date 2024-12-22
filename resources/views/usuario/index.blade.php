@extends('layouts.usuario-template')
@section('title', 'Inicio')
@section('content')
    <section class="my-4">
        <div class="flex items-center gap-4 rounded-2xl border border-zinc-400 p-4 shadow-md dark:border-zinc-800">
            <img src="{{ asset('svg/tree.svg') }}" alt="Tree SVG" class="h-14 w-14 rounded-full object-cover">
            <h1 class="text-4xl font-bold uppercase text-zinc-800 dark:text-white">
                Proyecto asignado:
                <br>
                <span class="text-3xl text-primary">
                    {{ $user->scholarship->project->name }}
                </span>
            </h1>
        </div>
        <div class="mt-4 grid grid-cols-2 gap-4">
            <div class="mt-4 flex flex-col rounded-2xl border border-zinc-400 p-4 shadow-md dark:border-zinc-800">
                <div class="flex w-full items-center justify-center gap-2">
                    <x-icon icon="calendar" class="h-6 w-6 text-primary" />
                    <h2 class="text-2xl font-semibold text-primary">
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
                    @if ($reportes->count() > 0)
                    @else
                        <p
                            class="mt-4 rounded-2xl bg-red-100 p-4 text-center text-sm text-red-500 dark:bg-red-950 dark:bg-opacity-20 dark:text-red-500">
                            No se ha subido ningún reporte
                        </p>
                    @endif
                </div>
                <div class="mt-4 flex items-center justify-center gap-4">
                    <x-button type="a" href="#" typeButton="secondary" icon="eye" text="Ver reportes" />
                    <x-button type="a" href="#" icon="arrow-big-up" typeButton="primary" text="Subir reporte" />
                </div>
            </div>
            <div class="mt-4 flex h-max flex-col rounded-2xl border border-zinc-400 p-4 shadow-md dark:border-zinc-800">
                <div class="flex w-full items-center justify-center gap-2">
                    <x-icon icon="users" class="h-6 w-6 text-primary" />
                    <h2 class="text-2xl font-semibold text-primary">
                        Integrantes
                    </h2>
                </div>
                <div class="mt-4">
                    @if ($proyecto->scholarships->count() > 0)
                        <ul class="flex flex-col gap-4 px-4 pb-4">
                            @foreach ($proyecto->scholarships as $integrante)
                                <li
                                    class="flex items-center gap-2 rounded-2xl border border-zinc-400 p-2 dark:border-zinc-800">
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
