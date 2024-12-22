@extends('layouts.usuario-template')
@section('title', 'Enviar reporte')
@section('content')
    <section class="my-4">
        <div>
            <div class="flex items-center gap-2">
                <x-icon icon="file-upload" class="h-8 w-8 text-white" />
                <h1 class="text-4xl font-bold text-white">
                    Enviar reporte
                </h1>
            </div>
            <p class="ms-10 mt-2 text-zinc-800 dark:text-zinc-400">
                Datos del reporte
            </p>
        </div>
        <div class="mt-4">
            <form action="">
                <div class="flex gap-4">
                    <div class="flex flex-[2] flex-col">
                        <x-input type="text" name="project" icon="folder" label="Proyecto" placeholder="Proyecto"
                            value="{{ $proyecto->name }}" readonly />
                    </div>
                    <div class="relative flex flex-1 flex-col">
                        <x-input type="text" label="Fecha de nacimiento" placeholder="Fecha" value=""
                            icon="calendar" id="date-input" autocomplete="off" name="birthdate" />
                        <div id="calendar"
                            class="absolute top-20 z-50 mt-2 hidden rounded-xl border border-zinc-400 p-4 shadow-lg dark:border-zinc-800 dark:bg-zinc-950">
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex gap-4">
                    <div class="flex flex-[2] flex-col">
                        <x-input type="text" label="Tema de la actividad"
                            placeholder="Ingresa el tema de la actividad realizada" icon="bookmark" name="birthdate" />
                    </div>
                    <div class="flex flex-1 flex-col">
                        <x-input type="text" label="Número de participantes" placeholder="Ingresa el # de participantes"
                            icon="user-group" name="birthdate" />
                    </div>
                </div>
                <div class="mt-4 flex gap-4">
                    <div class="flex flex-1 flex-col">
                        <x-input type="textarea" label="Descripción" placeholder="Ingresa una descripción de la actividad"
                            name="birthdate" />
                    </div>
                    <div class="flex flex-1 flex-col">
                        <x-input type="textarea" label="Obstáculos" placeholder="Ingresa los obstáculos encontrados"
                            name="birthdate" />
                    </div>
                </div>
                <div class="mt-4">
                    <input type="file" name="report" id="image-report" class="text-sm" />
                </div>
            </form>
        </div>
    </section>
@endsection
