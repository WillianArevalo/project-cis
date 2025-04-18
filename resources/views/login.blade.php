@extends('layouts.template')
@section('title', 'CIS | Iniciar sesión')
@section('content')
    <section>
        <div class="container mx-auto flex min-h-screen items-center justify-center px-6">
            <form action="{{ Route('login.validate') }}" class="w-full max-w-sm" method="POST">
                @csrf
                <img class="mx-auto size-14 w-auto sm:size-20" src="{{ asset('images/cis-logo.webp') }}" alt="Logo CIS">
                <h1 class="mt-3 text-center text-2xl font-semibold uppercase text-gray-800 dark:text-white sm:text-3xl">
                    Iniciar sesión
                </h1>
                <div class="mt-8">
                    <x-input type="text" icon="user" name="user" id="user"
                        placeholder="Nombre de usuario (primer nombre)" label="Usuario" />
                </div>
                <div class="mt-4">
                    <x-input type="password" icon="lock" name="password" id="password" label="Contraseña"
                        placeholder="Contraseña" />
                </div>
                <div class="mt-4 flex items-center justify-between">
                    <div>
                        <x-input type="checkbox" name="remember" id="remember" label="Recuérdame" />
                    </div>
                    <div class="text-center">
                        <a href="{{ Route('forgot-password') }}"
                            class="text-sm font-medium text-zinc-500 hover:text-orange-400 hover:underline dark:text-zinc-400 dark:hover:text-orange-500">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>
                </div>
                <div class="mt-6">
                    <x-button type="submit" icon="login" class="w-full" text="Iniciar sesión" typeButton="primary" />
                </div>

            </form>
        </div>
    </section>
@endsection
