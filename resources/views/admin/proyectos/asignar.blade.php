@extends('layouts.admin-template')
@section('title', 'CIS | Asignar becados a proyecto')
@section('content')
    <section class="p-4">
        @include('layouts.__partials.admin.header', [
            'title' => '                Asignar becados a proyecto',
            'icon' => 'folder-symlink',
        ])
        <div class="mt-4">
            <h2 class="text-lg font-medium dark:text-zinc-200 sm:text-xl md:text-2xl">
                Proyecto: {{ $proyecto->name }}
            </h2>
        </div>
        <div class="mt-4 flex flex-col gap-4 lg:flex-row">
            <div class="flex-1">
                <h3 class="text-lg dark:text-zinc-400">
                    Representantes asignados
                </h3>
                <div class="mt-4 flex flex-col gap-4" id="assigned-scholars">
                    @if ($proyecto->scholarships->count() == 0)
                        <div class="no-assigned flex h-32 items-center justify-center">
                            <p class="text-sm dark:text-zinc-200">
                                No hay becados asignados
                            </p>
                        </div>
                    @else
                        @foreach ($proyecto->scholarships as $becado)
                            <div class="scholar-item flex w-full flex-col justify-between gap-4 rounded-2xl border border-zinc-400 p-4 dark:border-zinc-800 md:flex-row md:items-center"
                                data-id="{{ $becado->id }}">
                                <div class="flex items-center gap-4">
                                    <img src="{{ Storage::url($becado->photo) }}" alt="{{ $becado->name }}"
                                        class="h-12 w-12 rounded-full object-cover">
                                    <div class="flex-1">
                                        <h4 class="text-base dark:text-zinc-200">
                                            {{ $becado->name }}
                                        </h4>
                                        @if ($becado->project)
                                            <span
                                                class="mt-1 flex w-max items-center gap-1 rounded-full bg-blue-100 px-2 py-1 text-xs font-semibold text-blue-500 dark:bg-blue-950/30 dark:text-blue-500">
                                                <x-icon icon="folder" class="size-4" />
                                                {{ $becado->project->name }}
                                            </span>
                                        @else
                                            <span
                                                class="mt-1 w-max rounded-2xl px-3 py-0.5 text-xs font-medium dark:bg-red-950 dark:bg-opacity-30 dark:text-red-500">
                                                <x-icon icon="user-off" class="h-4 w-4" />
                                                Sin asignar
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex flex-col gap-4 sm:items-start md:items-center">
                                    <x-button type="button" size="small" icon="user-plus" text="Asignar"
                                        typeButton="primary" class="assign-button hidden" />
                                    <x-button type="button" size="small" icon="user-minus" text="Desasignar"
                                        typeButton="danger" class="unassign-button" />
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="flex-1">
                <h3 class="text-lg dark:text-zinc-400">
                    Lista de becados
                </h3>
                <x-input type="text" placeholder="Buscar becado" icon="search" class="mt-4" id="search" />
                <div class="mt-4 flex max-h-[450px] flex-col gap-4 overflow-y-auto overflow-x-hidden" id="scholar-list">
                    @if ($becados->count() > 0)
                        @foreach ($becados as $becado)
                            <div class="scholar-item flex w-full flex-col justify-between gap-4 rounded-2xl border border-zinc-400 p-4 dark:border-zinc-800 md:flex-row md:items-center"
                                data-id="{{ $becado->id }}">
                                <div class="flex items-center gap-4">
                                    <img src="{{ Storage::url($becado->photo) }}" alt="{{ $becado->name }}"
                                        class="h-12 w-12 rounded-full object-cover">
                                    <div class="flex-1">
                                        <h4 class="text-base dark:text-zinc-200">
                                            {{ $becado->name }}
                                        </h4>
                                        @if ($becado->project)
                                            <div class="flex flex-col justify-center gap-1">
                                                <span
                                                    class="mt-1 flex w-max items-center gap-1 rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-500 dark:bg-green-950/30 dark:text-green-500">
                                                    <x-icon icon="circle-check" class="size-4" />
                                                    Asignado
                                                </span>
                                                <span
                                                    class="mt-1 flex w-max items-center gap-1 rounded-full bg-blue-100 px-2 py-1 text-xs font-semibold text-blue-500 dark:bg-blue-950/30 dark:text-blue-500">
                                                    <x-icon icon="folder" class="size-4" />
                                                    {{ $becado->project->name }}
                                                </span>
                                            </div>
                                        @else
                                            <span
                                                class="mt-1 flex w-max items-center gap-1 rounded-full bg-red-100 px-2 py-1 text-xs font-semibold text-red-500 dark:bg-red-950/30 dark:text-red-500">
                                                <x-icon icon="circle-x" class="size-4" />
                                                Sin asignar
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex flex-col gap-4 sm:items-start md:items-center">
                                    <x-button type="button" size="small" icon="user-plus" text="Asignar"
                                        typeButton="primary" class="assign-button" />
                                    <x-button type="button" size="small" icon="user-minus" text="Desasignar"
                                        typeButton="danger" class="unassign-button hidden" />
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="mt-4">
            <form action="{{ Route('admin.proyectos.asignar.store', $proyecto->id) }}" method="POST"
                class="flex flex-col items-center justify-center gap-4" id="assign-form">
                @csrf
                <div id="scholarship-inputs"></div>
                @error('scholarship_id')
                    <small class="message-error mt-1 flex items-center gap-2 text-sm text-red-500 dark:text-red-400">
                        <x-icon icon="exclamation-circle" class="h-4 w-4 text-red-500 dark:text-red-400" />
                        Debes seleccionar al menos un becado para asignar al proyecto
                    </small>
                @enderror
                <div class="flex items-center justify-center gap-4">
                    <x-button type="a" href="{{ Route('admin.proyectos.index') }}" text="Regresar"
                        typeButton="secondary" icon="corner-down-left" />
                    <x-button type="button" text="Asignar becados" icon="user-check" typeButton="primary"
                        id="assign-button" />
                </div>
            </form>
        </div>
    </section>
@endsection
