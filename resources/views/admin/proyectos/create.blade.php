@extends('layouts.admin-template')
@section('title', 'CIS | Proyectos sociales')
@section('content')
    <section class="p-4">
        @include('layouts.__partials.admin.header', [
            'title' => 'Nuevo proyecto social',
            'icon' => 'folder-plus',
        ])
        <form action="{{ Route('proyectos.store') }}" class="w-full" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mt-4 flex flex-col gap-4 sm:flex-row">
                <div class="flex-[2]">
                    <x-input type="text" icon="folder" name="name" id="name" required
                        placeholder="Ingresa el nombre del proyecto" label="Proyecto" />
                </div>
                <div class="flex flex-1 flex-col">
                    <x-select name="community_id" id="community_id" required label="Comunidad" icon="home"
                        :options="$comunidades->pluck('name', 'id')->toArray()" />
                </div>
            </div>
            <div class="mt-4 flex flex-col gap-4">
                <div class="flex-1">
                    <x-input type="textarea" name="benefited_population" required
                        legend="Cantón o comunidad, # de mujeres, # niños, # jóvenes, nombre de la escuela"
                        label="Población beneficiada" placeholder="Ingresa la población beneficiada" />
                </div>
                <div class="flex-1">
                    <x-input type="text" name="general_objective" required
                        placeholder="Ingresa el objetivo general del proyecto social" label="Objetivo general" />
                </div>
            </div>
            <div class="mt-4 flex flex-col gap-4 sm:flex-row sm:items-center">
                <div class="flex-[2]">
                    <x-input type="text" name="specific_objectives" id="specific-objective"
                        placeholder="Ingresa el objetivo específico del proyecto social"
                        legend="Ingresa minimo 3 objetivos específicos" label="Objetivo específico" />
                </div>
                <div class="sm:mt-10">
                    <x-button type="button" icon="plus" id="add-objective" class="w-full" typeButton="primary"
                        text="Agregar" />
                </div>
            </div>
            <div class="mt-4">
                <ul class="flex flex-col gap-4 rounded-xl border border-dashed border-zinc-400 p-4 dark:border-zinc-800"
                    id="list-specific-objetives">
                    <li class="text-center text-xs text-zinc-500 dark:text-zinc-400" id="no-objectives">
                        No se han agregado objetivos específicos
                    </li>
                </ul>
                <div id="list-specific-objetives-inputs">

                </div>
            </div>
            <div class="mt-4">
                <x-input type="textarea" name="justification" required
                    legend="Describir por qué decidieron elaborar este proyecto"
                    placeholder="Ingresa la justificación del proyecto social" label="Justificación" />
            </div>
            <div class="mt-4">
                <x-input type="textarea" name="contextualization" required
                    legend="Ubicación territorial, a qué se dedica la población principalmente, problemas de desarrollo social de la zona."
                    placeholder="Ingresa la contextualización del proyecto social" label="Contextualización" />
            </div>
            <div class="mt-4">
                <x-input type="textarea" name="description_activities" required
                    legend="Descripción de las actividades que se realizan en el proyecto"
                    placeholder="Ingresa la descripción de las actividades" label="Descripción de actividades" />
            </div>
            <div class="mt-4">
                <x-input type="textarea" name="projections" required
                    legend="Frutos que esperan recibir de la puesta en práctica de su proyecto"
                    placeholder="Ingresa las proyecciones del proyecto" label="Proyecciones" />
            </div>
            <div class="mt-4">
                <x-input type="textarea" name="challenges" required
                    legend="Describir las dificultades y desafíos, pero también algunas alternativas que posibiliten salir adelante con el proyecto"
                    placeholder="Ingresa los desafíos del proyecto" label="Desafíos" />
            </div>
            <div class="mt-4">
                <x-input type="text" name="location" required placeholder="Ingresa la ubicación del proyecto"
                    label="Ubicación" icon="map-pin" id="location" />
            </div>
            <div class="flex flex-col gap-4 md:flex-row md:items-center">

                <div class="mt-4 flex-1">
                    <span
                        class="mb-1 block text-sm font-medium text-zinc-500 after:ml-0.5 after:text-red-500 after:content-['*'] dark:text-zinc-300">
                        Mapa
                    </span>
                    <div
                        class="flex flex-col items-start justify-between rounded-xl border border-dashed border-zinc-400 p-2 dark:border-zinc-800">
                        <div class="flex w-full justify-between">
                            <div class="flex items-center gap-2">
                                <label
                                    class="flex w-max cursor-pointer items-center justify-center gap-1 text-nowrap rounded-xl border border-zinc-400 bg-white px-4 py-2 text-xs text-zinc-600 transition-colors duration-300 hover:bg-zinc-200/50 disabled:cursor-not-allowed disabled:bg-zinc-100/50 dark:border-zinc-800 dark:bg-zinc-950 dark:text-zinc-200 dark:hover:bg-zinc-900/50 sm:text-xs">
                                    <input type="file" name="map" id="input-map" class="input-doc hidden"
                                        accept=".jpg, .png, .jpeg, .webp" data-button-remove="#remove-file-map"
                                        data-name="#file-name-map" />
                                    <x-icon icon="file" class="h-4 w-4 text-zinc-600 dark:text-zinc-300" />
                                    Adjuntar mapa
                                </label>
                                <p id="file-name-map" class="font-dine-r text-[10px] text-zinc-600 dark:text-zinc-300">
                                    Formatos permitidos: .jpg, .png, .jpeg, .webp
                                </p>
                            </div>
                            <button class="remove-file hidden" id="remove-file-map" type="button"
                                data-input="#input-map">
                                <x-icon icon="close" class="h-4 w-4 text-red-500" />
                            </button>
                        </div>
                    </div>
                    @error('document')
                        <span class="mt-2 flex items-center gap-1 text-sm text-red-500">
                            <x-icon icon="exclamation-circle" class="h-4 w-4" />
                            <span class="error-msg text-red-500">
                                {{ $message }}
                            </span>
                        </span>
                    @enderror
                </div>

                <div class="mt-4 flex-1">
                    <span
                        class="mb-1 block text-sm font-medium text-zinc-500 after:ml-0.5 after:text-red-500 after:content-['*'] dark:text-zinc-300">
                        Cronograma
                    </span>
                    <div
                        class="flex flex-col items-start justify-between rounded-xl border border-dashed border-zinc-400 p-2 dark:border-zinc-800">
                        <div class="flex w-full justify-between">
                            <div class="flex items-center gap-2">
                                <label
                                    class="flex w-max cursor-pointer items-center justify-center gap-1 text-nowrap rounded-xl border border-zinc-400 bg-white px-4 py-2 text-xs text-zinc-600 transition-colors duration-300 hover:bg-zinc-200/50 disabled:cursor-not-allowed disabled:bg-zinc-100/50 dark:border-zinc-800 dark:bg-zinc-950 dark:text-zinc-200 dark:hover:bg-zinc-900/50 sm:text-xs">
                                    <input type="file" name="schedule" id="input-schedule" class="input-doc hidden"
                                        accept=".pdf" data-name="#file-name-schedule"
                                        data-button-remove="#remove-file-schedule" />
                                    <x-icon icon="file" class="h-4 w-4 text-zinc-600 dark:text-zinc-300" />
                                    Adjuntar cronograma
                                </label>
                                <p id="file-name-schedule"
                                    class="font-dine-r text-[10px] text-zinc-600 dark:text-zinc-300">
                                    Formatos permitidos: .pdf
                                </p>
                            </div>
                            <button class="remove-file hidden" id="remove-file-schedule" type="button"
                                data-input="#input-schedule">
                                <x-icon icon="close" class="h-4 w-4 text-red-500" />
                            </button>
                        </div>
                    </div>
                    @error('document')
                        <span class="mt-2 flex items-center gap-1 text-sm text-red-500">
                            <x-icon icon="exclamation-circle" class="h-4 w-4" />
                            <span class="error-msg text-red-500">
                                {{ $message }}
                            </span>
                        </span>
                    @enderror
                </div>

                <div class="mt-4 flex-1">
                    <span
                        class="mb-1 block text-sm font-medium text-zinc-500 after:ml-0.5 after:text-red-500 after:content-['*'] dark:text-zinc-300">
                        Documento
                    </span>
                    <div
                        class="flex flex-col items-start justify-between rounded-xl border border-dashed border-zinc-400 p-2 dark:border-zinc-800">
                        <div class="flex w-full justify-between">
                            <div class="flex items-center gap-2">
                                <label
                                    class="flex w-max cursor-pointer items-center justify-center gap-1 text-nowrap rounded-xl border border-zinc-400 bg-white px-4 py-2 text-xs text-zinc-600 transition-colors duration-300 hover:bg-zinc-200/50 disabled:cursor-not-allowed disabled:bg-zinc-100/50 dark:border-zinc-800 dark:bg-zinc-950 dark:text-zinc-200 dark:hover:bg-zinc-900/50 sm:text-xs">
                                    <input type="file" name="document" id="input-doc" class="input-doc hidden"
                                        accept=".pdf" data-name="#file-name-project"
                                        data-button-remove="#remove-file-project" />
                                    <x-icon icon="file" class="h-4 w-4 text-zinc-600 dark:text-zinc-300" />
                                    Adjuntar proyecto
                                </label>
                                <p id="file-name-project"
                                    class="font-dine-r text-[10px] text-zinc-600 dark:text-zinc-300">
                                    Formatos permitidos: .pdf
                                </p>
                            </div>
                            <button class="remove-file hidden" id="remove-file-project" type="button"
                                data-input="#input-doc">
                                <x-icon icon="close" class="h-4 w-4 text-red-500" />
                            </button>
                        </div>
                    </div>
                    @error('document')
                        <span class="mt-2 flex items-center gap-1 text-sm text-red-500">
                            <x-icon icon="exclamation-circle" class="h-4 w-4" />
                            <span class="error-msg text-red-500">
                                {{ $message }}
                            </span>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="mt-6 flex items-center justify-center gap-4">
                <x-button type="a" href="{{ Route('admin.proyectos.index') }}" icon="corner-down-left"
                    class="w-full sm:w-max" text="Regresar" typeButton="secondary" />
                <x-button type="submit" icon="folder-plus" class="w-full sm:w-max" text="Agregar proyecto"
                    typeButton="primary" />
            </div>
        </form>
    </section>
@endsection
