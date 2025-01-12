<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\AskController;
use App\Http\Controllers\BecadoController;
use App\Http\Controllers\ComunidadController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(LoginController::class)->group(function () {
    Route::get("/", "index")->name("login");
    Route::post("/validate", "validate")->name("login.validate");
    Route::post("/logout", "logout")->name("logout");

    Route::get("/forgot-password", "forgotPassword")->name("forgot-password");
    Route::post("/send-email-reset-password", "emailResetPassword")->name("send-email-reset-password");
    Route::get("/correo-enviado", "confirmSendEmailResetPassword")->name("confirm-send-email-reset-password");
    Route::get("/reset-password", "resetPassword")->name("reset-password");
    Route::post("/change-password", "changePassword")->name("change-password");
});

Route::middleware("auth")->group(function () {
    Route::get("/inicio", [HomeController::class, "index"])->name("home");

    Route::get("/reportes", [ReporteController::class, "index"])->name("reportes.index");
    Route::get("/enviar-reporte", [ReporteController::class, "create"])->name("reportes.create");
    Route::post("/reporte", [ReporteController::class, "store"])->name("reportes.store");
    Route::get("/reporte", [ReporteController::class, "show"])->name("reportes.show");

    Route::get("/perfil", [ProfileController::class, "index"])->name("profile");
    Route::get("/verificar-correo", [ProfileController::class, "verifyEmail"])->name("profile.verifyEmail");
    Route::post("/cambiar-contraseña", [ProfileController::class, "changePassword"])->name("profile.change-password");

    Route::post("/enviar-correo", [EmailController::class, "send"])->name("sendEmail");
    Route::get("/verify-email", [EmailController::class, "verify"])->name("verifyEmail");

    Route::post("/proyectos", [ProyectoController::class, "store"])->name("proyectos.store");

    Route::post("/answers", [AnswerController::class, "store"])->name("answers.store");
    Route::put("/answers", [AnswerController::class, "update"])->name("answers.update");
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
    Route::get("/proyectos/create", [ProyectoController::class, "create"])->name("proyectos.create");
    Route::get("/proyectos/{slug}", [ProyectoController::class, "show"])->name("proyectos.show");
    Route::get("/proyectos/{id}/edit", [ProyectoController::class, "edit"])->name("proyectos.edit");
    Route::put("/proyectos/{id}", [ProyectoController::class, "update"])->name("proyectos.update");
    Route::delete("/proyectos/{id}", [ProyectoController::class, "destroy"])->name("proyectos.destroy");
    Route::get("/proyectos/{slug}/asignar", [ProyectoController::class, "assign"])->name("proyectos.asignar");
    Route::post("/proyectos/{id}/asignar", [ProyectoController::class, "assignStore"])->name("proyectos.asignar.store");
    Route::get("/proyecto/reportes/{slug}", [ReporteController::class, "index"])->name("reportes.index");

    //Routes for reports
    Route::get("/reporte/{id}", [ReporteController::class, "show"])->name("reportes.show");
    Route::delete("/reporte/{id}", [ReporteController::class, "destroy"])->name("reportes.destroy");

    //Routes for users
    Route::get("/usuarios", [UserController::class, "index"])->name("usuarios.index");
    Route::get("/usuarios/nuevo", [UserController::class, "create"])->name("usuarios.create");
    Route::post("/usuarios", [UserController::class, "store"])->name("usuarios.store");
    Route::get("/usuarios/{id}/edit", [UserController::class, "edit"])->name("usuarios.edit");
    Route::put("/usuarios/{id}", [UserController::class, "update"])->name("usuarios.update");
    Route::delete("/usuarios/{id}", [UserController::class, "destroy"])->name("usuarios.destroy");

    //Routes for ask's
    Route::get("/preguntas", [AskController::class, "index"])->name("preguntas.index");
    Route::post("/preguntas", [AskController::class, "store"])->name("preguntas.store");
    Route::get("/preguntas/{id}/edit", [AskController::class, "edit"])->name("preguntas.edit");
    Route::put("/preguntas/{id}", [AskController::class, "update"])->name("preguntas.update");
    Route::delete("/preguntas/{id}", [AskController::class, "destroy"])->name("preguntas.destroy");

    Route::get("/respuestas", [AnswerController::class, "index"])->name("respuestas.index");

    //Routes for answers
    Route::get("/respuestas/{id}", [AnswerController::class, "show"])->name("respuestas.show");
    Route::post("/respuesta/cambiar-estado/{id}", [AnswerController::class, "changeStatus"])->name("respuestas.change-status");

    //Routes for notes
    Route::resource("/notas", NoteController::class);

    Route::get("/perfil", [ProfileController::class, "admin"])->name("profile");
    Route::post("/configuracion", [ConfigurationController::class, "update"])->name("configuracion.update");
});
