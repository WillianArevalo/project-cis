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
                    <x-input type="file" name="map" id="map" icon="map" required
                        accept=".jpg, .png, .jpeg, .webp" label="Mapa" placeholder="Adjuntar mapa" />
                </div>
                <div class="mt-4 flex-1">
                    <x-input type="file" name="schedule" id="schedule" icon="calendar" required accept=".pdf, .docx"
                        label="Cronograma" placeholder="Adjuntar cronograma" />
                </div>
                <div class="mt-4 flex-1">
                    <x-input type="file" name="project" id="project" icon="file" required accept=".pdf, .docx"
                        label="Documento" placeholder="Adjuntar proyecto" />
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
