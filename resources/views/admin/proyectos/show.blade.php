@extends('layouts.admin-template')
@section('title', 'CIS | Detalles del proyecto social')
@section('content')
    <section class="p-4">
        @include('layouts.__partials.admin.header', [
            'title' => 'Detalles del proyecto social',
            'icon' => 'folder',
        ])
        <div class="mt-4">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-semibold text-orange-500">
                    {{ $proyecto->name }}
                </h2>
                <div>
                    @if ($proyecto->accept == 1)
                        <span
                            class="flex w-max items-center gap-1 rounded-full bg-emerald-100 px-2 py-1 text-sm text-emerald-500 dark:bg-emerald-950/30 dark:text-emerald-400">
                            <x-icon icon="circle-check" class="size-4" />
                            Aceptado
                        </span>
                    @else
                        <span
                            class="flex w-max items-center gap-1 rounded-full bg-red-100 px-2 py-1 text-sm text-red-500 dark:bg-red-950/30 dark:text-red-400">
                            <x-icon icon="clock" class="size-4" />
                            Pendiente
                        </span>
                    @endif
                </div>
            </div>
            <p
                class="mt-2 flex w-max items-center gap-1 rounded-xl bg-orange-100 px-2 py-1 text-sm text-orange-500 dark:bg-orange-950/30">
                <x-icon icon="home" class="h-4 w-4" />
                {{ $proyecto->community->name }}
            </p>
            <div class="flex flex-col gap-4 md:flex-row">
                <div class="flex-1">
                    <div class="relative mt-8 h-max w-full rounded-xl border border-zinc-400 p-4 dark:border-zinc-800">
                        <h2
                            class="absolute -top-3.5 rounded-full bg-white px-2 text-lg font-semibold text-zinc-800 dark:bg-[#0a0a0a] dark:text-white">
                            Información general
                        </h2>
                        <div class="flex flex-col sm:flex-row">
                            <div class="flex flex-1 flex-col">
                                <div>
                                    <h3 class="text-base font-semibold text-zinc-600 dark:text-zinc-300">
                                        Población beneficiada
                                    </h3>
                                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                                        {{ $proyecto->benefited_population }}
                                    </p>
                                </div>
                                <div class="mt-4">
                                    <h3 class="text-base font-semibold text-zinc-600 dark:text-zinc-300">
                                        Contextualización
                                    </h3>
                                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                                        {{ $proyecto->contextualization }}
                                    </p>
                                </div>
                            </div>
                            <div class="mt-2 flex-1">
                                <div>
                                    <h3 class="text-base font-semibold text-zinc-600 dark:text-zinc-300">
                                        Proyecciones
                                    </h3>
                                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                                        {{ $proyecto->projections }}
                                    </p>
                                </div>
                                <div class="mt-4">
                                    <h3 class="text-base font-semibold text-zinc-600 dark:text-zinc-300">
                                        Desafíos
                                    </h3>
                                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                                        {{ $proyecto->challenges }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="relative mt-8 h-max w-full rounded-xl border border-zinc-400 p-4 dark:border-zinc-800">
                        <h2
                            class="absolute -top-3.5 rounded-full bg-white px-2 text-lg font-semibold text-zinc-800 dark:bg-[#0a0a0a] dark:text-white">
                            Justificación
                        </h2>
                        <div>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                {{ $proyecto->justification }}
                            </p>
                        </div>
                    </div>
                    <div class="relative mt-8 h-max w-full rounded-xl border border-zinc-400 p-4 dark:border-zinc-800">
                        <h2
                            class="absolute -top-3.5 rounded-full bg-white px-2 text-lg font-semibold text-zinc-800 dark:bg-[#0a0a0a] dark:text-white">
                            Descripción de actividades
                        </h2>
                        <div>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                {{ $proyecto->description_activities }}
                            </p>
                        </div>
                    </div>
                    <div class="relative mt-8 h-max w-full rounded-xl border border-zinc-400 p-4 dark:border-zinc-800">
                        <h2
                            class="absolute -top-3.5 rounded-full bg-white px-2 text-lg font-semibold text-zinc-800 dark:bg-[#0a0a0a] dark:text-white">
                            Cronograma
                        </h2>
                        <div class="mt-2">
                            <iframe src="{{ Storage::url($proyecto->schedule) }}" class="h-96 w-full rounded-md"></iframe>
                        </div>
                    </div>
                    <div class="relative mt-8 h-max w-full rounded-xl border border-zinc-400 p-4 dark:border-zinc-800">
                        <h2
                            class="absolute -top-3.5 rounded-full bg-white px-2 text-lg font-semibold text-zinc-800 dark:bg-[#0a0a0a] dark:text-white">
                            Enviado por
                        </h2>
                        <div class="mt-2">
                            <div class="flex items-center gap-4">
                                <div class="h-16 w-16 overflow-hidden rounded-full">
                                    <img src="{{ Storage::url($proyecto->sentBy->scholarship->photo) }}"
                                        alt="Foto de perfil" class="h-full w-full object-cover">
                                </div>
                                <div>
                                    <h3 class="text-base font-semibold text-zinc-600 dark:text-zinc-300">
                                        {{ $proyecto->sentBy->scholarship->name }}
                                    </h3>
                                    <p class="flex items-center gap-1 text-sm text-orange-500 dark:text-orange-500">
                                        <x-icon icon="email" class="h-4 w-4" />
                                        {{ $proyecto->sentBy->email }}
                                    </p>
                                    <p class="flex items-center gap-1 text-xs text-zinc-500 dark:text-zinc-400">
                                        <x-icon icon="clock" class="h-4 w-4" />
                                        {{ $proyecto->created_at->setTimezone('America/El_Salvador')->format('M d, Y h:i:A') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex-1">
                    <div class="relative mt-8 w-full rounded-xl border border-zinc-400 p-4 dark:border-zinc-800">
                        <h2
                            class="absolute -top-3.5 rounded-full bg-white px-2 text-lg font-semibold text-zinc-800 dark:bg-[#0a0a0a] dark:text-white">
                            Objetivos
                        </h2>
                        <div>
                            <h3 class="text-base font-semibold text-zinc-600 dark:text-zinc-300">
                                Objetivo general
                            </h3>
                            <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
                                {{ $proyecto->general_objective }}
                            </p>
                        </div>
                        <div class="mt-4">
                            <h3 class="text-base font-semibold text-zinc-600 dark:text-zinc-300">
                                Objetivos específicos
                            </h3>
                            <ul>
                                @foreach ($proyecto->specificObjetives as $objective)
                                    <li class="ms-4 mt-2 list-disc text-sm text-zinc-500 dark:text-zinc-400">
                                        {{ $objective->specific_objective }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="relative mt-8 w-full rounded-xl border border-zinc-400 p-4 dark:border-zinc-800">
                        <h2
                            class="absolute -top-3.5 rounded-full bg-white px-2 text-lg font-semibold text-zinc-800 dark:bg-[#0a0a0a] dark:text-white">
                            Mapa
                        </h2>
                        <div class="mt-2">
                            <img src="{{ Storage::url($proyecto->map) }}" alt="Mapa del proyecto"
                                class="h-96 w-full rounded-xl object-cover">
                        </div>
                        <div class="mt-4">
                            <h3 class="text-base font-semibold text-zinc-600 dark:text-zinc-300">
                                Localización
                            </h3>
                            <p class="flex items-center gap-1 text-sm text-zinc-500 dark:text-zinc-400">
                                <x-icon icon="map-pin" class="h-4 w-4" />
                                {{ $proyecto->community->name }}
                            </p>
                        </div>
                    </div>
                    <div class="relative mt-8 h-max w-full rounded-xl border border-zinc-400 p-4 dark:border-zinc-800">
                        <h2
                            class="absolute -top-3.5 rounded-full bg-white px-2 text-lg font-semibold text-zinc-800 dark:bg-[#0a0a0a] dark:text-white">
                            Documento
                        </h2>
                        <div class="mt-2">
                            <iframe src="{{ Storage::url($proyecto->document) }}" class="h-96 w-full rounded-md"></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-center">
                <x-button type="a" href="{{ route('admin.proyectos.index') }}" text="Regresar"
                    icon="corner-down-left" typeButton="secondary" />
            </div>
        </div>
    </section>
@endsection
