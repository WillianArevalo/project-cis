@extends('layouts.admin-template')
@section('title', 'CIS | Dashboard')
@section('content')
    <section class="p-4">
        @include('layouts.__partials.admin.header', [
            'title' => 'Dashboard',
            'icon' => 'dashboard',
        ])
        <div class="mt-4 grid grid-cols-1 gap-4 lg:grid-cols-2 xl:grid-cols-3">
            <div class="h-full rounded-3xl border border-zinc-400 p-4 dark:border-zinc-800 dark:bg-zinc-950">
                <div class="flex items-center justify-center gap-2">
                    <span class="rounded-xl bg-orange-100 p-2 text-orange-500">
                        <x-icon icon="school" class="size-6 text-current" />
                    </span>
                    <h2 class="text-2xl font-bold text-black dark:text-white">
                        {{ $countBecados }}
                        Becados
                    </h2>
                </div>
                <div class="mt-6 p-4">
                    <img src="{{ asset('svg/scholarships.svg') }}" alt="becados" class="mx-auto h-60 w-full">
                </div>
                <div class="mt-6 flex items-center justify-center">
                    <x-button type="a" href="{{ route('admin.becados.index') }}" typeButton="primary"
                        text="Ver becados" icon="school" />
                </div>
            </div>
            <div class="rounded-3xl border border-zinc-400 p-4 dark:border-zinc-800 dark:bg-zinc-950">
                <div class="flex items-center justify-center gap-2">
                    <span class="rounded-xl bg-orange-100 p-2 text-orange-500">
                        <x-icon icon="folders" class="size-6 text-current" />
                    </span>
                    <h2 class="text-2xl font-bold text-black dark:text-white">
                        {{ $countProyectos }}
                        Proyectos
                    </h2>
                </div>
                <div class="mt-6 p-4">
                    <img src="{{ asset('svg/folders.svg') }}" alt="becados" class="mx-auto h-60 w-full">
                </div>
                <div class="mt-6 flex items-center justify-center">
                    <x-button type="a" href="{{ route('admin.proyectos.index') }}" typeButton="primary"
                        text="Ver proyectos sociales" icon="folders" />
                </div>
            </div>
            <div class="rounded-3xl border border-zinc-400 p-4 dark:border-zinc-800 dark:bg-zinc-950">
                <div class="flex items-center justify-center gap-2">
                    <span class="rounded-xl bg-orange-100 p-2 text-orange-500">
                        <x-icon icon="home" class="size-6 text-current" />
                    </span>
                    <h2 class="text-2xl font-bold text-black dark:text-white">
                        {{ $countComunidades }}
                        Comunidades
                    </h2>
                </div>
                <div class="mt-6 p-4">
                    <img src="{{ asset('svg/home.svg') }}" alt="becados" class="mx-auto h-60 w-full">
                </div>
                <div class="mt-6 flex items-center justify-center">
                    <x-button type="a" href="{{ route('admin.comunidades.index') }}" typeButton="primary"
                        text="Ver comunidades" icon="home" />
                </div>
            </div>
            <div class="rounded-3xl border border-zinc-400 p-4 dark:border-zinc-800 dark:bg-zinc-950">
                <div class="flex items-center justify-center gap-2">
                    <span class="rounded-xl bg-orange-100 p-2 text-orange-500">
                        <x-icon icon="users" class="size-6 text-current" />
                    </span>
                    <h2 class="text-2xl font-bold text-black dark:text-white">
                        {{ $countUsuarios }}
                        Usuarios
                    </h2>
                </div>
                <div class="mt-6 p-4">
                    <img src="{{ asset('svg/users.svg') }}" alt="becados" class="mx-auto h-60 w-full">
                </div>
                <div class="mt-6 flex items-center justify-center">
                    <x-button type="a" href="{{ route('admin.comunidades.index') }}" typeButton="primary"
                        text="Ver usuarios" icon="users" />
                </div>
            </div>
        </div>
        <div class="mt-4">
            <h2 class="text-lg font-bold text-zinc-800 dark:text-white sm:text-xl md:text-2xl">
                Proyectos completados este mes ({{ $mes }})
            </h2>
            <div class="mt-4 flex flex-col gap-2">
                <x-table id="tableProjects">
                    <x-slot name="thead">
                        <x-tr>
                            <x-th class="w-10">
                                <x-icon icon="hash" class="size-4" />
                            </x-th>
                            <x-th>
                                Proyecto
                            </x-th>
                            <x-th>
                                Comunidad
                            </x-th>
                            <x-th>
                                Reporte del mes
                            </x-th>
                            <x-th last="true" class="w-36">
                                Enviado por
                            </x-th>
                        </x-tr>
                    </x-slot>
                    <x-slot name="tbody">
                        @if ($proyectos->count() > 0)
                            @foreach ($proyectos as $proyecto)
                                <x-tr>
                                    <x-td>
                                        {{ $loop->iteration }}
                                    </x-td>
                                    <x-td>
                                        {{ $proyecto->name }}
                                    </x-td>
                                    <x-td>
                                        {{ $proyecto->community->name }}
                                    </x-td>
                                    <x-td>
                                        @if ($proyecto->reports->count() > 0)
                                            @php
                                                $reportThisMonth = $proyecto->reports->where('month', $mes)->first();
                                            @endphp
                                            @if ($reportThisMonth)
                                                <a href="{{ route('admin.reportes.show', $reportThisMonth->id) }}"
                                                    class="flex w-max items-center gap-1 rounded-full bg-emerald-100 px-2 py-1 text-xs text-emerald-500 dark:bg-emerald-950/30 dark:text-emerald-400">
                                                    <x-icon icon="circle-check" class="h-4 w-4" />
                                                    Reporte enviado
                                                </a>
                                            @else
                                                <span
                                                    class="flex w-max items-center gap-1 rounded-full bg-red-100 px-2 py-1 text-xs text-red-500 dark:bg-red-950/30 dark:text-red-400">
                                                    <x-icon icon="info-circle" class="h-4 w-4" />
                                                    Reporte pendiente
                                                </span>
                                            @endif
                                        @else
                                            <span
                                                class="flex w-max items-center gap-1 rounded-full bg-red-100 px-2 py-1 text-xs text-red-500 dark:bg-red-950/30 dark:text-red-400">
                                                <x-icon icon="info-circle" class="h-4 w-4" />
                                                No hay reportes
                                            </span>
                                        @endif
                                    </x-td>
                                    <x-td>
                                        @if ($proyecto->reports->count() > 0)
                                            @php
                                                $reportThisMonth = $proyecto->reports->where('month', $mes)->first();
                                            @endphp
                                            @if ($reportThisMonth)
                                                <div class="flex -space-x-2 rtl:space-x-reverse">
                                                    <img src="{{ Storage::url($reportThisMonth->user->scholarship->photo) }}"
                                                        alt="{{ $proyecto->sentBy->user }}"
                                                        class="h-8 w-8 rounded-full object-cover"
                                                        data-tooltip-target="tooltip-user-{{ $reportThisMonth->id }}">
                                                    <div id="tooltip-user-{{ $reportThisMonth->id }}" role="tooltip"
                                                        class="tooltip invisible absolute z-10 inline-block rounded-lg bg-zinc-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition-opacity duration-300 dark:bg-zinc-900">
                                                        {{ $reportThisMonth->user->scholarship->name }}
                                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    </x-td>
                                </x-tr>
                            @endforeach
                        @endif
                    </x-slot>
                </x-table>
            </div>
        </div>
    </section>
@endsection
