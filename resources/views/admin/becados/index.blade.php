@extends('layouts.admin-template')
@section('title', 'CIS | Becados')
@section('content')
    <section class="p-4">
        @include('layouts.__partials.admin.header', [
            'title' => 'Becados' . ' (' . $becados->count() . ')',
            'icon' => 'school',
        ])
        <div class="mt-4 flex flex-col gap-4 sm:flex-row">
            <div class="flex-1">
                <x-input type="text" placeholder="Buscar becado" icon="search" id="inputSearchScholarships" />
            </div>
            <div class="flex-3">
                <x-button type="a" href="{{ Route('admin.becados.create') }}" icon="plus" typeButton="primary"
                    text="Nuevo becado" />
            </div>
        </div>
        <div class="mt-4">
            <x-table id="tableScholarships">
                <x-slot name="thead">
                    <x-tr>
                        <x-th>
                            Foto
                        </x-th>
                        <x-th>
                            Nombre
                        </x-th>
                        <x-th>
                            Institución
                        </x-th>
                        <x-th>
                            Nivel académico
                        </x-th>
                        <x-th>
                            Estudiando
                        </x-th>
                        <x-th>
                            Comunidad
                        </x-th>
                        <x-th last="true">
                            Acciones
                        </x-th>
                    </x-tr>
                </x-slot>
                <x-slot name="tbody">
                    @if ($becados->count() == 0)
                        <x-tr>
                            <x-td class="text-center" colspan="6">
                                No hay becados registrados
                            </x-td>
                        </x-tr>
                    @endif
                    @foreach ($becados as $becado)
                        <x-tr>
                            <x-td>
                                <img src="{{ Storage::url($becado->photo) }}" alt="{{ $becado->name }}"
                                    class="h-10 w-10 min-w-10 max-w-10 rounded-full object-cover">
                            </x-td>
                            <x-td>
                                <div class="flex flex-col gap-1">
                                    {{ $becado->name }}
                                    @if ($becado->user->role === 'becado')
                                        <span
                                            class="flex w-max items-center gap-1 rounded-full bg-green-200 px-2 py-1 text-xs font-medium text-green-700 dark:bg-green-950/30 dark:text-green-500">
                                            <x-icon icon="school" class="h-4 w-4" />
                                            Becado
                                        </span>
                                    @else
                                        <span
                                            class="flex w-max items-center gap-1 rounded-full bg-blue-200 px-2 py-1 text-xs font-medium text-blue-700 dark:bg-blue-950/30 dark:text-blue-500">
                                            <x-icon icon="user" class="h-4 w-4" />
                                            Administrador
                                        </span>
                                    @endif
                                </div>
                            </x-td>
                            <x-td>
                                {{ $becado->institution }}
                            </x-td>
                            <x-td>
                                {{ $becado->study_level }}
                            </x-td>
                            <x-td>
                                {{ $becado->academic_level }}
                            </x-td>
                            <x-td>
                                {{ $becado->community->name }}
                            </x-td>
                            <x-td>
                                <div class="flex gap-2">
                                    <x-button type="a" href="{{ Route('admin.becados.edit', $becado) }}"
                                        icon="pencil" onlyIcon typeButton="success" />
                                    <form action="{{ Route('admin.becados.destroy', $becado->id) }}" method="POST"
                                        id="formDeleteBecado-{{ $becado->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <x-button type="button" data-modal-target="deleteModal"
                                            data-modal-toggle="deleteModal" onlyIcon
                                            data-form="formDeleteBecado-{{ $becado->id }}" class="buttonDelete"
                                            icon="trash" typeButton="danger" />
                                    </form>
                                </div>
                            </x-td>
                        </x-tr>
                    @endforeach
                </x-slot>
            </x-table>
            {{ $becados->links('vendor.pagination.pagination-custom') }}
        </div>

        <x-delete-modal modalId="deleteModal" title="¿Estás seguro de eliminar el becado?"
            message="No podrás recuperar este registro" />

    </section>
@endsection
