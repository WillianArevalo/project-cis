<?php

use App\Http\Controllers\BecadoController;
use App\Http\Controllers\ComunidadController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(LoginController::class)->group(function () {
    Route::get("/", "index")->name("login");
    Route::post("/validate", "validate")->name("login.validate");
    Route::post("/logout", "logout")->name("logout");
});

Route::middleware("auth")->group(function () {
    Route::get("/inicio", [HomeController::class, "index"])->name("home");

    Route::get("/enviar-reporte", [ReporteController::class, "create"])->name("reporte.create");
});

Route::middleware("role:admin")->prefix("admin")->name("admin.")->group(function () {
    Route::get("/", [DashboardController::class, "index"])->name("dashboard");

    //Routes for scholarships
    Route::get("/becados", [BecadoController::class, "index"])->name("becados.index");
    Route::get("/becados/nuevo", [BecadoController::class, "create"])->name("becados.create");
    Route::post("/becados", [BecadoController::class, "store"])->name("becados.store");
    Route::get("/becados/{id}/editar", [BecadoController::class, "edit"])->name("becados.edit");
    Route::put("/becados/{id}", [BecadoController::class, "update"])->name("becados.update");
    Route::delete("/becados/{id}", [BecadoController::class, "destroy"])->name("becados.destroy");

    //Routes for communities
    Route::get("/comunidades", [ComunidadController::class, "index"])->name("comunidades.index");
    Route::post("/comunidades", [ComunidadController::class, "store"])->name("comunidades.store");
    Route::delete("/comunidades/{id}", [ComunidadController::class, "destroy"])->name("comunidades.destroy");
    Route::get("/comunidades/{id}/edit", [ComunidadController::class, "edit"])->name("comunidades.edit");
    Route::put("/comunidades/{id}", [ComunidadController::class, "update"])->name("comunidades.update");

    //Routes for projects
    Route::get("/proyectos", [ProyectoController::class, "index"])->name("proyectos.index");
    Route::post("/proyectos", [ProyectoController::class, "store"])->name("proyectos.store");
    Route::get("/proyectos/{id}/edit", [ProyectoController::class, "edit"])->name("proyectos.edit");
    Route::put("/proyectos/{id}", [ProyectoController::class, "update"])->name("proyectos.update");
    Route::delete("/proyectos/{id}", [ProyectoController::class, "destroy"])->name("proyectos.destroy");
    Route::get("/proyectos/{id}/asignar", [ProyectoController::class, "assign"])->name("proyectos.asignar");
    Route::post("/proyectos/{id}/asignar", [ProyectoController::class, "assignStore"])->name("proyectos.asignar.store");

    //Routes for users
    Route::get("/usuarios", [UserController::class, "index"])->name("usuarios.index");
    Route::get("/usuarios/nuevo", [UserController::class, "create"])->name("usuarios.create");
    Route::post("/usuarios", [UserController::class, "store"])->name("usuarios.store");
    Route::get("/usuarios/{id}/edit", [UserController::class, "edit"])->name("usuarios.edit");
    Route::put("/usuarios/{id}", [UserController::class, "update"])->name("usuarios.update");
    Route::delete("/usuarios/{id}", [UserController::class, "destroy"])->name("usuarios.destroy");
});