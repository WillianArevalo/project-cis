@extends('layouts.admin-template')
@section('title', 'CIS | Editar becado')
@section('content')
    <section class="p-4">
        @include('layouts.__partials.admin.header', ['title' => 'Editar becado', 'icon' => 'school'])
        <div class="mt-4">
            <form action="{{ Route('admin.becados.update', $becado->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="flex flex-col gap-4 sm:flex-row">
                    <div class="flex flex-[2] flex-col">
                        <x-input type="text" name="name" icon="user" label="Nombre del becado"
                            placeholder="Nombre completo" value="{{ $becado->name }}" />
                    </div>
                    <div class="flex-1">
                        <x-input type="text" name="phone" icon="phone" label="Teléfono"
                            placeholder="Número de teléfono" value="{{ $becado->phone }}" />
                    </div>
                </div>
                <div class="mt-4 flex flex-col gap-4 lg:flex-row">
                    <div class="flex flex-[2] flex-col">
                        <x-input type="text" name="institution" label="Institución" placeholder="Institución"
                            value="{{ $becado->institution }}" />
                    </div>
                    <div class="flex flex-1 flex-col gap-1">
                        <x-select label="Nivel académico" :options="[
                            'Universidad' => 'Universidad',
                            'Educación Básica' => 'Educacion Básica',
                            'Bachillerato Vocacional' => 'Bachillerato Vocacional',
                            'Bachillerato General' => 'Bachillerato General',
                            'Técnico Universitario u otro' => 'Técnico Universitario u otro',
                        ]" id="study_level" name="study_level"
                            value="{{ $becado->study_level }}" selected="{{ $becado->study_level }}" />
                    </div>
                    <div class="flex flex-1 flex-col">
                        <x-input type="text" name="academic_level" label="Estudiando"
                            placeholder="Año que estudia actualmente" value="{{ $becado->academic_level }}" />
                    </div>
                </div>
                <div class="mt-4 flex flex-col gap-4 lg:flex-row">
                    <div class="flex flex-[2] flex-col">
                        <x-input type="text" name="career" label="Carrera" placeholder="Carrera que estudia"
                            value="{{ $becado->career }}" />
                    </div>
                    <div class="flex flex-1 flex-col">
                        <x-select label="Comunidad" :options="$comunidades->pluck('name', 'id')->toArray()" id="community_id" name="community_id"
                            value="{{ $becado->community_id }}" selected="{{ $becado->community_id }}" />
                    </div>
                    <div class="flex flex-1 flex-col gap-1">
                        <x-select label="Usuario" :options="$users->pluck('user', 'id')->toArray()" id="user_id" name="user_id"
                            value="{{ $becado->user_id }}" selected="{{ $becado->user_id }}" />
                    </div>
                </div>
                <div class="mt-4">
                    <label
                        class="flex w-max cursor-pointer items-center justify-center gap-2 rounded-xl border border-zinc-400 px-5 py-2.5 text-sm font-medium text-zinc-600 transition-colors duration-300 hover:bg-zinc-100 dark:border-zinc-800 dark:text-white dark:hover:bg-zinc-900">
                        <x-icon icon="camera-plus" class="h-5 w-5" />
                        Seleccionar foto
                        <input type="file" name="photo" class="mt-2 hidden" id="photo"
                            accept=".png, .jpg, .jpeg, .webp">
                    </label>
                    @error('photo')
                        <small class="message-error mt-1 flex items-center gap-2 text-sm text-red-500 dark:text-red-400">
                            <x-icon icon="exclamation-circle" class="h-4 w-4 text-red-500 dark:text-red-400" />
                            {{ $message }}
                        </small>
                    @enderror
                </div>
                <div class="mt-4">
                    <img src="{{ Storage::url($becado->photo) }}" alt="Foto del becado"
                        class="h-48 w-48 rounded-full object-cover" id="preview-image">
                </div>
                <div class="mt-4 flex items-center justify-center gap-4">
                    <x-button type="a" href="{{ Route('admin.becados.index') }}" text="Cancelar" icon="close"
                        typeButton="secondary" />
                    <x-button type="submit" text="Editar" icon="pencil" typeButton="primary" />
                </div>
            </form>
        </div>
    </section>
@endsection
