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
                        placeholder="Nombre de usuario (primer nombre)" />
                </div>
                <div class="mt-4">
                    <x-input type="password" icon="lock" name="password" id="password" placeholder="Contraseña" />
                </div>
                <div class="mt-6">
                    <x-button type="submit" icon="login" class="w-full" text="Iniciar sesión" typeButton="primary" />
                </div>
                <div class="mt-4 text-center">
                    <a href="#" class="text-sm font-medium text-blue-500 hover:underline dark:text-blue-400">
                        ¿Olvidaste tu contraseña?
                    </a>
                </div>
            </form>
        </div>
    </section>
@endsection
