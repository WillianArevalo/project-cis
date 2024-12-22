<?php

namespace App\Http\Controllers;

use App\Models\MonthlyReport;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $proyecto = Project::find($user->scholarship->project_id);
        $reportes = MonthlyReport::where("project_id", $user->scholarship->project_id)->get();
        Carbon::setLocale("es");
        $mes = Carbon::now()->translatedFormat("F");
        return view("usuario.index", compact("user", "reportes", "proyecto", "mes"));
    }
}