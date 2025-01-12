@extends('layouts.template')
@section('title', 'CIS | Responder preguntas')
@section('content')
    <section>
        <div class="container mx-auto flex min-h-screen flex-col items-center justify-center p-4">
            <img class="mx-auto size-14 w-auto sm:size-20" src="{{ asset('images/cis-logo.webp') }}" alt="Logo CIS">
            @if ($asks)
                <div class="flex w-full flex-col items-center justify-center sm:w-[90%] md:w-[80%] lg:w-[75%] xl:w-[60%]">
                    <h1 class="mt-3 text-center text-2xl font-semibold uppercase text-gray-800 dark:text-white sm:text-3xl">
                        Responder tus preguntas ({{ $asks->count() }})
                    </h1>
                    <div class="w-full">
                        <p class="mt-4 text-center text-base text-zinc-700 dark:text-zinc-300">
                            Responde las siguientes preguntas. Cuando las envies antento a la respuesta del cómite para
                            validar si cada pregunta esta bien respondida.
                        </p>
                    </div>

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
                        <form
                            action="{{ $scholarship->answers && $scholarship->answers->count() > 0 ? Route('answers.update') : Route('answers.store') }}"
                            class="flex flex-col gap-6" id="form-questions" method="POST">
                            @csrf

                            @if ($scholarship->answers->count() > 0)
                                @method('PUT')
                            @endif

                            @if (!$scholarship->phone)
                                <x-input type="text" label="Teléfono" legend="Ingresa tu teléfono sin espacios."
                                    name="phone" required value="{{ old('phone') }}" placeholder="XXXXXXXX"
                                    class="input-question" icon="phone" />
                            @endif

                            @foreach ($asks as $ask)
                                @php
                                    $read = $ask->answers->first()?->status === 'approved' ? 'readonly' : '';
                                @endphp
                                <div class="flex flex-col gap-2">
                                    <x-input type="hidden" name="answers[{{ $loop->index }}][ask_id]"
                                        value="{{ $ask->id }}" />
                                    <x-input type="textarea" legend="{{ $ask->description }}"
                                        label="{{ $loop->iteration . '. ' . $ask->title }}" :readonly="$read"
                                        name="answers[{{ $loop->index }}][content]" required
                                        data-error="#error-question-{{ $loop->iteration }}"
                                        value="{{ old('answers.' . $loop->index . '.content', $ask->answers->first()?->content) }}"
                                        placeholder="Escribe tu respuesta..." class="input-question" minlength="10" />
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
                            @endforeach
                            <input type="hidden" name="id"
                                value="{{ $scholarship->answers->count() > 0 ? $scholarship->answers->first()->id : '' }}">
                            @if (!$scholarship->answers->every(fn($answer) => $answer->status === 'approved'))
                                <div class="flex items-center justify-center gap-4">
                                    <x-button type="submit" typeButton="primary" text="Enviar preguntas" icon="send" />
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
