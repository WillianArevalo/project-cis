@extends('layouts.admin-template')
@section('title', 'CIS | Respuestas')
@section('content')
    <section class="p-4">
        @include('layouts.__partials.admin.header', [
            'title' => 'Respuestas',
            'icon' => 'question',
        ])
        <div class="mt-4 flex flex-col gap-4 sm:flex-row">
            <div class="flex-1">
                <x-input type="text" placeholder="Buscar" icon="search" id="inputSearchAsk" />
            </div>
        </div>
        <div class="mt-4">
            <x-table id="tableAsks">
                <x-slot name="thead">
                    <x-tr>
                        <x-th class="w-10">
                            #
                        </x-th>
                        <x-th>
                            Becado
                        </x-th>
                        <x-th>
                            Repuestas
                        </x-th>
                        <x-th last="true">
                            Acciones
                        </x-th>
                    </x-tr>
                </x-slot>
                <x-slot name="tbody">
                    @if ($becados->count() > 0)
                        @foreach ($becados as $becado)
                            <x-tr>
                                <x-td>
                                    {{ $loop->iteration }}
                                </x-td>
                                <x-td>
                                    <div class="flex items-center gap-2">
                                        @if ($becado->photo)
                                            <img src="{{ Storage::url($becado->photo) }}" alt="{{ $becado->name }}"
                                                class="h-10 w-10 min-w-10 max-w-10 rounded-full object-cover">
                                        @else
                                            <img src="https://avatar.iran.liara.run/public" alt="Foto del becado"
                                                class="h-10 w-10 min-w-10 max-w-10 rounded-full object-cover">
                                        @endif
                                        <div>
                                            <p class="text-wrap font-semibold text-zinc-500 dark:text-zinc-400">
                                                {{ $becado->name }}
                                            </p>
                                        </div>
                                    </div>
                                </x-td>
                                <x-td>
                                    @php
                                        $totalAsks = $becado->asks->count();
                                        $approvedAnswersCount = $becado->answers->where('status', 'approved')->count();
                                        $remaining = $totalAsks - $approvedAnswersCount;
                                        $color = match (true) {
                                            $remaining === 1 => 'blue',
                                            $remaining >= 3 => 'red',
                                            default => 'yellow',
                                        };
                                    @endphp

                                    @if ($approvedAnswersCount === $totalAsks)
                                        <span
                                            class="flex w-max items-center gap-1 rounded-full bg-green-100 px-2 py-1 text-xs text-green-500 dark:bg-green-950/30 dark:text-green-400">
                                            <x-icon icon="circle-check" class="h-4 w-4" />
                                            Completadas
                                        </span>
                                    @else
                                        <span
                                            class="bg-{{ $color }}-100 text-{{ $color }}-500 dark:bg-{{ $color }}-950/30 dark:text-{{ $color }}-400 flex w-max items-center gap-1 rounded-full px-2 py-1 text-xs">
                                            <x-icon icon="info-circle" class="h-4 w-4" />
                                            Faltan {{ $remaining }} {{ $remaining === 1 ? 'respuesta' : 'respuestas' }}
                                        </span>
                                    @endif
                                </x-td>
                                <x-td>
                                    <div class="flex items-center gap-2">
                                        <x-button type="a" href="{{ Route('admin.respuestas.show', $becado->id) }}"
                                            typeButton="primary" icon="eye" onlyIcon />
                                        @if ($becado->phone)
                                            <x-button type="a"
                                                href="https://wa.me/503{{ $becado->phone }}?text={{ urlencode('Hola ' . $becado->name . ',tus preguntas han sido revisadas, por favor dales un vistazo: ') . urlencode(Route('home')) }}"
                                                target="_blank" typeButton="secondary" icon="whatsapp" onlyIcon />
                                        @endif
                                    </div>
                                </x-td>
                            </x-tr>
                        @endforeach
                    @endif
                </x-slot>
            </x-table>
        </div>
        <x-delete-modal modalId="deleteModal" title="¿Estás seguro de eliminar el becado?"
            message="No podrás recuperar este registro" />
    </section>
@endsection
