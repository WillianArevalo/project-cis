    <form action="{{ Route('admin.proyectos.update', $proyecto->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mt-4 flex flex-1 flex-col">
            <x-input type="text" name="name" id="name" icon="folder" label="Nombre"
                placeholder="Nombre del proyecto" value="{{ $proyecto->name }}" />
        </div>
        <div class="mt-4 flex flex-1 flex-col">
            <x-select name="community_id" id="community_id_edit" label="Comunidad" icon="home" :options="$comunidades->pluck('name', 'id')->toArray()"
                value="{{ $proyecto->community_id }}" selected="{{ $proyecto->community_id }}" />
        </div>
        <div class="mt-4">
            <x-input type="checkbox" name="accept" id="accept" label="Aceptado" value="1"
                checked="{{ $proyecto->status }}" />
        </div>
        <div class="mt-4 flex justify-end gap-4">
            <x-button type="submit" icon="pencil" typeButton="primary" text="Editar" />
        </div>
    </form>
