@extends('layouts.admin-template')
@section('title', 'Nuevo becado')
@section('content')
    <section class="p-4">
        @include('layouts.__partials.admin.header', ['title' => 'Editar usuario', 'icon' => 'user-edit'])
        <div class="mt-4">
            <form action="{{ Route('admin.usuarios.update', $usuario->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="flex gap-4">
                    <div class="flex flex-[2] flex-col">
                        <x-input type="email" name="email" icon="email" label="Correo electrónico"
                            placeholder="example@example.com" value="{{ $usuario->email }}" />
                    </div>
                    <div class="flex flex-1 flex-col">
                        <x-input type="text" name="user" icon="user" label="Usuario"
                            placeholder="Ingresa el nombre del usuario" value="{{ $usuario->user }}" />
                    </div>
                </div>
                <div class="mt-4 flex gap-4">
                    <div class="flex flex-1 flex-col">
                        <x-input type="password" name="password" icon="lock" label="Contraseña"
                            placeholder="Ingresa la contraseña del usuario" />
                    </div>
                    <div class="flex flex-1 flex-col">
                        <x-input type="password" name="confirm-password" icon="" label="Confirmar contraseña"
                            placeholder="Confirma la contraseña del usuario" />
                    </div>
                </div>
                <div class="mt-4 flex gap-4">
                    <div class="w-60">
                        <x-select label="Rol" :options="[
                            'admin' => 'Administrador',
                            'user' => 'Usuario',
                        ]" id="role" name="role"
                            value="{{ $usuario->role }}" selected="{{ $usuario->role }}" />
                    </div>
                </div>
                <div class="mt-4 flex items-center justify-center gap-4">
                    <x-button type="a" href="{{ Route('admin.usuarios.index') }}" text="Cancelar" icon="close"
                        typeButton="secondary" />
                    <x-button type="submit" text="Editar" icon="pencil" typeButton="primary" />
                </div>
            </form>
        </div>
    </section>
@endsection
