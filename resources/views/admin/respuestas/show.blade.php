@extends('layouts.admin-template')
@section('title', 'CIS | Ver respuestas')
@section('content')
    <section class="p-4">
        @include('layouts.__partials.admin.header', [
            'title' => 'Respuestas de ' . $scholarship->name,
            'icon' => 'question',
        ])
        <div class="mt-4">
            <div class="flex flex-col gap-6">

                @if ($asks)
                    @if ($errors->any())
                        <div class="mt-4 w-full">
                            <span
                                class="flex w-full flex-col items-center justify-center gap-4 rounded-xl border border-dashed border-red-500 bg-red-100 p-4 text-sm font-semibold text-red-500 dark:bg-red-950/30">
                                <div class="flex items-center gap-1 uppercase">
                                    Corrige los errores en el formulario
                                </div>
                                <div class="flex flex-col gap-4">
                                    @foreach ($errors->all() as $error)
                                        <span class="flex items-center gap-1 text-sm text-red-500 dark:text-red-400">
                                            <x-icon icon="circle-x" class="h-5 w-5" />
                                            {{ $error }}
                                        </span>
                                    @endforeach
                                </div>
                            </span>
                        </div>
                    @endif

                    @if ($scholarship->answers->count() > 0 && $scholarship->answers->every(fn($answer) => $answer->status === 'approved'))
                        <div class="mt-4 w-full">
                            <span
                                class="flex w-full items-center justify-center gap-1 rounded-xl border border-dashed border-green-500 bg-green-100 p-4 text-sm font-semibold uppercase text-green-500 dark:bg-green-950/30">
                                <x-icon icon="circle-check" class="h-5 w-5" />
                                Preguntas completadas
                            </span>
                        </div>
                    @endif
                    <div class="mt-4">
                        <form action="{{ Route('admin.answers.update') }}" class="flex flex-col gap-6" id="form-questions"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" value="{{ $scholarship->answers->first()->id }}">
                            <input type="hidden" name="scholarship_id" value="{{ $scholarship->id }}">
                            @foreach ($asks as $ask)
                                <div class="flex flex-col gap-2">
                                    <x-input type="hidden" name="answers[{{ $loop->index }}][ask_id]"
                                        value="{{ $ask->id }}" />
                                    <x-input type="textarea" legend="{{ $ask->description }}"
                                        label="{{ $loop->iteration . '. ' . $ask->title }}"
                                        name="answers[{{ $loop->index }}][content]"
                                        data-error="#error-question-{{ $loop->iteration }}"
                                        value="{{ old('answers.' . $loop->index . '.content', $ask->answers->first()?->content) }}"
                                        placeholder="Escribe tu respuesta..." class="input-question field-sizing"
                                        minlength="{{ $ask->max_characters }}" />
                                    <span id="error-question-{{ $loop->iteration }}"
                                        class="mt-2 hidden items-center gap-1 text-sm text-red-500">
                                        <x-icon icon="exclamation-circle" class="h-4 w-4" />
                                        <span class="error-msg text-red-500">Este campo es obligatorio</span>
                                    </span>
                                    @if ($ask->answers->count() > 0)
                                        @if ($ask->answers->first()->status === 'approved')
                                            <span
                                                class="mt-2 flex w-max items-center gap-1 rounded-full bg-green-100 px-2 py-1 text-sm text-green-500 dark:bg-green-950/30">
                                                <x-icon icon="circle-check" class="h-4 w-4" />
                                                Aprobada
                                            </span>
                                        @endif
                                        @if ($ask->answers->first()->status === 'pending')
                                            <span
                                                class="mt-2 flex w-max items-center gap-1 rounded-full bg-yellow-100 px-2 py-1 text-sm text-yellow-500 dark:bg-yellow-950/30">
                                                <x-icon icon="clock" class="h-4 w-4" />
                                                Pendiente
                                            </span>
                                        @endif
                                        @if ($ask->answers->first()->status === 'rejected')
                                            <span
                                                class="mt-2 flex w-max items-center gap-1 rounded-full bg-red-100 px-2 py-1 text-sm text-red-500 dark:bg-red-950/30">
                                                <x-icon icon="circle-x" class="h-4 w-4" />
                                                Rechazada
                                            </span>
                                        @endif
                                    @else
                                        <span
                                            class="mt-2 flex w-max items-center gap-1 rounded-full bg-yellow-100 px-2 py-1 text-sm text-yellow-500 dark:bg-yellow-950/30">
                                            <x-icon icon="clock" class="h-4 w-4" />
                                            Pendiente
                                        </span>
                                    @endif
                                    @if ($ask->answers->first()?->notes->count() > 0)
                                        <div class="mt-4">
                                            <h3 class="text-base font-semibold text-zinc-800 dark:text-zinc-200">
                                                Notas
                                            </h3>
                                            <div class="mt-2 flex flex-col gap-2">
                                                @foreach ($ask->answers->first()?->notes as $note)
                                                    <div class="flex items-start gap-2">
                                                        <p class="ms-4 text-wrap text-sm text-zinc-500 dark:text-zinc-400">
                                                            {{ $note->content }}
                                                        </p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                @if ($ask->answers->first()?->content)
                                    <div class="flex gap-4">
                                        <x-button type="button" typeButton="primary" size="small" text="Aprobada"
                                            icon="circle-check" class="btn-change-status"
                                            data-action="{{ Route('admin.respuestas.change-status', $ask->answers->first()?->id) }}"
                                            data-value="approved" />
                                        <x-button type="button"
                                            data-action="{{ Route('admin.respuestas.change-status', $ask->answers->first()?->id) }}"
                                            class="btn-change-status" typeButton="secondary" size="small"
                                            data-value="rejected" text="Rechazada" icon="close" />
                                    </div>
                                @endif
                            @endforeach
                            @if (
                                !$scholarship->answers->every(fn($answer) => $answer->status === 'approved') ||
                                    $scholarship->answers->count() === 0)
                                <div class="flex items-center justify-center gap-4">
                                    <x-button type="submit" typeButton="primary" text="Editar respuestas" icon="send"
                                        class="w-full sm:w-auto" />
                                </div>
                            @endif
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <div id="modal-new-note" tabindex="-1" aria-hidden="true"
        class="fixed inset-0 z-50 hidden h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden bg-black bg-opacity-70">
        <div class="relative h-auto w-full max-w-md p-4">
            <!-- Modal content -->
            <div
                class="relative animate-fade-down rounded-lg bg-white p-4 shadow animate-duration-300 dark:bg-zinc-950 sm:p-5">
                <!-- Modal header -->
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">
                        Agregar nota
                    </h3>
                    <button type="button"
                        class="ml-auto inline-flex items-center rounded-lg bg-transparent p-2 text-sm text-zinc-400 hover:bg-zinc-200 hover:text-zinc-900 dark:hover:bg-zinc-900 dark:hover:text-white"
                        data-modal-toggle="modal-new-note">
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
                <form action="{{ Route('admin.notas.store') }}" method="POST">
                    @csrf
                    <div class="mt-4 flex flex-1 flex-col">
                        <input type="hidden" name="answer_id" id="answer_id">
                        <x-input type="textarea" name="content" placeholder="Ingresa la nota" required />
                    </div>
                    <div class="mt-4 flex justify-end gap-4">
                        <x-button type="button" data-modal-toggle="modal-new-note" icon="close"
                            typeButton="secondary" text="Cancelar" />
                        <x-button type="submit" icon="save" typeButton="primary" text="Guardar" />
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
