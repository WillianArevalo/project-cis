@extends('layouts.template')
@section('title', 'CIS | Enviar proyecto')
@section('content')
    <section>
        <div class="container mx-auto flex min-h-screen flex-col items-center justify-center px-6">
            <img class="mx-auto size-14 w-auto sm:size-20" src="{{ asset('images/cis-logo.webp') }}" alt="Logo CIS">
            @if (!$project)
                <div class="flex w-full flex-col items-center justify-center sm:w-[90%] md:w-[80%] lg:w-[75%] xl:w-[60%]">
                    <h1 class="mt-3 text-center text-2xl font-semibold uppercase text-gray-800 dark:text-white sm:text-3xl">
                        Envia tu proyecto social
                    </h1>
                    <div class="w-80">
                        <p class="mt-4 text-center text-base text-zinc-700 dark:text-zinc-300">
                            Envia tu proyecto para que sea revisado y aprobado por el comité.
                        </p>
                    </div>
                    <div class="mt-4">
                        @if ($errors->any())
                            <div
                                class="rounded-xl border border-red-500 bg-red-100 p-4 text-red-500 dark:border-red-800 dark:bg-red-900/20">
                                <span class="text-sm font-semibold">
                                    Por favor corrige los siguientes errores:
                                </span>
                                <ul class="list-inside list-disc">
                                    @foreach ($errors->all() as $error)
                                        <li class="text-xs">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <form action="{{ Route('proyectos.store') }}" method="POST" enctype="multipart/form-data"
                        class="w-full pb-4" id="form-project">
                        @csrf
                        <div class="mt-4 flex flex-col gap-4 sm:flex-row">
                            <div class="flex-[2]">
                                <x-input type="text" icon="folder" name="name" id="name" required
                                    placeholder="Ingresa el nombre del proyecto" label="Proyecto"
                                    value="{{ old('name') }}" />
                            </div>
                            <div class="flex flex-1 flex-col">
                                <x-select name="community_id" id="community_id" required label="Comunidad" icon="home"
                                    :options="$comunidades->pluck('name', 'id')->toArray()" selected="{{ old('community_id') }}"
                                    value="{{ old('community_id') }}" />
                            </div>
                        </div>
                        <div class="mt-4">
                            <input type="hidden" name="scholarship_id" id="scholarship_id">
                            <div class="flex items-center justify-end">
                                <x-button type="button" typeButton="primary" text="Seleccionar becados"
                                    data-modal-target="modalAssignedScholarships" icon="user-scan"
                                    data-modal-toggle="modalAssignedScholarships" />
                            </div>
                            <div class="mt-4">
                                <div class="flex flex-col gap-4 rounded-xl border border-dashed border-zinc-400 p-4 dark:border-zinc-800"
                                    id="list-scholarships">
                                    <span class="text-center text-xs text-zinc-500 dark:text-zinc-400" id="no-scholarships">
                                        No se han agregado becados
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 flex flex-col gap-4">
                            <div class="flex-1">
                                <x-input type="textarea" name="benefited_population" required
                                    legend="Cantón o comunidad, # de mujeres, # niños, # jóvenes, nombre de la escuela"
                                    label="Población beneficiada" placeholder="Ingresa la población beneficiada"
                                    value="{{ old('benefited_population') }}" />
                            </div>
                            <div class="flex-1">
                                <x-input type="text" name="general_objective" required
                                    placeholder="Ingresa el objetivo general del proyecto social" label="Objetivo general"
                                    value="{{ old('general_objective') }}" />
                            </div>
                        </div>
                        <div class="mt-4 flex flex-col gap-4 sm:flex-row sm:items-center">
                            <div class="flex-[2]">
                                <x-input type="text" name="specific_objectives" id="specific-objective"
                                    placeholder="Ingresa el objetivo específico del proyecto social"
                                    legend="Ingresa minimo 3 objetivos específicos" label="Objetivo específico" />
                            </div>
                            <div class="sm:mt-10">
                                <x-button type="button" icon="plus" id="add-objective" class="w-full"
                                    typeButton="primary" text="Agregar" />
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
                            <x-input type="textarea" name="justification" value="{{ old('justification') }}" required
                                legend="Describir por qué decidieron elaborar este proyecto"
                                placeholder="Ingresa la justificación del proyecto social" label="Justificación" />
                        </div>
                        <div class="mt-4">
                            <x-input type="textarea" name="contextualization" required
                                legend="Ubicación territorial, a qué se dedica la población principalmente, problemas de desarrollo social de la zona."
                                value="{{ old('contextualization') }}"
                                placeholder="Ingresa la contextualización del proyecto social" label="Contextualización" />
                        </div>
                        <div class="mt-4">
                            <x-input type="textarea" name="description_activities" required
                                legend="Descripción de las actividades que se realizan en el proyecto"
                                placeholder="Ingresa la descripción de las actividades" label="Descripción de actividades"
                                value="{{ old('description_activities') }}" />
                        </div>
                        <div class="mt-4">
                            <x-input type="textarea" name="projections" value="{{ old('projections') }}" required
                                legend="Frutos que esperan recibir de la puesta en práctica de su proyecto"
                                placeholder="Ingresa las proyecciones del proyecto" label="Proyecciones" />
                        </div>
                        <div class="mt-4">
                            <x-input type="textarea" name="challenges" required
                                legend="Describir las dificultades y desafíos, pero también algunas alternativas que posibiliten salir adelante con el proyecto"
                                value="{{ old('challenges') }}" placeholder="Ingresa los desafíos del proyecto"
                                label="Desafíos" />
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
                                <input type="file" id="map-image" name="map" style="display: none;" />
                            </div>
                        </div>
                        <div class="mt-4">
                            <x-input type="text" name="location" required
                                placeholder="Ingresa la ubicación del proyecto" label="Ubicación" icon="map-pin"
                                id="location" readonly />
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
                                            <input type="file" name="schedule" id="input-schedule"
                                                class="input-doc hidden" accept=".pdf, .docx"
                                                data-name="#file-name-schedule"
                                                data-button-remove="#remove-file-schedule" />
                                            <x-icon icon="file" class="h-4 w-4 text-zinc-600 dark:text-zinc-300" />
                                            Adjuntar cronograma
                                        </label>
                                        <p id="file-name-schedule"
                                            class="font-dine-r text-[10px] text-zinc-600 dark:text-zinc-300">
                                            Formatos permitidos: .pdf
                                        </p>
                                    </div>
                                    <button id="remove-file-schedule" class="remove-file hidden" type="button"
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
                                            <input type="file" name="document" id="input-doc"
                                                class="input-doc hidden" data-name="#file-name-project" accept=".pdf"
                                                data-button-remove="#remove-file-project" />
                                            <x-icon icon="file" class="h-4 w-4 text-zinc-600 dark:text-zinc-300" />
                                            Adjuntar proyecto
                                        </label>
                                        <p id="file-name-project"
                                            class="font-dine-r text-[10px] text-zinc-600 dark:text-zinc-300">
                                            Formatos permitidos: .pdf
                                        </p>
                                    </div>
                                    <button id="remove-file-project" class="remove-file hidden" type="button"
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
                        <div class="mt-6 flex items-center justify-center">
                            <x-button type="submit" icon="send" class="w-full sm:w-max" text="Enviar proyecto"
                                typeButton="primary" />
                        </div>
                    </form>
                </div>
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

    <div id="modalAssignedScholarships" tabindex="-1" aria-hidden="true"
        class="fixed inset-0 z-50 hidden h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden bg-black bg-opacity-70">
        <div class="relative h-auto w-full max-w-md p-4">
            <!-- Modal content -->
            <div
                class="relative animate-jump-in rounded-lg bg-white p-4 shadow animate-duration-300 dark:bg-zinc-950 sm:p-5">
                <!-- Modal header -->
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">
                        Seleccionar becado
                    </h3>
                    <button type="button"
                        class="ml-auto inline-flex items-center rounded-lg bg-transparent p-2 text-sm text-zinc-400 hover:bg-zinc-200 hover:text-zinc-900 dark:hover:bg-zinc-900 dark:hover:text-white"
                        data-modal-toggle="modalAssignedScholarships">
                        <svg aria-hidden="true" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="{{ Route('admin.comunidades.store') }}" method="POST">
                    @csrf
                    <div class="mt-4 w-full">
                        @if (!empty($label))
                            <label for="scholarship_id"
                                class="mb-1 block text-sm font-medium text-zinc-500 after:ml-0.5 after:text-red-500 after:content-['*'] dark:text-zinc-300">
                                Becado
                            </label>
                        @endif
                        <input type="hidden" id="scholarship_id" name="scholarship_id">
                        <div class="relative">
                            <div
                                class="selected @error('scholarship_id') is-invalid @enderror flex w-full items-center justify-between rounded-xl border border-zinc-400 bg-zinc-50 px-5 py-2.5 text-sm dark:border-zinc-800 dark:bg-transparent dark:text-white">
                                <span class="itemSelected truncate" id="scholarship_id_selected">
                                    Seleccionar becado
                                </span>
                                <x-icon icon="arrow-down" class="h-5 w-5 text-zinc-500 dark:text-white" />
                            </div>
                            <ul
                                class="selectOptions {{ $becados->count() > 6 ? 'h-64 overflow-auto' : '' }} absolute z-10 mb-8 mt-2 hidden w-full rounded-xl border border-zinc-400 bg-white p-2 shadow-lg dark:border-zinc-800 dark:bg-zinc-950">
                                @if ($becados->count() === 0)
                                    <li
                                        class="itemOption pointer-events-none rounded-xl px-4 py-3 text-sm text-zinc-900 dark:text-white dark:hover:bg-zinc-900">
                                        No hay opciones disponibles
                                    </li>
                                @else
                                    @foreach ($becados as $becado)
                                        <li class="itemOption cursor-default truncate rounded-xl px-4 py-3 text-sm text-zinc-900 hover:bg-zinc-100 dark:text-white dark:hover:bg-zinc-900/50"
                                            title="{{ $becado->name }}" data-value="{{ $becado->id }}"
                                            data-input="#scholarship_id">
                                            <div
                                                class="option-scholarship flex items-center text-zinc-600 dark:text-zinc-300">
                                                <img src="{{ Storage::url($becado->photo) }}" alt="{{ $becado->name }}"
                                                    class="size-8 rounded-full object-cover">
                                                <span class="ml-2 text-sm">{{ $becado->name }}</span>
                                            </div>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        @error('scholarship_id')
                            <small class="message-error mt-1 flex items-center gap-2 text-sm text-red-500 dark:text-red-400">
                                <x-icon icon="exclamation-circle" class="h-4 w-4 text-red-500 dark:text-red-400" />
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                    <div class="mt-4 flex justify-end gap-4">
                        <x-button type="button" data-modal-toggle="modalAssignedScholarships" icon="close"
                            typeButton="secondary" text="Cancelar" />
                        <x-button type="button" icon="save" typeButton="primary" text="Guardar" id="btnAssigned" />
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
