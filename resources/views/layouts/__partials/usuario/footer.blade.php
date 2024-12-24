<footer>
    <div
        class="flex flex-col items-center justify-between gap-y-4 py-4 text-sm text-gray-500 dark:text-gray-400 sm:flex-row sm:items-start">
        <p>&copy; {{ date('Y') }} Todos los derechos reservados</p>
        <p>
            Centro de Intercambio y Solidaridad
        </p>
    </div>
    <div class="mb-4 flex items-center justify-between gap-1 text-xs text-gray-500 dark:text-gray-400">
        <div class="flex items-center gap-1">
            <p>
                Desarrollado por
            </p>
            <a href="https://github.com/WillianArevalo" class="text-blue-500 hover:underline" target="_blank">Willian
                Arévalo
            </a>
        </div>
        <x-toggle-theme />
    </div>
</footer>
