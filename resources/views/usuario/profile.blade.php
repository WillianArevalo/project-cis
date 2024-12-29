@extends('layouts.usuario-template')
@section('title', 'CIS | Perfil')
@section('content')
    <section class="my-4">
        <div class="flex flex-col gap-4 sm:flex-row">
            <div class="flex flex-1 flex-col rounded-2xl border border-zinc-400 p-4 shadow-md dark:border-zinc-800">
                <div class="flex items-center justify-center">
                    <img src="{{ Storage::url($user->scholarship->photo) }}" alt="Profile {{ $user->user }}"
                        class="size-36 rounded-full object-cover">
                </div>
                <div class="mt-8 flex flex-col items-center justify-center sm:mt-auto">
                    @if (!$user->email_verified_at)
                        <x-button type="a" href="{{ Route('profile.verifyEmail') }}" typeButton="primary"
                            icon="envelope" text="Verificar correo" />
                    @else
                        <p class="mt-10 text-center text-sm font-bold text-zinc-700 dark:text-white">
                            {{ $user->email }}
                        </p>
                        <p
                            class="mt-2 flex w-max items-center gap-1 rounded-xl border border-dashed border-green-500 bg-green-50 px-2 py-1 text-xs text-green-500 dark:bg-green-950/20 dark:text-green-500">
                            <x-icon icon="email-check" class="size-4" />
                            Correo verificado
                        </p>
                    @endif
                </div>
            </div>
            <div class="h-full flex-[2]">
                <div class="rounded-2xl border border-zinc-400 p-4 shadow-md dark:border-zinc-800">
                    <h1 class="text-lg font-bold text-orange-500 sm:text-xl md:text-2xl lg:text-3xl">
                        {{ $user->scholarship->name }}
                    </h1>
                    <p class="mt-2 text-sm text-zinc-800 dark:text-zinc-300">
                        {{ $user->scholarship->community->name }}
                    </p>
                    <p class="mt-2 text-sm text-zinc-800 dark:text-zinc-300">
                        {{ $user->scholarship->project ? $user->scholarship->project->name : 'Sin proyecto asignado' }}
                    </p>
                </div>
                <div class="mt-4 rounded-2xl border border-zinc-400 p-4 shadow-md dark:border-zinc-800">
                    <h2 class="text-lg font-medium text-zinc-700 dark:text-white">
                        Cambiar contraseña
                    </h2>
                    @if (!$user->email_verified_at)
                        <p
                            class="mt-2 flex items-center gap-1 rounded-xl border border-dashed border-red-500 bg-red-50 p-4 text-sm text-red-500 dark:bg-red-950/20 dark:text-red-500">
                            <x-icon icon="exclamation-circle" class="h-5 w-5" />
                            Debes verificar tu correo para cambiar tu contraseña
                        </p>
                    @else
                        <form action="{{ Route('profile.change-password') }}" class="mt-4" method="POST">
                            @csrf
                            <div>
                                <x-input type="password" name="password" id="new-password" label="Contraseña actual"
                                    placeholder="Ingresa tu contraseña actual" icon="lock" />
                            </div>
                            <div class="mt-4">
                                <x-input type="password" name="confirm_password" id="confirm-password"
                                    label="Confirmar contraseña" placeholder="Confirma tu nueva contraseña"
                                    icon="lock" />
                            </div>
                            <div class="mt-4 flex items-center justify-center">
                                <x-button type="submit" typeButton="primary" icon="password-user"
                                    text="Cambiar contraseña" />
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
