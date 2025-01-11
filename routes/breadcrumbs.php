<?php

use App\Models\Project;
use App\Models\Report;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use Illuminate\Support\Facades\Blade;

Breadcrumbs::for("admin.dashboard", function (BreadcrumbTrail $trail) {
    $icon = Blade::render("<x-icon icon='dashboard' class='w-4 h-4'/>");
    $trail->push($icon . "Dashboard", route("admin.dashboard"));
});

Breadcrumbs::for("admin.becados.index", function (BreadcrumbTrail $trail) {
    $icon = Blade::render("<x-icon icon='users' class='w-4 h-4'/>");
    $trail->parent("admin.dashboard");
    $trail->push($icon . "Becados", route("admin.becados.index"));
});

Breadcrumbs::for("admin.becados.create", function (BreadcrumbTrail $trail) {
    $icon = Blade::render("<x-icon icon='user-plus' class='w-4 h-4'/>");
    $trail->parent("admin.becados.index");
    $trail->push($icon . "Nuevo becado", route("admin.becados.create"));
});

Breadcrumbs::for("admin.becados.edit", function (BreadcrumbTrail $trail, $becado) {
    $icon = Blade::render("<x-icon icon='user-edit' class='w-4 h-4'/>");
    $trail->parent("admin.becados.index");
    $trail->push($icon . "Editar becado", route("admin.becados.edit", $becado));
});

Breadcrumbs::for("admin.comunidades.index", function (BreadcrumbTrail $trail) {
    $icon = Blade::render("<x-icon icon='home' class='w-4 h-4'/>");
    $trail->parent("admin.dashboard");
    $trail->push($icon . "Comunidades", route("admin.comunidades.index"));
});

Breadcrumbs::for("admin.proyectos.index", function (BreadcrumbTrail $trail) {
    $icon = Blade::render("<x-icon icon='folder' class='w-4 h-4'/>");
    $trail->parent("admin.dashboard");
    $trail->push($icon . "Proyectos", route("admin.proyectos.index"));
});

Breadcrumbs::for("admin.proyectos.create", function (BreadcrumbTrail $trail) {
    $icon = Blade::render("<x-icon icon='folder-plus' class='w-4 h-4'/>");
    $trail->parent("admin.proyectos.index");
    $trail->push($icon . "Nuevo proyecto", route("admin.proyectos.create"));
});

Breadcrumbs::for("admin.proyectos.show", function (BreadcrumbTrail $trail, $slug) {
    $icon = Blade::render("<x-icon icon='folder' class='w-4 h-4'/>");
    $trail->parent("admin.proyectos.index");
    $trail->push($icon . "Detalles del proyecto", route("admin.proyectos.show", $slug));
});

Breadcrumbs::for("admin.proyectos.edit", function (BreadcrumbTrail $trail, $slug) {
    $icon = Blade::render("<x-icon icon='pencil' class='w-4 h-4'/>");
    $trail->parent("admin.proyectos.index");
    $trail->push($icon . "Editar proyecto", route("admin.proyectos.edit", $slug));
});

Breadcrumbs::for("admin.proyectos.asignar", function (BreadcrumbTrail $trail, $slug) {
    $icon = Blade::render("<x-icon icon='user-up' class='w-4 h-4'/>");
    $trail->parent("admin.proyectos.index");
    $trail->push($icon . "Asignar becados", route("admin.proyectos.asignar", $slug));
});

Breadcrumbs::for("admin.reportes.index", function (BreadcrumbTrail $trail, $slug) {
    $icon = Blade::render("<x-icon icon='files' class='w-4 h-4'/>");
    $trail->parent("admin.proyectos.index");
    $trail->push($icon . "Reportes", route("admin.reportes.index", $slug));
});

Breadcrumbs::for("admin.reportes.show", function (BreadcrumbTrail $trail, $id) {
    $icon = Blade::render("<x-icon icon='file' class='w-4 h-4'/>");
    $report = Report::findOrFail($id);
    $trail->parent("admin.reportes.index", $report->project->slug);
    $trail->push($icon . "Reporte de " . $report->month, route("admin.reportes.show", $id));
});

Breadcrumbs::for("admin.usuarios.index", function (BreadcrumbTrail $trail) {
    $icon = Blade::render("<x-icon icon='users' class='w-4 h-4'/>");
    $trail->parent("admin.dashboard");
    $trail->push($icon . "Usuarios", route("admin.usuarios.index"));
});

Breadcrumbs::for("admin.usuarios.create", function (BreadcrumbTrail $trail) {
    $icon = Blade::render("<x-icon icon='user-plus' class='w-4 h-4'/>");
    $trail->parent("admin.usuarios.index");
    $trail->push($icon . "Nuevo usuario", route("admin.usuarios.create"));
});

Breadcrumbs::for("admin.usuarios.edit", function (BreadcrumbTrail $trail, $usuario) {
    $icon = Blade::render("<x-icon icon='user-edit' class='w-4 h-4'/>");
    $trail->parent("admin.usuarios.index");
    $trail->push($icon . "Editar usuario", route("admin.usuarios.edit", $usuario));
});

Breadcrumbs::for("admin.profile", function (BreadcrumbTrail $trail) {
    $icon = Blade::render("<x-icon icon='user' class='w-4 h-4'/>");
    $trail->parent("admin.dashboard");
    $trail->push($icon . "Perfil", route("admin.profile"));
});

Breadcrumbs::for("admin.preguntas.index", function (BreadcrumbTrail $trail) {
    $icon = Blade::render("<x-icon icon='question-mark' class='w-4 h-4'/>");
    $trail->parent("admin.dashboard");
    $trail->push($icon . "Preguntas", route("admin.preguntas.index"));
});