@extends('layouts.template')
@section('title', 'CIS | Responder preguntas')
@section('content')
    <section>
        <div class="container mx-auto flex min-h-screen flex-col items-center justify-center p-6">
            <img class="mx-auto size-14 w-auto sm:size-20" src="{{ asset('images/cis-logo.webp') }}" alt="Logo CIS">
            @if ($asks)
                <div class="flex w-full flex-col items-center justify-center sm:w-[90%] md:w-[80%] lg:w-[75%] xl:w-[60%]">
                    <h1 class="mt-3 text-center text-2xl font-semibold uppercase text-gray-800 dark:text-white sm:text-3xl">
                        Responder tus preguntas
                    </h1>
                    <div class="w-full">
                        <p class="mt-4 text-center text-base text-zinc-700 dark:text-zinc-300">
                            Responde las siguientes preguntas. Cuando las envies antento a la respuesta del cómite para
                            validar si cada pregunta esta bien respondida.
                        </p>
                    </div>
                    <div class="mt-4">
                        <form action="" class="flex flex-col gap-6" id="form-questions" method="POST">
                            @csrf
                            @foreach ($asks as $ask)
                                <x-input type="textarea" legend="{{ $ask->description }}"
                                    label="{{ $loop->iteration . '. ' . $ask->title }}" name="{{ $ask->id }}" required
                                    placeholder="Escribe tu respuesta..." class="input-question"
                                    minleght="{{ $ask->max_characters }}" />
                            @endforeach
                            <div class="flex items-center justify-center gap-4">
                                <x-button type="submit" typeButton="primary" text="Enviar preguntas" icon="send" />
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
