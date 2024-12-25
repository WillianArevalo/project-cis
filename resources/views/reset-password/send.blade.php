@extends('layouts.template')
@section('title', 'CIS | Restablecer contraseña')
@section('content')
    <section>
        <div class="container mx-auto flex min-h-screen items-center justify-center px-6">
            <form action="{{ Route('send-email-reset-password') }}" class="w-full max-w-sm" method="POST">
                @csrf
                <img class="mx-auto size-14 w-auto sm:size-20" src="{{ asset('images/cis-logo.webp') }}" alt="Logo CIS">
                <h1 class="mt-3 text-center text-xl font-semibold uppercase text-gray-800 dark:text-white sm:text-2xl">
                    Restablecer contraseña
                </h1>
                <p class="mt-1 text-center text-sm text-gray-500 dark:text-gray-400">
                    Ingresa tu correo para enviarte un enlace de restablecimiento de contraseña
                </p>
                <div class="mt-8">
                    <x-input type="text" icon="email" label="Correo electrónico" name="email" id="email"
                        placeholder="Ingresa tu email" />
                </div>
                <div class="mt-6">
                    <x-button type="submit" class="w-full" text="Enviar enlace" typeButton="primary" />
                </div>
            </form>
        </div>
    </section>
@endsection
