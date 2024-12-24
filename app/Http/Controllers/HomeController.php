<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\Project;
use App\Models\Report;
use App\Models\Setting;
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
        $maintenance = Setting::where('key', 'maintenance')->first();
        $project_mode = Setting::where('key', 'project_mode')->first();

        if ($maintenance->value == 1) {
            return view('maintenance');
        }

        if ($project_mode->value == 1) {
            $comunidades = Community::all();
            return view('projects', compact('comunidades'));
        }

        $user = User::with("scholarship")->find(auth()->id());
        $proyecto = Project::find($user->scholarship->project_id);
        $reportes = Report::where("project_id", $user->scholarship->project_id)->get();
        $mes = Carbon::now()->translatedFormat("F");
        $monthReport = Report::where("project_id", $user->scholarship->project_id)->where("month", $mes)->first();
        return view("usuario.index", compact("user", "reportes", "proyecto", "mes", "monthReport"));
    }
}