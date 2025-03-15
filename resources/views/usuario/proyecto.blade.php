@extends('layouts.usuario-template')
@section('title', 'CIS | Proyecto')
@section('content')
    <form action="{{ Route('proyectos.update', $proyecto->id) }}" class="w-full" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mt-4 flex flex-col gap-4 sm:flex-row">
            <div class="flex-[2]">
                <x-input type="text" icon="folder" name="name" id="name" required value="{{ $proyecto->name }}"
                    placeholder="Ingresa el nombre del proyecto" label="Proyecto" />
            </div>
            <div class="flex flex-1 flex-col">
                <input type="hidden" name="community_id" value="{{ $comunidad->id }}" />
                <x-input type="text" icon="home" name="comunidad" required value="{{ $comunidad->name }}" readonly
                    label="Comunidad" />
            </div>
        </div>
        <div class="mt-4 flex flex-col gap-4">
            <div class="flex-1">
                <x-input type="textarea" name="benefited_population" value="{{ $proyecto->benefited_population }}"
                    legend="Cantón o comunidad, # de mujeres, # niños, # jóvenes, nombre de la escuela"
                    label="Población beneficiada" placeholder="Ingresa la población beneficiada" />
            </div>
            <div class="flex-1">
                <x-input type="text" name="general_objective" value="{{ $proyecto->general_objective }}"
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
                @if ($proyecto->specificObjetives->count() === 0)
                    <li class="text-center text-xs text-zinc-500 dark:text-zinc-400" id="no-objectives">
                        No se han agregado objetivos específicos
                    </li>
                @else
                    @foreach ($proyecto->specificObjetives as $objective)
                        <li class="jusitfy-between flex w-full list-disc text-sm text-zinc-600 dark:text-zinc-200">
                            {{ $objective->specific_objective }}
                            <button class="btn-remove-objective ml-auto" data-value="{{ $objective->specific_objective }}"
                                type="button">
                                <svg class="size-4 text-red-500" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M18 6l-12 12" />
                                    <path d="M6 6l12 12" />
                                </svg>
                            </button>
                        </li>
                    @endforeach
                @endif
            </ul>
            <div id="list-specific-objetives-inputs">
                @if ($proyecto->specificObjetives->count() > 0)
                    @foreach ($proyecto->specificObjetives as $objective)
                        <input type="hidden" name="specific_objectives[]" value="{{ $objective->specific_objective }}" />
                    @endforeach
                @endif
            </div>
        </div>
        <div class="mt-4">
            <x-input type="textarea" name="justification" value="{{ $proyecto->justification }}"
                legend="Describir por qué decidieron elaborar este proyecto"
                placeholder="Ingresa la justificación del proyecto social" label="Justificación" />
        </div>
        <div class="mt-4">
            <x-input type="textarea" name="contextualization"
                legend="Ubicación territorial, a qué se dedica la población principalmente, problemas de desarrollo social de la zona."
                value="{{ $proyecto->contextualization }}" placeholder="Ingresa la contextualización del proyecto social"
                label="Contextualización" />
        </div>
        <div class="mt-4">
            <x-input type="textarea" name="description_activities" value="{{ $proyecto->description_activities }}"
                legend="Descripción de las actividades que se realizan en el proyecto"
                placeholder="Ingresa la descripción de las actividades" label="Descripción de actividades" />
        </div>
        <div class="mt-4">
            <x-input type="textarea" name="projections" value="{{ $proyecto->projections }}"
                legend="Frutos que esperan recibir de la puesta en práctica de su proyecto"
                placeholder="Ingresa las proyecciones del proyecto" label="Proyecciones" />
        </div>
        <div class="mt-4">
            <x-input type="textarea" name="challenges" value="{{ $proyecto->challenges }}"
                legend="Describir las dificultades y desafíos, pero también algunas alternativas que posibiliten salir adelante con el proyecto"
                placeholder="Ingresa los desafíos del proyecto" label="Desafíos" />
        </div>
        <div class="mt-4">
            <x-input type="text" name="location" placeholder="Ingresa la ubicación del proyecto" label="Ubicación"
                icon="map-pin" id="location" value="{{ $proyecto->location }}" />
        </div>
        <div class="mt-4 flex-1">
            @if ($proyecto->map)
                <div class="mb-4">
                    <img src="{{ Storage::url($proyecto->map) }}" frameborder="0"
                        class="h-96 w-[550px] rounded-xl object-cover" id="preview-map" />
                </div>
            @else
                <div class="rounded-xl border border-dashed border-zinc-400 p-4 dark:border-zinc-800">
                    <p class="text-center text-xs text-zinc-500 dark:text-zinc-400" id="no-map">
                        No se ha agregado mapa
                    </p>
                </div>
            @endif
            <div class="mt-4 flex-1">
                <x-input type="file" name="map" id="map" icon="map" accept=".jpg, .png, .jpeg, .webp"
                    label="Mapa" placeholder="Editar mapa" data-preview="#preview-map" />
            </div>
        </div>
        <div class="flex flex-col gap-4 md:flex-row md:items-center">
            <div class="mt-4 flex-1">
                @if ($proyecto->schedule)
                    <div class="mb-4">
                        <iframe src="{{ Storage::url($proyecto->schedule) }}" frameborder="0"
                            class="h-96 w-full"></iframe>
                    </div>
                @else
                    <div class="mb-4 rounded-xl border border-dashed border-zinc-400 p-4 dark:border-zinc-800">
                        <p class="text-center text-xs text-zinc-500 dark:text-zinc-400" id="no-schedule">
                            No se ha agregado cronograma
                        </p>
                    </div>
                @endif
                <div class="mt-4 flex-1">
                    <x-input type="file" name="schedule" id="schedule" icon="calendar" accept=".pdf, .docx"
                        label="Cronograma" placeholder="Editar cronograma" />
                </div>
            </div>

            <div class="mt-4 flex-1">
                @if ($proyecto->document)
                    <div class="mb-4">
                        <iframe src="{{ Storage::url($proyecto->document) }}" frameborder="0"
                            class="h-96 w-full"></iframe>
                    </div>
                @else
                    <div class="mb-4 rounded-xl border border-dashed border-zinc-400 p-4 dark:border-zinc-800">
                        <p class="text-center text-xs text-zinc-500 dark:text-zinc-400" id="no-document">
                            No se ha agregado documento
                        </p>
                    </div>
                @endif
                <div class="mt-4 flex-1">
                    <x-input type="file" name="document" id="project" icon="file" accept=".pdf, .docx"
                        label="Documento" placeholder="Editar proyecto" />
                </div>
            </div>
        </div>
        <div class="mt-4">
            <x-input type="checkbox" name="accept" id="accept" value="{{ $proyecto->accept }}"
                label="Aceptar proyecto" checked="{{ $proyecto->accept }}" />
        </div>
        <div class="mt-6 flex items-center justify-center gap-4">
            <x-button type="submit" icon="pencil" class="w-full sm:w-max" text="Editar proyecto"
                typeButton="primary" />
            <x-button type="a" href="{{ Route('admin.proyectos.index') }}" icon="corner-down-left"
                class="w-full sm:w-max" text="Regresar" typeButton="secondary" />
        </div>
    </form>
@endsection
