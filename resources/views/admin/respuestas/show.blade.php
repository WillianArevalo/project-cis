@extends('layouts.admin-template')
@section('title', 'CIS | Becados')
@section('content')
    <section class="p-4">
        @include('layouts.__partials.admin.header', [
            'title' => 'Respuestas de ' . $scholarship->name,
            'icon' => 'question',
        ])
        <div class="mt-4">
            <div class="flex flex-col gap-6">
                @foreach ($asks as $ask)
                    <div class="flex w-full flex-col gap-2 md:w-3/4">
                        <div class="flex items-start gap-2">
                            @if ($ask->answers->first()?->status === 'approved')
                                <x-icon icon="circle-check" class="mt-1 size-5 text-green-500 dark:text-green-400" />
                            @endif
                            @if ($ask->answers->first()?->status === 'pending')
                                <x-icon icon="clock"
                                    class="mt-1 size-5 max-h-5 min-h-5 min-w-5 max-w-5 text-yellow-500 dark:text-yellow-400" />
                            @endif
                            @if ($ask->answers->first()?->status === 'rejected')
                                <x-icon icon="circle-x"
                                    class="mt-1 size-5 max-h-5 min-h-5 min-w-5 max-w-5 text-red-500 dark:text-red-400" />
                            @endif
                            <h2 class="text-base font-semibold text-zinc-800 dark:text-zinc-200 sm:text-lg">
                                {{ $loop->iteration . '. ' . $ask->title }}
                            </h2>
                        </div>
                        <p class="text-wrap text-xs text-zinc-500 dark:text-zinc-400">
                            {{ $ask->description }}
                        </p>
                        @if ($ask->answers->first()?->content)
                            <p class="text-wrap text-sm text-zinc-500 dark:text-zinc-400">
                                {{ $ask->answers->first()?->content }}
                            </p>
                            <div class="mt-4 flex gap-4">
                                <form action="{{ Route('admin.respuestas.change-status', $ask->answers->first()?->id) }}"
                                    method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="approved">
                                    <x-button type="submit" typeButton="primary" size="small" text="Aprobada"
                                        icon="circle-check" />
                                </form>
                                @if ($ask->answers->first()?->status !== 'rejected')
                                    <form
                                        action="{{ Route('admin.respuestas.change-status', $ask->answers->first()?->id) }}"
                                        method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="rejected">
                                        <x-button type="submit" typeButton="secondary" size="small" text="Rechazada"
                                            icon="close" />
                                    </form>
                                @else
                                    <x-button type="button" typeButton="secondary" class="btn-add-note" size="small"
                                        data-modal-target="modal-new-note" data-modal-toggle="modal-new-note"
                                        text="Agregar nota" icon="plus" data-id="{{ $ask->answers->first()?->id }}" />
                                @endif
                            </div>
                        @else
                            <p
                                class="text-wrap rounded-xl border border-dashed border-red-500 p-4 text-center text-sm text-red-500 dark:border-red-500 dark:text-red-500">
                                Sin respuesta
                            </p>
                        @endif

                        @if ($ask->answers->first()?->notes->count() > 0)
                            <div class="mt-4">
                                <h3 class="text-base font-semibold text-zinc-800 dark:text-zinc-200">
                                    Notas
                                </h3>
                                <div class="mt-2 flex flex-col gap-4">
                                    @foreach ($ask->answers->first()?->notes as $note)
                                        <div class="ms-4 flex items-center gap-2">
                                            <p class="text-wrap text-sm text-zinc-500 dark:text-zinc-400">
                                                {{ $note->content }}
                                            </p>
                                            <div>
                                                <form action="{{ Route('admin.notas.destroy', $note->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-button type="submit" typeButton="secondary" size="small" onlyIcon
                                                        icon="trash" />
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <div id="modal-new-note" tabindex="-1" aria-hidden="true"
        class="fixed inset-0 z-50 hidden h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden bg-black bg-opacity-70">
        <div class="relative h-auto w-full max-w-md p-4">
            <!-- Modal content -->
            <div
                class="relative animate-jump-in rounded-lg bg-white p-4 shadow animate-duration-300 dark:bg-zinc-950 sm:p-5">
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
                        <x-button type="button" data-modal-toggle="modal-new-note" icon="close" typeButton="secondary"
                            text="Cancelar" />
                        <x-button type="submit" icon="save" typeButton="primary" text="Guardar" />
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
