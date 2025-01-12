@extends('layouts.usuario-template')
@section('title', 'CIS | Reportes')
@section('content')
    <section class="my-4">
        <div class="flex items-center gap-4 rounded-2xl border border-zinc-400 p-4 shadow-md dark:border-zinc-800">
            <img src="{{ asset('svg/tree.svg') }}" alt="Tree SVG"
                class="size-8 rounded-full object-cover sm:size-10 md:size-14">
            <h1 class="text-base font-bold uppercase text-zinc-800 dark:text-white sm:text-lg md:text-xl">
                Proyecto asignado:
                <br>
                <span class="bg-blue text-lg sm:text-xl md:text-2xl">
                    {{ $project->name }}
                </span>
            </h1>
        </div>
        <div class="mt-4">
            <h2 class="text-lg font-bold text-zinc-800 dark:text-white sm:text-xl md:text-2xl">
                Reportes mensuales
            </h2>
            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3">
                @foreach ($months as $month)
                    <x-card :month="$month" :index="$loop->index" :reports="$reports[$month]" :send="$reports[$month]->count() > 0" :limitMonth="$currentMonth" />
                @endforeach
            </div>
        </div>
    </section>
@endsection
