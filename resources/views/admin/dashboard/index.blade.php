@extends('layouts.admin-template')
@section('title', 'Dashboard')
@section('content')
    <section class="p-4">
        @include('layouts.__partials.admin.header', [
            'title' => 'Dashboard',
            'icon' => 'dashboard',
        ])
        <div class="mt-4 grid grid-cols-1 gap-4 lg:grid-cols-2 xl:grid-cols-3">
            <div class="h-full rounded-3xl border border-zinc-400 p-4 dark:border-zinc-800 dark:bg-zinc-950">
                <div class="flex items-center justify-center gap-2">
                    <span class="rounded-xl bg-blue-100 p-2 text-blue-500">
                        <x-icon icon="school" class="size-6 text-current" />
                    </span>
                    <h2 class="text-2xl font-bold text-black dark:text-white">
                        {{ $becados }}
                        Becados
                    </h2>
                </div>
                <div class="mt-6 p-4">
                    <img src="{{ asset('svg/scholarships.svg') }}" alt="becados" class="mx-auto h-60 w-full">
                </div>
                <div class="mt-6 flex items-center justify-center">
                    <x-button type="a" href="{{ route('admin.becados.index') }}" typeButton="primary"
                        text="Ver becados" icon="school" />
                </div>
            </div>
            <div class="rounded-3xl border border-zinc-400 p-4 dark:border-zinc-800 dark:bg-zinc-950">
                <div class="flex items-center justify-center gap-2">
                    <span class="rounded-xl bg-blue-100 p-2 text-blue-500">
                        <x-icon icon="folders" class="size-6 text-current" />
                    </span>
                    <h2 class="text-2xl font-bold text-black dark:text-white">
                        {{ $proyectos }}
                        Proyectos
                    </h2>
                </div>
                <div class="mt-6 p-4">
                    <img src="{{ asset('svg/folders.svg') }}" alt="becados" class="mx-auto h-60 w-full">
                </div>
                <div class="mt-6 flex items-center justify-center">
                    <x-button type="a" href="{{ route('admin.proyectos.index') }}" typeButton="primary"
                        text="Ver proyectos sociales" icon="folders" />
                </div>
            </div>
            <div class="rounded-3xl border border-zinc-400 p-4 dark:border-zinc-800 dark:bg-zinc-950">
                <div class="flex items-center justify-center gap-2">
                    <span class="rounded-xl bg-blue-100 p-2 text-blue-500">
                        <x-icon icon="home" class="size-6 text-current" />
                    </span>
                    <h2 class="text-2xl font-bold text-black dark:text-white">
                        {{ $comunidades }}
                        Comunidades
                    </h2>
                </div>
                <div class="mt-6 p-4">
                    <img src="{{ asset('svg/home.svg') }}" alt="becados" class="mx-auto h-60 w-full">
                </div>
                <div class="mt-6 flex items-center justify-center">
                    <x-button type="a" href="{{ route('admin.comunidades.index') }}" typeButton="primary"
                        text="Ver comunidades" icon="home" />
                </div>
            </div>
            <div class="rounded-3xl border border-zinc-400 p-4 dark:border-zinc-800 dark:bg-zinc-950">
                <div class="flex items-center justify-center gap-2">
                    <span class="rounded-xl bg-blue-100 p-2 text-blue-500">
                        <x-icon icon="users" class="size-6 text-current" />
                    </span>
                    <h2 class="text-2xl font-bold text-black dark:text-white">
                        {{ $usuarios }}
                        Usuarios
                    </h2>
                </div>
                <div class="mt-6 p-4">
                    <img src="{{ asset('svg/users.svg') }}" alt="becados" class="mx-auto h-60 w-full">
                </div>
                <div class="mt-6 flex items-center justify-center">
                    <x-button type="a" href="{{ route('admin.comunidades.index') }}" typeButton="primary"
                        text="Ver usuarios" icon="users" />
                </div>
            </div>
        </div>
    </section>
@endsection
