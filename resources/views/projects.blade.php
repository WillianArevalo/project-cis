@extends('layouts.template')
@section('title', 'CIS | Enviar proyecto')
@section('content')
    <section class="py-10">
        <div class="container mx-auto flex min-h-screen flex-col items-center justify-center px-6">
            <img class="mx-auto size-14 w-auto sm:size-20" src="{{ asset('images/cis-logo.webp') }}" alt="Logo CIS">
            @if (!$project)
                <h1 class="mt-3 text-center text-2xl font-semibold uppercase text-gray-800 dark:text-white sm:text-3xl">
                    Envia tu proyecto social
                </h1>
                <div class="w-80">
                    <p class="mt-4 text-center text-base text-zinc-700 dark:text-zinc-300">
                        Envia tu proyecto para que sea revisado y aprobado por el comité.
                    </p>
                </div>
                <form action="{{ Route('proyectos.store') }}" class="w-full sm:w-[90%] md:w-[80%] lg:w-[75%] xl:w-[60%]"
                    method="POST" enctype="multipart/form-data">
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
                            <x-input type="text" name="specific_objectives" required
                                placeholder="Ingresa el objetivo específico del proyecto social"
                                label="Objetivo específico" />
                        </div>
                        <div class="sm:mt-6">
                            <x-button type="button" icon="plus" class="w-full" typeButton="primary" text="Agregar" />
                        </div>
                    </div>
                    <div class="mt-4" id="list-specific-objetives">
                        <div class="rounded-xl border border-dashed border-zinc-400 p-4 text-center dark:border-zinc-800">
                            <span class="text-xs text-zinc-500 dark:text-zinc-400">
                                No se han agregado objetivos específicos
                            </span>
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
                        <label
                            class="mb-2 block text-sm font-medium text-zinc-500 after:ml-0.5 after:text-red-500 after:content-['*'] dark:text-zinc-300">
                            Mapa
                        </label>
                        <div id="map" class="-z-0 h-80 w-full rounded-xl sm:h-[400px] md:h-[500px]"></div>
                        <div id="preview-container" class="mt-4 hidden"></div>

                        <div id="capture-map-msg" class="mt-4 hidden">
                            <div
                                class="flex items-center justify-center gap-2 rounded-xl border border-dashed border-green-400 bg-green-100 p-4 text-center text-sm text-green-500 dark:border-green-800 dark:bg-green-950/20">
                                <x-icon icon="info-circle" class="h-4 w-4 text-green-500" />
                                Captura del mapa guardada
                            </div>
                        </div>

                        <div class="controls mt-4 flex w-full flex-col items-center gap-4 sm:flex-row">
                            <x-button type="button" id="capture-map" text="Capturar mapa" icon="capture"
                                typeButton="primary" class="w-full sm:w-max" />
                            <x-button type="button" id="remove-map" text="Eliminar captura" icon="trash"
                                typeButton="danger" class="hidden w-full sm:w-max" />
                            <input type="file" id="map-image" name="map_image" style="display: none;" />
                        </div>
                    </div>

                    <div class="mt-4">
                        <x-input type="text" name="location" required placeholder="Ingresa la ubicación del proyecto"
                            label="Ubicación" icon="map-pin" id="location" readonly />
                    </div>


                    <div class="mt-4">
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
                                        <input type="file" name="schedule" id="input-schedule" class="hidden"
                                            accept=".pdf, .docx" />
                                        <x-icon icon="file" class="h-4 w-4 text-zinc-600 dark:text-zinc-300" />
                                        Adjuntar cronograma
                                    </label>
                                    <p id="file-name" class="font-dine-r text-[10px] text-zinc-600 dark:text-zinc-300">
                                        Formatos permitidos: .pdf, .docx
                                    </p>
                                </div>
                                <button id="remove-file-schedule" class="hidden" type="button">
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

                    <div class="mt-4">
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
                                        <input type="file" name="document" id="input-doc" class="hidden"
                                            accept=".pdf, .docx" />
                                        <x-icon icon="file" class="h-4 w-4 text-zinc-600 dark:text-zinc-300" />
                                        Adjuntar proyecto
                                    </label>
                                    <p id="file-name" class="font-dine-r text-[10px] text-zinc-600 dark:text-zinc-300">
                                        Formatos permitidos: .pdf, .docx
                                    </p>
                                </div>
                                <button id="remove-file" class="hidden" type="button">
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
                    <div class="mt-6 flex items-center justify-center">
                        <x-button type="submit" icon="send" class="w-full sm:w-max" text="Enviar proyecto"
                            typeButton="primary" />
                    </div>
                </form>
            @else
                <div class="w-full max-w-sm">
                    <h1
                        class="mt-3 flex items-center gap-2 text-center text-2xl font-semibold uppercase text-gray-800 dark:text-white sm:text-3xl">
                        <x-icon icon="circle-check" class="h-10 w-10 text-green-500" />
                        Proyecto enviado
                    </h1>
                    <div class="mt-4">
                        <p class="text-center text-base text-zinc-700 dark:text-zinc-300">
                            Tu proyecto ha sido enviado exitosamente. Espera a que sea revisado y aprobado.
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
