@extends('layouts.template')
@section('title', 'CIS | Enviar proyecto')
@section('content')
    <section>
        <div class="container mx-auto flex min-h-screen flex-col items-center justify-center px-6">
            <img class="mx-auto size-14 w-auto sm:size-20" src="{{ asset('images/cis-logo.webp') }}" alt="Logo CIS">
            <div class="flex w-full max-w-sm flex-col items-center justify-center">
                <h1
                    class="mt-3 flex items-center gap-2 text-2xl font-semibold uppercase text-gray-800 dark:text-white sm:text-3xl">
                    <x-icon icon="circle-check" class="h-10 w-10 text-green-500" />
                    Correo enviado
                </h1>
                <div class="mt-4">
                    <p class="text-center text-base text-zinc-700 dark:text-zinc-300">
                        Se ha enviado un correo a tu dirección de correo electrónico con un enlace para restablecer tu
                        contraseña.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
