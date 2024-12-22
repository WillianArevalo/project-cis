<header>
    <button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar"
        type="button"
        class="ml-3 mt-2 inline-flex items-center rounded-lg p-2 text-sm text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600 sm:hidden">
        <span class="sr-only">Open sidebar</span>
        <svg class="h-6 w-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd"
                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
            </path>
        </svg>
    </button>

    <aside id="default-sidebar"
        class="fixed left-0 top-0 z-40 h-screen w-64 -translate-x-full transition-transform sm:translate-x-0"
        aria-label="Sidenav">
        <div
            class="h-full overflow-y-auto border-r border-zinc-400 bg-white px-3 py-5 dark:border-zinc-800 dark:bg-zinc-950">
            <div class="flex items-center gap-2 p-2">
                <img class="h-5 w-auto sm:h-7" src="{{ asset('images/cis-logo.webp') }}" alt="Logo CIS">
                <h2 class="text-2xl font-bold text-zinc-800 dark:text-zinc-400">
                    CIS
                </h2>
            </div>
            <ul class="mt-2 space-y-2">
                <li>
                    <a href="{{ Route('admin.dashboard') }}"
                        class="group flex items-center rounded-lg p-2 text-base font-normal text-zinc-900 hover:bg-zinc-100 dark:text-white dark:hover:bg-zinc-900">
                        <x-icon icon="dashboard" class="h-6 w-6 text-zinc-400 dark:text-zinc-400" />
                        <span class="ml-3">
                            Dashboard
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ Route('admin.becados.index') }}"
                        class="group flex items-center rounded-lg p-2 text-base font-normal text-zinc-900 hover:bg-zinc-100 dark:text-white dark:hover:bg-zinc-900">
                        <x-icon icon="school" class="h-6 w-6 text-zinc-400 dark:text-zinc-400" />
                        <span class="ml-3">
                            Becados
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ Route('admin.proyectos.index') }}"
                        class="group flex items-center rounded-lg p-2 text-base font-normal text-zinc-900 hover:bg-zinc-100 dark:text-white dark:hover:bg-zinc-900">
                        <x-icon icon="folder" class="h-6 w-6 text-zinc-400 dark:text-zinc-400" />
                        <span class="ml-3">
                            Proyectos
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ Route('admin.comunidades.index') }}"
                        class="group flex items-center rounded-lg p-2 text-base font-normal text-zinc-900 hover:bg-zinc-100 dark:text-white dark:hover:bg-zinc-900">
                        <x-icon icon="home" class="h-6 w-6 text-zinc-400 dark:text-zinc-400" />
                        <span class="ml-3">
                            Comunidades
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ Route('admin.usuarios.index') }}"
                        class="group flex items-center rounded-lg p-2 text-base font-normal text-zinc-900 hover:bg-zinc-100 dark:text-white dark:hover:bg-zinc-900">
                        <x-icon icon="users" class="h-6 w-6 text-zinc-400 dark:text-zinc-400" />
                        <span class="ml-3">
                            Usuarios
                        </span>
                    </a>
                </li>
            </ul>
        </div>
        <div
            class="absolute bottom-0 left-0 z-20 flex w-full justify-center space-x-4 border-r border-t border-zinc-400 bg-white p-4 dark:border-zinc-800 dark:bg-zinc-950">
            <form action="{{ Route('logout') }}" method="POST" class="flex items-center justify-center">
                @csrf
                <x-button type="submit" icon="login" typeButton="secondary" text="Cerrar sesión" size="small" />
            </form>
        </div>
    </aside>
</header>
