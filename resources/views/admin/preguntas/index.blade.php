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
                    data-drawer-target="drawer-new-question" data-drawer-show="drawer-new-question"
                    data-drawer-placement="right" aria-controls="drawer-new-question" />
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
                            Tipo
                        </x-th>
                        <x-th>
                            Máx. de caracteres
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
                                    <div class="flex w-[500px] flex-col gap-1">
                                        <p class="text-wrap font-semibold text-zinc-500 dark:text-zinc-400">
                                            {{ $ask->title }}
                                        </p>
                                        <span class="text-wrap text-xs">
                                            {{ $ask->description }}
                                        </span>
                                    </div>
                                </x-td>
                                <x-td>
                                    <div class="flex flex-wrap items-center gap-1">
                                        @foreach ($ask->levels as $level)
                                            <span
                                                class="rounded-full bg-zinc-100 px-2 py-1 text-xs text-zinc-500 dark:bg-zinc-900 dark:text-zinc-400">
                                                {{ $level->level }}
                                            </span>
                                        @endforeach
                                    </div>
                                </x-td>
                                <x-td>
                                    @if ($ask->levels->contains('type', 'new_entry'))
                                        <span
                                            class="flex items-center gap-1 rounded-full bg-green-100 px-2 py-1 text-xs text-green-500 dark:bg-green-900/30 dark:text-green-400">
                                            <x-icon icon="plus" class="h-4 w-4" />
                                            Nuevo ingreso
                                        </span>
                                    @else
                                        <span
                                            class="flex items-center gap-1 rounded-full bg-blue-100 px-2 py-1 text-xs text-blue-500 dark:bg-blue-950/30 dark:text-blue-400">
                                            <x-icon icon="clock" class="h-4 w-4" />
                                            Antiguo ingreso
                                        </span>
                                    @endif
                                </x-td>
                                <x-td>
                                    {{ $ask->max_characters }}
                                </x-td>
                                <x-td>
                                    <div class="flex gap-2">
                                        <x-button type="button" data-href="{{ Route('admin.preguntas.edit', $ask->id) }}"
                                            icon="pencil" onlyIcon typeButton="success" class="btn-edit-ask"
                                            data-drawer-target="drawer-edit-question"
                                            data-drawer-show="drawer-edit-question" data-drawer-placement="right"
                                            aria-controls="drawer-edit-question" />
                                        <form action="{{ Route('admin.preguntas.destroy', $ask->id) }}" method="POST"
                                            id="form-delete-ask-{{ $ask->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <x-button type="button" data-modal-target="deleteModal"
                                                data-modal-toggle="deleteModal" onlyIcon
                                                data-form="form-delete-ask-{{ $ask->id }}" class="buttonDelete"
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

        <div id="drawer-new-question"
            class="fixed right-0 top-0 z-40 h-screen w-[500px] translate-x-full overflow-y-auto bg-white p-4 transition-transform dark:bg-zinc-950"
            tabindex="-1" aria-labelledby="drawer-right-label">
            <h5 id="drawer-right-label"
                class="mb-4 inline-flex items-center text-base font-semibold text-zinc-500 dark:text-zinc-400">Nueva
                pregunta
            </h5>
            <button type="button" data-drawer-hide="drawer-new-question" aria-controls="drawer-new-question"
                class="absolute end-2.5 top-2.5 inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-zinc-400 hover:bg-zinc-200 hover:text-zinc-900 dark:hover:bg-zinc-900 dark:hover:text-white">
                <x-icon icon="close" class="h-4 w-4" />
                <span class="sr-only">Close menu</span>
            </button>
            <div>
                <form action="{{ Route('admin.preguntas.store') }}" method="POST">
                    @csrf
                    <x-input type="text" placeholder="¿Pregunta?" name="title" icon="help-hexagon" label="Pregunta"
                        required value="{{ old('title') }}" />
                    <x-input type="textarea" placeholder="Descripción" name="description" label="Descripción" required
                        className="mt-4" value="{{ old('description') }}" />
                    <div class="mt-4">
                        <label
                            class="block text-sm font-medium text-zinc-500 after:ml-0.5 after:text-red-500 after:content-['*'] dark:text-zinc-300">
                            Nivel
                        </label>
                        <div class="mt-2 flex flex-wrap items-center gap-4">
                            <x-input type="checkbox" label="Universidad" name="level[]" value="Universidad" />
                            <x-input type="checkbox" label="Educación Básica" name="level[]" value="Educación Básica" />
                            <x-input type="checkbox" label="Bachillerato Vocacional" name="level[]"
                                value="Bachillerato Vocacional" />
                            <x-input type="checkbox" label="Bachillerato General" name="level[]"
                                value="Bachillerato General" />
                            <x-input type="checkbox" label="Técnico Universitario u otro" name="level[]"
                                value="Técnico Universitario u otro" />
                        </div>
                    </div>
                    <div class="mt-4">
                        <label
                            class="block text-sm font-medium text-zinc-500 after:ml-0.5 after:text-red-500 after:content-['*'] dark:text-zinc-300">
                            Tipo
                        </label>
                        <div class="mt-4 flex flex-wrap items-center gap-4">
                            <x-input type="checkbox" label="Nuevo ingreso" name="type" value="new_entry" />
                            <x-input type="checkbox" label="Antiguo ingreso" name="type" value="old_entrance" />
                        </div>
                    </div>
                    <div class="mt-4">
                        <x-input type="text" label="Máximo de caracteres" placeholder="#" icon="number"
                            name="max_characters" required />
                    </div>
                    <div class="mt-6 flex items-center justify-center gap-4">
                        <x-button type="button" text="Cancelar" typeButton="secondary" icon="close"
                            data-drawer-hide="drawer-new-question" aria-controls="drawer-new-question" />
                        <x-button type="submit" text="Guardar" icon="save" typeButton="primary" />
                    </div>
                </form>
            </div>
        </div>

        <div id="drawer-edit-question"
            class="fixed right-0 top-0 z-40 h-screen w-[500px] translate-x-full overflow-y-auto bg-white p-4 transition-transform dark:bg-zinc-950"
            tabindex="-1" aria-labelledby="drawer-right-label">
            <h5 id="drawer-right-label"
                class="mb-4 inline-flex items-center text-base font-semibold text-zinc-500 dark:text-zinc-400">
                Editar pregunta
            </h5>
            <button type="button" data-drawer-hide="drawer-edit-question" aria-controls="drawer-edit-question"
                class="absolute end-2.5 top-2.5 inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-zinc-400 hover:bg-zinc-200 hover:text-zinc-900 dark:hover:bg-zinc-900 dark:hover:text-white">
                <x-icon icon="close" class="h-4 w-4" />
                <span class="sr-only">Close menu</span>
            </button>
            <div id="content-form-edit-question">

            </div>
        </div>
    </section>
@endsection
