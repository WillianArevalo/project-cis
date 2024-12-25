<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\Project;
use App\Models\Report;
use App\Models\Scholarship;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function __construct()
    {
        Carbon::setLocale("es");
    }

    public function index()
    {
        $countUsuarios = User::count();
        $countBecados = Scholarship::count();
        $countProyectos = Project::count();
        $countComunidades = Community::count();
        $mes = Carbon::now()->translatedFormat("F");
        $reportes = Report::where("month", $mes)->get();
        $proyectos = Project::all();

        return view("admin.dashboard.index", [
            "countUsuarios" => $countUsuarios,
            "countBecados" => $countBecados,
            "countProyectos" => $countProyectos,
            "countComunidades" => $countComunidades,
            "reportes" => $reportes,
            "mes" => $mes,
            "proyectos" => $proyectos
        ]);
    }
}