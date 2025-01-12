<form action="{{ Route('admin.preguntas.update', $ask->id) }}" method="POST">
    @csrf
    @method('PUT')
    <x-input type="text" placeholder="¿Pregunta?" name="title" icon="help-hexagon" label="Pregunta" required
        value="{{ $ask->title }}" />
    <x-input type="textarea" placeholder="Descripción" name="description" label="Descripción" required className="mt-4"
        value="{{ $ask->description }}" />
    <div class="mt-4">
        <label
            class="block text-sm font-medium text-zinc-500 after:ml-0.5 after:text-red-500 after:content-['*'] dark:text-zinc-300">
            Nivel
        </label>
        <div class="mt-2 flex flex-wrap items-center gap-4">
            <x-input type="checkbox" label="Universidad" name="level[]" value="Universidad" :checked="$ask->levels->contains('level', 'Universidad')" />
            <x-input type="checkbox" label="Educación Básica" name="level[]" value="Educación Básica"
                :checked="$ask->levels->contains('level', 'Educación Básica')" />
            <x-input type="checkbox" label="Bachillerato Vocacional" name="level[]" value="Bachillerato Vocacional"
                :checked="$ask->levels->contains('level', 'Bachillerato Vocacional')" />
            <x-input type="checkbox" label="Bachillerato General" name="level[]" value="Bachillerato General"
                :checked="$ask->levels->contains('level', 'Bachillerato General')" />
            <x-input type="checkbox" label="Técnico Universitario u otro" name="level[]"
                value="Técnico Universitario u otro" :checked="$ask->levels->contains('level', 'Técnico Universitario u otro')" />
        </div>
    </div>
    <div class="mt-4">
        <label
            class="block text-sm font-medium text-zinc-500 after:ml-0.5 after:text-red-500 after:content-['*'] dark:text-zinc-300">
            Tipo
        </label>
        <div class="mt-4 flex flex-wrap items-center gap-4">
            <x-input type="checkbox" label="Nuevo ingreso" name="type" value="new_entry" :checked="$ask->levels->contains('type', 'new_entry')" />
            <x-input type="checkbox" label="Antiguo ingreso" name="type" value="old_entrance" :checked="$ask->levels->contains('type', 'old_entrance')" />
            />
        </div>
    </div>
    <x-input type="text" label="Máximo de caracteres" placeholder="#" icon="number" name="max_characters" required
        className="mt-4" value="{{ $ask->max_characters }}" />
    <div class="mt-6 flex items-center justify-center gap-4">
        <x-button type="submit" text="Editar" icon="pencil" typeButton="primary" />
    </div>
</form>
