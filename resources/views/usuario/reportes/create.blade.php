@extends('layouts.usuario-template')
@section('title', 'CIS | Enviar reporte')
@section('content')
    <section class="my-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="rounded-xl bg-orange-100 p-2 dark:bg-orange-950/30">
                    <x-icon icon="file-upload" class="h-8 w-8 text-orange-500 dark:text-orange-500" />
                </span>
                <h1 class="text-4xl font-bold text-zinc-800 dark:text-white">
                    Enviar reporte
                </h1>
            </div>
        </div>
        <div class="mt-4">
            <p class="my-2 text-zinc-800 dark:text-zinc-400">
                Datos del reporte
            </p>
            <form action="{{ Route('reportes.store') }}" enctype="multipart/form-data" method="POST" id="form-report">
                @csrf
                <input type="text" name="month" class="hidden" value="{{ $mes }}">
                <div class="flex flex-col gap-4 sm:flex-row">
                    <div class="flex flex-[2] flex-col">
                        <x-input type="text" name="project" icon="folder" label="Proyecto" placeholder="Proyecto"
                            value="{{ $proyecto->name }}" readonly />
                    </div>
                    <div class="relative flex flex-1 flex-col">
                        <x-input type="text" label="Fecha del reporte" placeholder="Fecha" icon="calendar"
                            id="date-input" autocomplete="off" name="date" readonly required />
                        <div id="calendar"
                            class="absolute top-20 z-50 mt-2 hidden rounded-xl border border-zinc-400 bg-white p-4 shadow-lg dark:border-zinc-800 dark:bg-zinc-950">
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex flex-col gap-4 sm:flex-row">
                    <div class="flex flex-[2] flex-col">
                        <x-input type="text" label="Tema de la actividad" required
                            placeholder="Ingresa el tema de la actividad realizada" icon="bookmark" name="theme" />
                    </div>
                    <div class="flex flex-1 flex-col">
                        <x-input type="number" required label="Número de participantes"
                            placeholder="Ingresa el # de participantes" icon="user-group" name="number_participants" />
                    </div>
                </div>
                <div class="mt-4 flex flex-col gap-4 sm:flex-row">
                    <div class="flex flex-1 flex-col">
                        <x-input type="textarea" required label="Descripción" id="description"
                            placeholder="Ingresa una descripción de la actividad" name="description" />
                    </div>
                    <div class="flex flex-1 flex-col">
                        <x-input type="textarea" required label="Obstáculos"
                            placeholder="Ingresa los obstáculos encontrados" name="obstacles" />
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex flex-col items-start justify-between rounded-xl border border-dashed border-zinc-400 p-2 dark:border-zinc-800"
                        id="container-file">
                        <div>
                            <div class="flex items-center gap-2">
                                <label
                                    class="flex w-max cursor-pointer items-center justify-center gap-1 text-nowrap rounded-xl border border-zinc-400 bg-white px-4 py-2 text-xs text-zinc-600 transition-colors duration-300 hover:bg-zinc-200/50 disabled:cursor-not-allowed disabled:bg-zinc-100/50 dark:border-zinc-800 dark:bg-zinc-950 dark:text-zinc-200 dark:hover:bg-zinc-900/50 sm:text-sm">
                                    <input type="file" name="images" id="input-images" class="hidden"
                                        accept=".jpg, .jpeg, .png" multiple>
                                    <x-icon icon="photo-up" class="h-4 w-4 text-zinc-600 dark:text-zinc-300" />
                                    Adjuntar fotografías
                                </label>
                                <p id="file-name"
                                    class="font-dine-r text-[10px] text-zinc-600 dark:text-zinc-300 sm:text-xs">
                                    Formatos permitidos: .jpg, .jpeg, .png
                                </p>
                            </div>
                            <button id="remove-file" class="me-2 hidden">
                                <x-icon icon="x" class="h-4 w-4 text-red-500" />
                            </button>
                        </div>
                        <div id="container-preview-images" class="hidden">
                            <div id="preview-images" class="mt-2 flex flex-wrap gap-2">

                            </div>
                        </div>
                    </div>
                    <div id="container-error-file" class="mt-2 hidden items-center gap-1 text-sm text-red-500">
                        <x-icon icon="exclamation-circle" class="h-4 w-4 text-red-500" />
                        <span id="error-file">
                            Debes adjuntar al menos una fotografía
                        </span>
                    </div>
                </div>
                <div class="mt-4 flex items-center justify-center gap-2">
                    <x-button type="a" href="{{ Route('reportes.index') }}" icon="corner-down-left"
                        typeButton="secondary" text="Cancelar" />
                    <x-button type="button" id="btn-add-report" icon="send" typeButton="primary"
                        text="Enviar reporte" />
                </div>
            </form>
        </div>
    </section>
@endsection
