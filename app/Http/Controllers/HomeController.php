<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Report;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function __construct()
    {
        Carbon::setLocale("es");
    }

    public function index()
    {

        $user = User::with("scholarship")->find(auth()->id());
        $proyecto = Project::find($user->scholarship->project_id);
        $reportes = Report::where("project_id", $user->scholarship->project_id)->get();
        $mes = Carbon::now()->translatedFormat("F");
        $monthReport = Report::where("project_id", $user->scholarship->project_id)->where("month", $mes)->first();
        return view("usuario.index", compact("user", "reportes", "proyecto", "mes", "monthReport"));
    }
}
