<!-- Breadcrumb -->
@php $breadcrumbs = Breadcrumbs::generate(); @endphp
@if (!empty($breadcrumbs))
    <div class="flex items-center justify-center border-b border-zinc-400 dark:border-zinc-800 sm:justify-end">
        <nav class="flex w-max px-0 py-3 text-zinc-700 sm:px-6" aria-label="Breadcrumb">
            <ol
                class="inline-flex flex-wrap items-center justify-center gap-2 space-x-0 text-[10px] uppercase sm:gap-0 sm:text-xs md:space-x-2 rtl:space-x-reverse">
                @foreach ($breadcrumbs as $key => $breadcrumb)
                    @if ($breadcrumb->url && !$loop->last)
                        <li>
                            <div class="flex items-center gap-1 sm:gap-4">
                                <a href="{{ $breadcrumb->url }}"
                                    class="flex items-center gap-1 rounded-lg px-2 py-1 font-semibold text-zinc-500 hover:bg-orange-50 hover:text-orange-500 dark:text-zinc-400 dark:hover:bg-orange-950 dark:hover:bg-opacity-40 dark:hover:text-orange-500">
                                    {!! $breadcrumb->title !!}
                                </a>
                                <x-icon icon="arrow-right" class="mx-1 block h-5 w-5 text-zinc-400 rtl:rotate-180" />
                            </div>
                        </li>
                    @else
                        <li aria-current="page">
                            <div class="flex items-center">
                                <span
                                    class="ms-1 flex items-center gap-1 rounded-lg bg-orange-500 px-2 py-1 font-semibold text-white dark:bg-orange-950 dark:bg-opacity-40 dark:text-orange-500 md:ms-2">
                                    {!! $breadcrumb->title !!}
                                </span>
                            </div>
                        </li>
                    @endif
                @endforeach
            </ol>
        </nav>
    </div>
@endif
