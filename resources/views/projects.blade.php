@extends('layouts.template')
@section('title', 'CIS | Enviar proyecto')
@section('content')
    <section>
        <div class="container mx-auto flex min-h-screen flex-col items-center justify-center px-6">
            <img class="mx-auto size-14 w-auto sm:size-20" src="{{ asset('images/cis-logo.webp') }}" alt="Logo CIS">
            @if (!$project)
                <h1 class="mt-3 text-center text-2xl font-semibold uppercase text-gray-800 dark:text-white sm:text-3xl">
                    Envia tu proyecto
                </h1>
                <div class="w-80">
                    <p class="mt-4 text-center text-base text-zinc-700 dark:text-zinc-300">
                        Envia tu proyecto para que sea revisado y aprobado por el comité.
                    </p>
                </div>
                <form action="{{ Route('proyectos.store') }}" class="w-full max-w-sm" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mt-4">
                        <x-input type="text" icon="folder" name="name" id="name" required
                            placeholder="Ingresa el nombre del proyecto" label="Proyecto" />
                    </div>
                    <div class="mt-4 flex flex-1 flex-col">
                        <x-select name="community_id" id="community_id" required label="Comunidad" icon="home"
                            :options="$comunidades->pluck('name', 'id')->toArray()" />
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
                    <div class="mt-6">
                        <x-button type="submit" icon="send" class="w-full" text="Enviar proyecto"
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
