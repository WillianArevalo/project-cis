@extends('layouts.admin-template')
@section('title', 'Proyectos')
@section('content')
    <section class="p-4">
        <div class="flex items-center gap-2">
            <x-icon icon="folders" class="h-8 w-8 text-white" />
            <h1 class="text-4xl font-bold text-white">
                Proyectos
            </h1>
        </div>
        <div class="mt-4 flex gap-4">
            <div class="flex-1">
                <x-input type="text" placeholder="Buscar proyecto" icon="search" id="inputSearchProjects" />
            </div>
            <div class="flex-3">
                <x-button type="a" id="modalNewProjectButton" data-modal-target="modalNewProject"
                    data-modal-toggle="modalNewProject" href="#" icon="folder-plus" typeButton="primary"
                    text="Nuevo proyecto" />
            </div>
        </div>
        <div class="mt-4">
            <x-table id="tableProjects">
                <x-slot name="thead">
                    <x-tr>
                        <x-th class="w-5">
                            <x-icon icon="hash" class="h-4 w-4 text-white" />
                        </x-th>
                        <x-th>
                            Nombre
                        </x-th>
                        <x-th>
                            Comunidad
                        </x-th>
                        <x-th>
                            Reporte del mes
                        </x-th>
                        <x-th>
                            Encargados
                        </x-th>
                        <x-th last="true">
                            Acciones
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
                                            $reportThisMonth = $proyecto->reports
                                                ->where('month', $currentMonth)
                                                ->first();
                                        @endphp
                                        @if ($reportThisMonth)
                                            <a href=""
                                                class="flex w-max items-center gap-1 rounded-full bg-emerald-100 px-2 py-1 text-xs text-emerald-500 dark:bg-emerald-950/30 dark:text-emerald-400">
                                                <x-icon icon="circle-check" class="h-4 w-4" />
                                                Ver reporte
                                            </a>
                                        @else
                                            <span
                                                class="flex w-max items-center gap-1 rounded-full bg-red-100 px-2 py-1 text-xs text-red-500 dark:bg-red-950/30 dark:text-red-400">
                                                <x-icon icon="info-circle" class="h-4 w-4" />
                                                Sin reporte
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
                                    <div class="flex -space-x-2 rtl:space-x-reverse">
                                        @if ($proyecto->scholarships->count() == 0)
                                            <span
                                                class="flex w-max items-center gap-1 rounded-full bg-red-100 px-2 py-1 text-xs text-red-500 dark:bg-red-950/30 dark:text-red-400">
                                                <x-icon icon="circle-x" class="h-4 w-4" />
                                                Sin asignar
                                            </span>
                                        @endif
                                        @foreach ($proyecto->scholarships as $user)
                                            <img src="{{ Storage::url($user->photo) }}" alt="{{ $user->name }}"
                                                class="h-8 w-8 rounded-full object-cover"
                                                data-tooltip-target="tooltip-user-{{ $user->id }}">
                                            <div id="tooltip-user-{{ $user->id }}" role="tooltip"
                                                class="tooltip invisible absolute z-10 inline-block rounded-lg bg-zinc-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition-opacity duration-300 dark:bg-zinc-900">
                                                {{ $user->name }}
                                                <div class="tooltip-arrow" data-popper-arrow></div>
                                            </div>
                                        @endforeach
                                    </div>
                                </x-td>
                                <x-td>
                                    <div class="flex gap-2">
                                        <x-button type="button" class="btnEditProject"
                                            data-url="{{ Route('admin.proyectos.edit', $proyecto->id) }}" icon="pencil"
                                            onlyIcon typeButton="success" data-modal-target="modalEditProject"
                                            data-action="{{ Route('admin.proyectos.update', $proyecto->id) }}"
                                            data-modal-toggle="modalEditProject" />
                                        <form action="{{ Route('admin.proyectos.destroy', $proyecto->id) }}" method="POST"
                                            id="proyecto-{{ $proyecto->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <x-button type="button" data-modal-target="deleteModal"
                                                data-modal-toggle="deleteModal" onlyIcon
                                                data-form="proyecto-{{ $proyecto->id }}" class="buttonDelete"
                                                icon="trash" typeButton="danger" />
                                        </form>
                                        <x-button type="a"
                                            href="{{ Route('admin.proyectos.asignar', $proyecto->slug) }}" icon="user-up"
                                            onlyIcon typeButton="secondary" />
                                        <x-button type="a"
                                            href="{{ Route('admin.proyectos.reportes', $proyecto->slug) }}" icon="report"
                                            onlyIcon typeButton="secondary" />
                                    </div>
                                </x-td>
                            </x-tr>
                        @endforeach
                    @endif
                </x-slot>
            </x-table>
        </div>

        <x-delete-modal modalId="deleteModal" title="¿Estás seguro de eliminar el proyecto?"
            message="No podrás recuperar este registro" />

        <div id="modalNewProject" tabindex="-1" aria-hidden="true"
            class="fixed inset-0 z-50 hidden h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden bg-black bg-opacity-70">
            <div class="relative h-auto w-full max-w-md p-4">
                <!-- Modal content -->
                <div
                    class="relative animate-jump-in rounded-lg bg-white p-4 shadow animate-duration-300 dark:bg-zinc-950 sm:p-5">
                    <!-- Modal header -->
                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">
                            Nuevo proyecto
                        </h3>
                        <button type="button"
                            class="ml-auto inline-flex items-center rounded-lg bg-transparent p-2 text-sm text-zinc-400 hover:bg-zinc-200 hover:text-zinc-900 dark:hover:bg-zinc-900 dark:hover:text-white"
                            data-modal-toggle="modalNewProject">
                            <svg aria-hidden="true" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <form action="{{ Route('admin.proyectos.store') }}" method="POST">
                        @csrf
                        <div class="mt-4 flex flex-1 flex-col">
                            <x-input type="text" name="name" icon="folder" label="Nombre"
                                placeholder="Nombre del proyecto" />
                        </div>
                        <div class="mt-4 flex flex-1 flex-col">
                            <x-select name="community_id" id="community_id" label="Comunidad" icon="home"
                                :options="$comunidades->pluck('name', 'id')->toArray()" />
                        </div>
                        <div class="mt-4 flex justify-end gap-4">
                            <x-button type="button" data-modal-toggle="modalNewProject" icon="close"
                                typeButton="secondary" text="Cancelar" />
                            <x-button type="submit" icon="save" typeButton="primary" text="Guardar" />
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="modalEditProject" tabindex="-1" aria-hidden="true"
            class="fixed inset-0 z-50 hidden h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden bg-black bg-opacity-70">
            <div class="relative h-auto w-full max-w-md p-4">
                <!-- Modal content -->
                <div
                    class="relative animate-jump-in rounded-lg bg-white p-4 shadow animate-duration-300 dark:bg-zinc-950 sm:p-5">
                    <!-- Modal header -->
                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">
                            Editar proyecto
                        </h3>
                        <button type="button"
                            class="ml-auto inline-flex items-center rounded-lg bg-transparent p-2 text-sm text-zinc-400 hover:bg-zinc-200 hover:text-zinc-900 dark:hover:bg-zinc-900 dark:hover:text-white"
                            data-modal-toggle="modalEditProject">
                            <svg aria-hidden="true" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <form id="formEditProject" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mt-4 flex flex-1 flex-col">
                            <x-input type="text" name="name" id="name" icon="folder" label="Nombre"
                                placeholder="Nombre del proyecto" />
                        </div>
                        <div class="mt-4 flex flex-1 flex-col">
                            <x-select name="community_id" id="community_id_edit" label="Comunidad" icon="home"
                                :options="$comunidades->pluck('name', 'id')->toArray()" />
                        </div>
                        <div class="mt-4 flex justify-end gap-4">
                            <x-button type="button" data-modal-toggle="modalEditProject" icon="close"
                                typeButton="secondary" text="Cancelar" />
                            <x-button type="submit" icon="pencil" typeButton="primary" text="Editar" />
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>
@endsection
