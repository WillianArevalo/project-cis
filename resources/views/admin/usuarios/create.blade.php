@extends('layouts.admin-template')
@section('title', 'CIS | Nuevo usuario')
@section('content')
    <section class="p-4">
        @include('layouts.__partials.admin.header', ['title' => 'Nuevo usuario', 'icon' => 'user-plus'])
        <div class="mt-4">
            <form action="{{ Route('admin.usuarios.store') }}" method="POST">
                @csrf
                <div class="flex gap-4">
                    <div class="flex flex-[2] flex-col">
                        <x-input type="email" name="email" icon="email" label="Correo electrónico"
                            placeholder="example@example.com" />
                    </div>
                    <div class="flex flex-1 flex-col">
                        <x-input type="text" name="user" icon="user" label="Usuario"
                            placeholder="Ingresa el nombre del usuario" />
                    </div>
                </div>
                <div class="mt-4 flex gap-4">
                    <div class="flex flex-1 flex-col">
                        <x-input type="password" name="password" icon="lock" label="Contraseña"
                            placeholder="Editar la contraseña del usuario" />
                    </div>
                    <div class="flex flex-1 flex-col">
                        <x-input type="password" name="confirm-password" icon="" label="Confirmar contraseña"
                            placeholder="Confirmar la contraseña del usuario" />
                    </div>
                </div>
                <div class="mt-4 flex gap-4">
                    <div class="w-60">
                        <x-select label="Rol" :options="[
                            'admin' => 'Administrador',
                            'user' => 'Usuario',
                        ]" id="role" name="role" />
                    </div>
                </div>
                <div class="mt-4 flex items-center justify-center gap-4">
                    <x-button type="a" href="{{ Route('admin.usuarios.index') }}" text="Cancelar" icon="close"
                        typeButton="secondary" />
                    <x-button type="submit" text="Guardar" icon="save" typeButton="primary" />
                </div>
            </form>
        </div>
    </section>
@endsection
