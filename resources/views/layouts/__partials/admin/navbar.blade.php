<header>
    <div
        class="ms-0 flex items-center justify-end gap-4 border-b border-zinc-400 px-4 py-3 dark:border-zinc-800 md:ms-64">
        <button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar"
            type="button"
            class="me-auto inline-flex items-center rounded-lg p-2 text-sm text-zinc-500 hover:bg-zinc-100 focus:outline-none focus:ring-2 focus:ring-zinc-200 dark:text-zinc-400 dark:hover:bg-zinc-700 dark:focus:ring-zinc-600 sm:hidden">
            <span class="sr-only">Open sidebar</span>
            <svg class="size-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path clip-rule="evenodd" fill-rule="evenodd"
                    d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                </path>
            </svg>
        </button>

        <div class="flex items-center gap-4">
            <x-toggle-theme />
            <div>
                <div class="relative">
                    <button type="button" class="flex items-center gap-2" id="profile-btn">
                        <img src="{{ Storage::url($user->scholarship->photo) }}" alt="{{ $user->name }}"
                            class="h-10 w-10 rounded-full object-cover">
                        <div class="hidden flex-col items-start sm:flex">
                            <span class="text-xs font-medium text-orange-500">Hola,</span>
                            <span class="text-sm font-bold text-zinc-700 dark:text-white">{{ $user->user }}</span>
                        </div>
                        <x-icon icon="arrow-down" class="h-4 w-4 text-zinc-700 dark:text-zinc-400" />
                    </button>
                    <div class="absolute right-0 top-12 hidden w-44 rounded-xl border border-zinc-400 bg-white p-2 shadow-md dark:border-zinc-900 dark:bg-zinc-950"
                        id="profile-dropdown">
                        <ul class="flex flex-col">
                            <li>
                                <a href="{{ Route('admin.profile') }}"
                                    class="flex items-center gap-2 rounded-lg p-2 px-4 py-2 text-sm text-zinc-800 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:bg-zinc-900/50">
                                    <x-icon icon="user" class="h-5 w-5" />
                                    Perfil
                                </a>
                            </li>
                            <li>
                                <form action="{{ Route('logout') }}" method="POST"
                                    class="flex items-center justify-center">
                                    @csrf
                                    <button href=""
                                        class="flex w-full items-center gap-2 rounded-lg p-2 px-4 py-2 text-sm text-zinc-800 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:bg-zinc-900/50">
                                        <x-icon icon="login" class="h-5 w-5" />
                                        Cerrar sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($maintenance->value == 1)
        <div
            class="ms-0 flex items-center gap-2 border-b border-zinc-400 bg-yellow-100 p-4 dark:border-zinc-800 dark:bg-yellow-950/30 md:ms-64">
            <x-icon icon="exclamation-circle" class="h-5 w-5 text-yellow-500" />
            <span class="text-sm font-bold text-yellow-500">Modo mantenimiento activado</span>
        </div>
    @elseif($project_mode->value == 1)
        <div
            class="ms-0 flex items-center gap-2 border-b border-zinc-400 bg-green-100 p-4 dark:border-zinc-800 dark:bg-green-950/30 md:ms-64">
            <x-icon icon="info-circle" class="h-5 w-5 text-green-500" />
            <span class="text-sm font-bold text-green-500">Modo proyecto activado</span>
        </div>
    @elseif($question_mode->value == 1)
        <div
            class="ms-0 flex items-center gap-2 border-b border-zinc-400 bg-green-100 p-4 dark:border-zinc-800 dark:bg-green-950/30 md:ms-64">
            <x-icon icon="info-circle" class="h-5 w-5 text-green-500" />
            <span class="text-sm font-bold text-green-500">Modo preguntas activado</span>
        </div>
    @endif

    <aside id="default-sidebar"
        class="z-35 fixed left-0 top-0 h-screen w-64 -translate-x-full bg-zinc-950 transition-transform dark:bg-transparent md:translate-x-0 md:bg-transparent"
        aria-label="Sidenav">
        <div class="h-full overflow-y-auto border-r border-zinc-400 px-3 py-5 dark:border-zinc-800">
            <div class="flex items-center gap-2 p-2">
                <img class="h-5 w-auto sm:h-7" src="{{ asset('images/cis-logo.webp') }}" alt="Logo CIS">
                <h2 class="text-2xl font-bold text-zinc-800 dark:text-zinc-400">
                    CIS
                </h2>
            </div>
            <ul class="relative mt-2 flex flex-col gap-2">
                <li>
                    <a href="{{ Route('admin.dashboard') }}"
                        class="{{ \App\Helpers\RouteHelper::isActive(['admin.dashboard']) }} group flex items-center rounded-lg p-2 text-base font-normal text-zinc-900 hover:bg-orange-100 hover:text-orange-500 dark:text-white dark:hover:bg-orange-950/30 dark:hover:text-orange-500">
                        <x-icon icon="dashboard" class="size-5 text-current" />
                        <span class="ml-3">
                            Dashboard
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ Route('admin.becados.index') }}"
                        class="{{ \App\Helpers\RouteHelper::isActive(['admin.becados.index', 'admin.becados.create', 'admin.becados.edit']) }} group flex items-center rounded-lg p-2 text-base font-normal text-zinc-900 hover:bg-orange-100 hover:text-orange-500 dark:text-white dark:hover:bg-orange-950/30 dark:hover:text-orange-500">
                        <x-icon icon="school" class="size-5 text-current" />
                        <span class="ml-3">
                            Becados
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ Route('admin.proyectos.index') }}"
                        class="{{ \App\Helpers\RouteHelper::isActive(['admin.proyectos.index', 'admin.proyectos.asignar', 'admin.proyectos.reportes', 'admin.reportes.show']) }} group flex items-center rounded-lg p-2 text-base font-normal text-zinc-900 hover:bg-orange-100 hover:text-orange-500 dark:text-white dark:hover:bg-orange-950/30 dark:hover:text-orange-500">
                        <x-icon icon="folder" class="size-5 text-current" />
                        <span class="ml-3">
                            Proyectos
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ Route('admin.comunidades.index') }}"
                        class="{{ \App\Helpers\RouteHelper::isActive(['admin.comunidades.index']) }} group flex items-center rounded-lg p-2 text-base font-normal text-zinc-900 hover:bg-orange-100 hover:text-orange-500 dark:text-white dark:hover:bg-orange-950/30 dark:hover:text-orange-500">
                        <x-icon icon="home" class="size-5 text-current" />
                        <span class="ml-3">
                            Comunidades
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ Route('admin.usuarios.index') }}"
                        class="{{ \App\Helpers\RouteHelper::isActive(['admin.usuarios.index', 'admin.usuarios.edit', 'admin.usuarios.create']) }} flex items-center rounded-lg p-2 text-base font-normal text-zinc-900 hover:bg-orange-100 hover:text-orange-500 dark:text-white dark:hover:bg-orange-950/30 dark:hover:text-orange-500">
                        <x-icon icon="users" class="size-5 text-current" />
                        <span class="ml-3">
                            Usuarios
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ Route('admin.preguntas.index') }}"
                        class="{{ \App\Helpers\RouteHelper::isActive(['admin.preguntas.index']) }} flex items-center rounded-lg p-2 text-base font-normal text-zinc-900 hover:bg-orange-100 hover:text-orange-500 dark:text-white dark:hover:bg-orange-950/30 dark:hover:text-orange-500">
                        <x-icon icon="question-mark" class="size-5 text-current" />
                        <span class="ml-3">
                            Preguntas
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ Route('admin.respuestas.index') }}"
                        class="{{ \App\Helpers\RouteHelper::isActive(['admin.respuestas.index']) }} flex items-center rounded-lg p-2 text-base font-normal text-zinc-900 hover:bg-orange-100 hover:text-orange-500 dark:text-white dark:hover:bg-orange-950/30 dark:hover:text-orange-500">
                        <x-icon icon="message-reply" class="size-5 text-current" />
                        <span class="ml-3">
                            Respuestas
                        </span>
                    </a>
                </li>
            </ul>
        </div>
        <div
            class="absolute bottom-0 left-0 z-20 flex w-full flex-col items-center justify-center gap-4 space-x-4 border-r border-t border-zinc-400 bg-white p-4 dark:border-zinc-800 dark:bg-zinc-950">
            <form action="{{ Route('logout') }}" method="POST" class="flex items-center justify-center">
                @csrf
                <x-button type="submit" icon="login" typeButton="secondary" text="Cerrar sesión"
                    size="small" />
            </form>
        </div>
    </aside>
</header>
