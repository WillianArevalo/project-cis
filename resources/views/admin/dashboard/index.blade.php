@extends('layouts.admin-template')
@section('title', 'Dashboard')
@section('content')
    <section class="p-4">
        <div class="flex items-center gap-2">
            <x-icon icon="dashboard" class="h-8 w-8 text-white" />
            <h1 class="text-4xl font-bold text-white">
                Dashboard
            </h1>
        </div>
        <div class="mt-4 grid grid-cols-3 gap-4">
            <div class="rounded-3xl border border-zinc-400 p-6 dark:border-zinc-800 dark:bg-zinc-950">
                <div class="flex items-center justify-center gap-4">
                    <span>
                        <x-icon icon="school" class="h-8 w-8 text-black dark:text-white" />
                    </span>
                    <h2 class="text-4xl font-bold text-black dark:text-white">
                        {{ $becados }}
                        Becados
                    </h2>
                </div>
                <div class="mt-6 p-4">
                    <img src="{{ asset('svg/scholarships.svg') }}" alt="becados" class="mx-auto h-60 w-72">
                </div>
                <div class="mt-6 flex items-center justify-center">
                    <x-button type="a" href="{{ route('admin.becados.index') }}" typeButton="primary"
                        text="Ver becados" icon="users" />
                </div>
            </div>
            <div class="rounded-3xl border border-zinc-400 p-6 dark:border-zinc-800 dark:bg-zinc-950">
                <div class="flex items-center justify-center gap-4">
                    <span>
                        <x-icon icon="folder" class="h-8 w-8 text-black dark:text-white" />
                    </span>
                    <h2 class="text-3xl font-bold text-black dark:text-white">
                        {{ $proyectos }}
                        Proyectos sociales
                    </h2>
                </div>
                <div class="mt-6 p-4">
                    <img src="{{ asset('svg/folders.svg') }}" alt="becados" class="mx-auto h-60 w-72">
                </div>
                <div class="mt-6 flex items-center justify-center">
                    <x-button type="a" href="{{ route('admin.proyectos.index') }}" typeButton="primary"
                        text="Ver proyectos sociales" icon="folders" />
                </div>
            </div>
            <div class="rounded-3xl border border-zinc-400 p-6 dark:border-zinc-800 dark:bg-zinc-950">
                <div class="flex items-center justify-center gap-4">
                    <span>
                        <x-icon icon="folder" class="h-8 w-8 text-black dark:text-white" />
                    </span>
                    <h2 class="text-3xl font-bold text-black dark:text-white">
                        {{ $comunidades }}
                        Comunidades
                    </h2>
                </div>
                <div class="mt-6 p-4">
                    <img src="{{ asset('svg/home.svg') }}" alt="becados" class="mx-auto h-60 w-72">
                </div>
                <div class="mt-6 flex items-center justify-center">
                    <x-button type="a" href="{{ route('admin.comunidades.index') }}" typeButton="primary"
                        text="Ver comunidades" icon="home" />
                </div>
            </div>
            <div class="rounded-3xl border border-zinc-400 p-6 dark:border-zinc-800 dark:bg-zinc-950">
                <div class="flex items-center justify-center gap-4">
                    <span>
                        <x-icon icon="folder" class="h-8 w-8 text-black dark:text-white" />
                    </span>
                    <h2 class="text-3xl font-bold text-black dark:text-white">
                        {{ $usuarios }}
                        Usuarios
                    </h2>
                </div>
                <div class="mt-6 p-4">
                    <img src="{{ asset('svg/users.svg') }}" alt="becados" class="mx-auto h-60 w-72">
                </div>
                <div class="mt-6 flex items-center justify-center">
                    <x-button type="a" href="{{ route('admin.comunidades.index') }}" typeButton="primary"
                        text="Ver comunidades" icon="home" />
                </div>
            </div>
        </div>
    </section>
@endsection
