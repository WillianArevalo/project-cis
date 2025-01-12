<?php

namespace App\Http\Controllers;

use App\Models\AskLevel;
use App\Models\Community;
use App\Models\Project;
use App\Models\Report;
use App\Models\Scholarship;
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
        $question_mode = Setting::where('key', 'question_mode')->first();

        if ($maintenance->value == 1) {
            return view('maintenance');
        }

        if ($project_mode->value == 1) {
            $comunidades = Community::all();
            $project = Project::where("sent_by", auth()->id())->first();
            $becados = Scholarship::all();
            return view('projects', compact('comunidades', 'project', 'becados'));
        }

        if ($question_mode->value == 1) {
            $scholarship = Scholarship::where("user_id", auth()->id())->first();
            $asks = $scholarship->asks()->with(['answers' => function ($query) use ($scholarship) {
                $query->where('scholarship_id', $scholarship->id);
            }])->get();
            return view('questions', compact('asks', 'scholarship'));
        }

        $user = User::with("scholarship")->find(auth()->id());
        if ($user->scholarship->project_id == null) {
            return redirect()->route("login")
                ->with("error_title", "No tienes un proyecto asignado")->with("error_message", "Por favor, contacta a tu administrador para asignarte un proyecto");
        }

        if ($user->scholarship->project->accept === 0) {
            return redirect()->route("login")
                ->with("error_title", "Proyecto no aceptado")
                ->with("error_message", "Tu proyecto todavía no ha sido aceptado por el cómite");
        }

        $proyecto = Project::find($user->scholarship->project_id);
        $reportes = Report::where("project_id", $user->scholarship->project_id)->get();
        $mes = Carbon::now()->translatedFormat("F");
        $monthReport = Report::where("project_id", $user->scholarship->project_id)->where("month", $mes)->first();
        return view("usuario.index", compact("user", "reportes", "proyecto", "mes", "monthReport"));
    }
}
