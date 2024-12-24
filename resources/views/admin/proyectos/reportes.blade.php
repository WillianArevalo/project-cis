@extends('layouts.admin-template')
@section('title', 'Proyectos')
@section('content')
    <section class="p-4">
        <div class="flex items-center gap-2">
            <x-icon icon="files" class="h-8 w-8 text-white" />
            <h1 class="text-4xl font-bold text-white">
                Reportes - {{ $proyecto->name }}
            </h1>
        </div>
        <div class="mt-4 flex gap-4">
            <div class="flex-1">
                <x-input type="text" placeholder="Buscar reporte" icon="search" id="inputSearchReports" />
            </div>
            <div class="flex-3">
                <x-button type="a" id="modalNewProjectButton" data-modal-target="modalNewProject"
                    data-modal-toggle="modalNewProject" href="#" icon="folder-plus" typeButton="primary"
                    text="Nuevo proyecto" />
            </div>
        </div>
        <div class="mt-4">
            <x-table id="tableReports">
                <x-slot name="thead">
                    <x-tr>
                        <x-th class="w-5">
                            <x-icon icon="hash" class="h-4 w-4 text-zinc-700 dark:text-zinc-300" />
                        </x-th>
                        <x-th>
                            Mes
                        </x-th>
                        <x-th>
                            Tema
                        </x-th>
                        <x-th>
                            Participantes
                        </x-th>
                        <x-th>
                            Enviado por
                        </x-th>
                        <x-th>
                            Fecha
                        </x-th>
                        <x-th last="true">
                            Acciones
                        </x-th>
                    </x-tr>
                </x-slot>
                <x-slot name="tbody">
                    @if ($reportes->count() > 0)
                        @foreach ($reportes as $reporte)
                            <x-tr>
                                <x-td>
                                    {{ $loop->iteration }}
                                </x-td>
                                <x-td>
                                    {{ ucfirst($reporte->month) }}
                                </x-td>
                                <x-td>
                                    {{ $reporte->theme }}
                                </x-td>
                                <x-td>
                                    {{ $reporte->number_participants }}
                                </x-td>
                                <x-td>
                                    <div class="mt-2 flex items-center gap-2">
                                        <img src="{{ Storage::url($reporte->user->scholarship->photo) }}" alt="User SVG"
                                            class="h-8 w-8 rounded-full object-cover">
                                        <div class="flex flex-col gap-1">
                                            <span class="text-sm font-medium text-zinc-700 dark:text-zinc-400">
                                                {{ $reporte->user->scholarship->name }}
                                            </span>
                                        </div>
                                    </div>
                                </x-td>
                                <x-td>
                                    <span class="flex items-center gap-1 text-xs text-zinc-700 dark:text-zinc-400">
                                        <x-icon icon="clock" class="size-4 text-zinc-700 dark:text-zinc-400" />
                                        {{ $reporte->created_at->setTimezone('America/El_Salvador')->format('M d, Y h:i:A') }}
                                    </span>
                                </x-td>
                                <x-td>
                                    <div class="flex gap-2">
                                        <form action="{{ Route('admin.proyectos.destroy', $reporte->id) }}" method="POST"
                                            id="proyecto-{{ $reporte->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <x-button type="button" data-modal-target="deleteModal"
                                                data-modal-toggle="deleteModal" onlyIcon
                                                data-form="proyecto-{{ $reporte->id }}" class="buttonDelete"
                                                icon="trash" typeButton="danger" />
                                        </form>
                                        <x-button type="a" href="{{ Route('admin.reporte.show', $reporte->id) }}"
                                            onlyIcon icon="eye" typeButton="secondary" />
                                    </div>
                                </x-td>
                            </x-tr>
                        @endforeach
                    @endif
                </x-slot>
            </x-table>
        </div>

        <x-delete-modal modalId="deleteModal" title="¿Estás seguro de eliminar el reporte?"
            message="No podrás recuperar este registro" />

    </section>
@endsection
