@extends('layouts.template')
@section('title', 'CIS | Restablecer contraseña')
@section('content')
    <section>
        <div class="container mx-auto flex min-h-screen items-center justify-center px-6">
            <form action="{{ Route('change-password') }}" class="w-full max-w-sm" method="POST">
                @csrf
                <img class="mx-auto size-14 w-auto sm:size-20" src="{{ asset('images/cis-logo.webp') }}" alt="Logo CIS">
                <h1 class="mt-3 text-center text-xl font-semibold uppercase text-gray-800 dark:text-white sm:text-2xl">
                    Restablecer contraseña
                </h1>
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="mt-4">
                    <x-input type="text" icon="lock" name="password" id="new-password"
                        placeholder="Ingresa tu nueva contraseña" label="Nueva contraseña" />
                </div>
                <div class="mt-4">
                    <x-input type="text" icon="lock" name="confirm_password" id="confirm-password"
                        placeholder="Confirmar contraseña" label="Confirmar contraseña" />
                </div>
                <div class="mt-6">
                    <x-button type="submit" class="w-full" text="Restablecer contraseña" typeButton="primary" />
                </div>
            </form>
        </div>
    </section>
@endsection
