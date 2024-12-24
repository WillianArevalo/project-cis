@extends('layouts.admin-template')
@section('title', 'Comunidades')
@section('content')
    <section class="p-4">
        <div class="flex items-center gap-2">
            <x-icon icon="home" class="h-8 w-8 text-white" />
            <h1 class="text-4xl font-bold text-white">
                Comunidades
            </h1>
        </div>
        <div class="mt-4 flex flex-col gap-4 sm:flex-row">
            <div class="flex-1">
                <x-input type="text" placeholder="Buscar comunidad" icon="search" id="inputSearchCommunities" />
            </div>
            <div class="flex-3">
                <x-button type="a" id="modalNewCommunityButton" data-modal-target="modalNewCommunity"
                    data-modal-toggle="modalNewCommunity" href="#" icon="plus" typeButton="primary"
                    text="Nueva comunidad" />
            </div>
        </div>
        <div class="mt-4">
            <x-table id="tableCommunities">
                <x-slot name="thead">
                    <x-tr>
                        <x-th class="w-10">
                            <input id="default-checkbox" type="checkbox" value=""
                                class="focus:ring-primary-500 dark:focus:ring-primary-600 h-4 w-4 rounded border-2 border-zinc-400 bg-blue-600 bg-zinc-100 focus:ring-2 dark:border-zinc-800 dark:bg-zinc-950 dark:ring-offset-zinc-800">
                        </x-th>
                        <x-th>Nombre</x-th>
                        <x-th last="true">Acciones</x-th>
                    </x-tr>
                </x-slot>
                <x-slot name="tbody">
                    @if ($comunidades->count() > 0)
                        @foreach ($comunidades as $comunidad)
                            <x-tr>
                                <x-td class="w-10">
                                    <input id="default-checkbox" type="checkbox" value=""
                                        class="focus:ring-primary-500 dark:focus:ring-primary-600 h-4 w-4 rounded border-2 border-zinc-400 bg-blue-600 bg-zinc-100 focus:ring-2 dark:border-zinc-800 dark:bg-zinc-950 dark:ring-offset-zinc-800">
                                </x-td>
                                <x-td>{{ $comunidad->name }}</x-td>
                                <x-td>
                                    <div class="flex gap-2">
                                        <x-button type="button"
                                            data-url="{{ Route('admin.comunidades.edit', $comunidad->id) }}"
                                            data-form="{{ Route('admin.comunidades.update', $comunidad->id) }}"
                                            class="editCommunity" data-modal-toggle="modalEditCommunity"
                                            data-modal-target="modalEditCommunity" icon="pencil" typeButton="success"
                                            text="Editar" />
                                        <form action="{{ Route('admin.comunidades.destroy', $comunidad->id) }}"
                                            method="POST" id="formDeleteComunidad-{{ $comunidad->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <x-button type="button" data-modal-target="deleteModal"
                                                data-modal-toggle="deleteModal"
                                                data-form="formDeleteComunidad-{{ $comunidad->id }}" class="buttonDelete"
                                                icon="trash" typeButton="danger" text="Eliminar" />
                                        </form>
                                    </div>
                                </x-td>
                            </x-tr>
                        @endforeach
                    @endif
                </x-slot>
            </x-table>
        </div>

        <x-delete-modal modalId="deleteModal" title="¿Estás seguro de eliminar la comunidad?"
            message="No podrás recuperar este registro" />

        <div id="modalNewCommunity" tabindex="-1" aria-hidden="true"
            class="fixed inset-0 z-50 hidden h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden bg-black bg-opacity-70">
            <div class="relative h-auto w-full max-w-md p-4">
                <!-- Modal content -->
                <div
                    class="relative animate-jump-in rounded-lg bg-white p-4 shadow animate-duration-300 dark:bg-zinc-950 sm:p-5">
                    <!-- Modal header -->
                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">
                            Nueva comunidad
                        </h3>
                        <button type="button"
                            class="ml-auto inline-flex items-center rounded-lg bg-transparent p-2 text-sm text-zinc-400 hover:bg-zinc-200 hover:text-zinc-900 dark:hover:bg-zinc-900 dark:hover:text-white"
                            data-modal-toggle="modalNewCommunity">
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
                    <form action="{{ Route('admin.comunidades.store') }}" method="POST">
                        @csrf
                        <div class="mt-4 flex flex-1 flex-col">
                            <x-input type="text" name="name" icon="home" placeholder="Nombre de la comunidad" />
                        </div>
                        <div class="mt-4 flex justify-end gap-4">
                            <x-button type="button" data-modal-toggle="modalNewCommunity" icon="close"
                                typeButton="secondary" text="Cancelar" />
                            <x-button type="submit" icon="save" typeButton="primary" text="Guardar" />
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="modalEditCommunity" tabindex="-1" aria-hidden="true"
            class="fixed inset-0 z-50 hidden h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden bg-black bg-opacity-70">
            <div class="relative h-auto w-full max-w-md p-4">
                <!-- Modal content -->
                <div
                    class="relative animate-jump-in rounded-lg bg-white p-4 shadow animate-duration-300 dark:bg-zinc-950 sm:p-5">
                    <!-- Modal header -->
                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">
                            Editar comunidad
                        </h3>
                        <button type="button"
                            class="ml-auto inline-flex items-center rounded-lg bg-transparent p-2 text-sm text-zinc-400 hover:bg-zinc-200 hover:text-zinc-900 dark:hover:bg-zinc-900 dark:hover:text-white"
                            data-modal-toggle="modalEditCommunity">
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
                    <form action="" id="formEditCommunity" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mt-4 flex flex-1 flex-col">
                            <x-input type="text" name="name" icon="home" id="name"
                                placeholder="Nombre de la comunidad" />
                        </div>
                        <div class="mt-4 flex justify-end gap-4">
                            <x-button type="button" data-modal-toggle="modalEditCommunity" icon="close"
                                typeButton="secondary" text="Cancelar" />
                            <x-button type="submit" icon="pencil" typeButton="primary" text="Editar" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
