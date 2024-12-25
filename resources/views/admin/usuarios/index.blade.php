@extends('layouts.admin-template')
@section('title', 'CIS | Usuarios')
@section('content')
    <section class="p-4">
        @include('layouts.__partials.admin.header', ['title' => 'Usuarios', 'icon' => 'user'])
        <div class="mt-4 flex flex-col gap-4 sm:flex-row">
            <div class="flex-1">
                <x-input type="text" placeholder="Buscar usuario" icon="search" id="inputSearchUsers" />
            </div>
            <div class="flex-3">
                <x-button type="a" href="{{ Route('admin.usuarios.create') }}" icon="plus" typeButton="primary"
                    text="Nuevo usuario" />
            </div>
        </div>
        <div class="mt-4">
            <x-table id="tableUsers">
                <x-slot name="thead">
                    <x-tr>
                        <x-th class="w-5">
                            <x-icon icon="hash" class="h-4 w-4 text-white" />
                        </x-th>
                        <x-th>
                            Usuario
                        </x-th>
                        <x-th>
                            Correo electrónico
                        </x-th>
                        <x-th>
                            Rol
                        </x-th>
                        <x-th last="true">
                            Acciones
                        </x-th>
                    </x-tr>
                </x-slot>
                <x-slot name="tbody">
                    @if ($usuarios->count() == 0)
                        <x-tr>
                            <x-td class="text-center" colspan="5">
                                No hay usuarios registrados
                            </x-td>
                        </x-tr>
                    @endif
                    @foreach ($usuarios as $usuario)
                        <x-tr>
                            <x-td>
                                {{ $loop->iteration }}
                            </x-td>
                            <x-td>
                                {{ $usuario->user }}
                            </x-td>
                            <x-td>
                                {{ $usuario->email }}
                            </x-td>
                            <x-td>
                                <span
                                    class="w-max text-nowrap rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:bg-opacity-20 dark:text-blue-300">
                                    {{ $usuario->role === 'admin' ? 'Administrador' : 'Usuario' }}
                                </span>
                            </x-td>
                            <x-td last="true">
                                <div class="flex gap-2">
                                    <x-button type="a" href="{{ Route('admin.usuarios.edit', $usuario->id) }}"
                                        icon="pencil" onlyIcon typeButton="success" />
                                    <form action="{{ Route('admin.usuarios.destroy', $usuario->id) }}" method="POST"
                                        id="formDeleteUser-{{ $usuario->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <x-button type="button" data-modal-target="deleteModal"
                                            data-modal-toggle="deleteModal" onlyIcon
                                            data-form="formDeleteUser-{{ $usuario->id }}" class="buttonDelete"
                                            icon="trash" typeButton="danger" />
                                    </form>
                                </div>
                            </x-td>
                        </x-tr>
                    @endforeach
                </x-slot>
            </x-table>
            {{ $usuarios->links('vendor.pagination.pagination-custom') }}
        </div>
        <x-delete-modal modalId="deleteModal" title="¿Estás seguro de eliminar el usuario?"
            message="No podrás recuperar este registro" />
    </section>
@endsection
