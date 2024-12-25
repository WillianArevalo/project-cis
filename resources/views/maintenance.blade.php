@extends('layouts.template')
@section('title', 'CIS | Página en mantenimiento')
@section('content')
    <section class="flex min-h-screen items-center justify-center">
        <div class="text-center">
            <div class="flex justify-center">
                <img class="mx-auto size-14 w-auto sm:size-20" src="{{ asset('images/cis-logo.webp') }}" alt="LOGO CIS">
            </div>
            <h1 class="mt-6 text-4xl font-bold text-zinc-700 dark:text-zinc-300">
                Sitio en mantenimiento
            </h1>
            <p class="mt-4 text-sm text-zinc-500 dark:text-zinc-400">
                El sitio web se encuentra actualmente en mantenimiento programado. <br>
                Estaremos de vuelta en breve. ¡Esperate un momento!. <br>
                Si tienes alguna pregunta, no dudes en ponerte en contacto conmigo.
            </p>
            <div class="mt-4 flex items-center justify-center">
                <x-button type="a"
                    href="https://api.whatsapp.com/send/?phone=50375456642&text&type=phone_number&app_absent=0"
                    target="_blank" typeButton="primary" text="Enviar mensaje" class="w-max" icon="whatsapp" />
            </div>
        </div>
    </section>
@endsection
