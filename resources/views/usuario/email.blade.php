@extends('layouts.template')
@section('title', 'CIS | Verificar correo')
@section('content')
    <section>
        <div class="container mx-auto flex min-h-screen items-center justify-center px-6">
            <form action="{{ Route('sendEmail') }}" class="w-full max-w-sm" method="POST">
                @csrf
                <img class="mx-auto size-14 w-auto sm:size-20" src="{{ asset('images/cis-logo.webp') }}" alt="Logo CIS">
                <h1 class="mt-3 text-center text-xl font-semibold uppercase text-gray-800 dark:text-white sm:text-2xl">
                    Verificar correo
                </h1>
                <p class="mt-1 text-center text-sm text-gray-500 dark:text-gray-400">
                    Ingresa tu correo para enviarte un enlace de verificación
                </p>
                <div class="mt-8">
                    <x-input type="text" label="Correo electrónico" icon="email" name="email" id="email"
                        placeholder="Ingresa tu email" />
                </div>
                <div class="mt-6">
                    <x-button type="submit" icon="login" class="w-full" text="Enviar correo" typeButton="primary" />
                </div>
            </form>
        </div>
    </section>
@endsection
