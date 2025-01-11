@extends('layouts.admin-template')
@section('title', 'CIS | Becados')
@section('content')
    <section class="p-4">
        @include('layouts.__partials.admin.header', [
            'title' => 'Preguntas',
            'icon' => 'question',
        ])
        <div class="mt-4 flex flex-col gap-4 sm:flex-row">
            <div class="flex-1">
                <x-input type="text" placeholder="Buscar pregunta" icon="search" id="inputSearchAsk" />
            </div>
            <div class="flex-3">
                <x-button type="button" icon="plus" typeButton="primary" text="Nueva pregunta"
                    data-drawer-target="drawer-right-example" data-drawer-show="drawer-right-example"
                    data-drawer-placement="right" aria-controls="drawer-right-example" />
            </div>
        </div>
        <div class="mt-4">
            <x-table id="tableAsks">
                <x-slot name="thead">
                    <x-tr>
                        <x-th>
                            #
                        </x-th>
                        <x-th>
                            Pregunta
                        </x-th>
                        <x-th>
                            Nivel
                        </x-th>
                        <x-th>
                            Máximo de caracteres
                        </x-th>
                        <x-th last="true">
                            Acciones
                        </x-th>
                    </x-tr>
                </x-slot>
                <x-slot name="tbody">
                    @if ($asks->count() > 0)
                        @foreach ($asks as $ask)
                            <x-tr>
                                <x-td>
                                    {{ $loop->iteration }}
                                </x-td>
                                <x-td>
                                    <div class="flex flex-col gap-2">
                                        {{ $ask->title }}
                                        <span class="text-wrap text-xs">
                                            {{ $ask->description }}
                                        </span>
                                    </div>
                                </x-td>
                                <x-td>
                                    {{ $ask->level }}
                                </x-td>
                                <x-td>
                                    {{ $ask->max_characters }}
                                </x-td>
                                <x-td>
                                    <div class="flex gap-2">
                                        <x-button type="a" href="{{ Route('admin.becados.edit', $ask->id) }}"
                                            icon="pencil" onlyIcon typeButton="success" />
                                        <form action="{{ Route('admin.becados.destroy', $ask->id) }}" method="POST"
                                            id="formDeleteBecado-{{ $ask->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <x-button type="button" data-modal-target="deleteModal"
                                                data-modal-toggle="deleteModal" onlyIcon
                                                data-form="formDeleteBecado-{{ $ask->id }}" class="buttonDelete"
                                                icon="trash" typeButton="danger" />
                                        </form>
                                    </div>
                                </x-td>
                            </x-tr>
                        @endforeach
                    @endif
                </x-slot>
            </x-table>
        </div>

        <x-delete-modal modalId="deleteModal" title="¿Estás seguro de eliminar el becado?"
            message="No podrás recuperar este registro" />

        <div id="drawer-right-example"
            class="fixed right-0 top-0 z-40 h-screen w-96 translate-x-full overflow-y-auto bg-white p-4 transition-transform dark:bg-zinc-950"
            tabindex="-1" aria-labelledby="drawer-right-label">
            <h5 id="drawer-right-label"
                class="mb-4 inline-flex items-center text-base font-semibold text-zinc-500 dark:text-zinc-400">Nueva
                pregunta
            </h5>
            <button type="button" data-drawer-hide="drawer-right-example" aria-controls="drawer-right-example"
                class="absolute end-2.5 top-2.5 inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-zinc-400 hover:bg-zinc-200 hover:text-zinc-900 dark:hover:bg-zinc-900 dark:hover:text-white">
                <x-icon icon="close" class="h-4 w-4" />
                <span class="sr-only">Close menu</span>
            </button>
            <div>
                <form action="{{ Route('admin.preguntas.store') }}" method="POST">
                    @csrf
                    <div>
                        <x-input type="text" placeholder="¿Pregunta?" name="title" icon="help-hexagon" label="Pregunta"
                            required />
                    </div>
                    <div class="mt-4">
                        <x-input type="textarea" placeholder="Descripción" name="description" label="Descripción"
                            required />
                    </div>
                    <div class="mt-4">
                        <x-select name="level" required id="level" label="Nivel" :options="[
                            'basica' => 'Básica',
                            'bachillerato' => 'Bachillerato',
                            'universidad' => 'Universidad',
                            'todos' => 'Todos',
                        ]" />
                    </div>
                    <div class="mt-4">
                        <x-input type="text" label="Máximo de caracteres" placeholder="#" icon="number"
                            name="max_characters" required />
                    </div>
                    <div class="mt-6 flex items-center justify-center gap-4">
                        <x-button type="button" text="Cancelar" typeButton="secondary" icon="close"
                            data-drawer-hide="drawer-right-example" aria-controls="drawer-right-example" />
                        <x-button type="submit" text="Guardar" icon="save" typeButton="primary" />
                    </div>
                </form>
            </div>
        </div>

    </section>
@endsection
