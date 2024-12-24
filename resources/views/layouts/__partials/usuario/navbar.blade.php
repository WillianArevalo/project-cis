@php
    $user = auth()->user();
@endphp
<header class="p-4">
    <nav class="flex justify-between">
        <div class="flex">
            <img src="{{ asset('images/cis-logo.webp') }}" alt="Logo CIS" class="h-10 w-10 rounded-full object-cover">
            <ul class="ms-14 flex items-center gap-10 dark:text-white">
                <li>
                    <a href=""
                        class="{{ Route::is('home') ? 'text-primary underline' : '' }} flex items-center gap-2 hover:text-primary hover:underline">
                        <x-icon icon="home" class="h-5 w-5" />
                        Inicio
                    </a>
                </li>
                <li>
                    <a href=""
                        class="{{ Route::is('reports') ? 'text-primary underline' : '' }} flex items-center gap-2 hover:text-primary hover:underline">
                        <x-icon icon="report" class="h-5 w-5" />
                        Reportes
                    </a>
                </li>
            </ul>
        </div>
        <div class="flex gap-4">
            <div class="ms-2 hidden rounded-full border border-zinc-400 px-2 py-1 dark:border-zinc-800 sm:block">
                <form action="" method="POST" class="flex items-center justify-center gap-2">
                    @csrf
                    <button type="button" data-theme="light"
                        class="theme-toggle theme-light flex items-center rounded-full p-2 hover:bg-zinc-200 dark:hover:bg-zinc-900">
                        <x-icon icon="sun" class="h-4 w-4 text-zinc-700 dark:text-white" />
                    </button>
                    <button type="button" data-theme="dark"
                        class="theme-toggle theme-dark flex items-center rounded-full p-2 hover:bg-zinc-200 dark:hover:bg-zinc-900">
                        <x-icon icon="moon" class="h-4 w-4 text-zinc-700 dark:text-white" />
                    </button>
                </form>
            </div>
            <div class="relative">
                <button type="button" class="flex items-center gap-2" id="profile-btn">
                    <img src="{{ Storage::url($user->scholarship->photo) }}" alt="{{ $user->name }}"
                        class="h-10 w-10 rounded-full object-cover">
                    <div class="flex flex-col">
                        <span class="text-xs font-medium text-primary dark:text-primary">Hola,</span>
                        <span class="text-sm font-bold text-zinc-700 dark:text-white">{{ $user->user }}</span>
                    </div>
                    <x-icon icon="arrow-down" class="h-4 w-4 text-zinc-700 dark:text-zinc-400" />
                </button>

                <div class="absolute right-0 top-12 hidden w-44 rounded-xl border border-zinc-400 bg-white p-2 shadow-md dark:border-zinc-800 dark:bg-black"
                    id="profile-dropdown">
                    <ul class="flex flex-col">
                        <li>
                            <a href=""
                                class="flex items-center gap-2 rounded-lg p-2 px-4 py-2 text-sm text-zinc-800 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:bg-zinc-950">
                                <x-icon icon="user" class="h-5 w-5" />
                                Perfil
                            </a>
                        </li>
                        <li>
                            <form action="{{ Route('logout') }}" method="POST"
                                class="flex items-center justify-center">
                                @csrf
                                <button href=""
                                    class="flex w-full items-center gap-2 rounded-lg p-2 px-4 py-2 text-sm text-zinc-800 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:bg-zinc-950">
                                    <x-icon icon="login" class="h-5 w-5" />
                                    Cerrar sesión
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>