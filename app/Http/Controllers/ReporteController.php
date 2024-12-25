<?php

namespace App\Http\Controllers;

use App\Mail\ReportsCompleted;
use App\Models\Project;
use App\Models\Report;
use App\Models\ReportImages;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class ReporteController extends Controller
{
    public function __construct()
    {
        Carbon::setLocale("es");
    }

    public function index(string $slug = null)
    {
        $user = auth()->user();
        if ($user->role === "admin") {
            return $this->reportesAdmin($slug);
        } else {
            return $this->reportesUser();
        }
    }

    public function reportesUser()
    {
        $user = auth()->user();
        $project = Project::find($user->scholarship->project_id);
        $reports = Report::where("project_id", $project->id)->get();
        $currentMonth = Carbon::now()->translatedFormat("F");
        $months = [
            "marzo",
            "abril",
            "mayo",
            "junio",
            "julio",
            "agosto",
            "septiembre",
            "octubre",
            "noviembre",
            "diciembre"
        ];

        $reportsByMonth = [];
        foreach ($months as $month) {
            $reportsByMonth[$month] = $reports->filter(function ($report) use ($month) {
                return $report->month == $month;
            });
        }

        return view("usuario.reportes.index", [
            "reports" => $reportsByMonth,
            "months" => $months,
            "project" => $project,
            "currentMonth" => $currentMonth
        ]);
    }

    public function reportesAdmin(string $slug)
    {
        $proyecto = Project::with('scholarships')->where('slug', $slug)->first();
        $reportes = Report::where('project_id', $proyecto->id)->get();
        return view('admin.proyectos.reportes', compact('proyecto', 'reportes'));
    }

    public function create(Request $request)
    {
        $mes = $request->input("mes");
        $proyecto = Project::find(auth()->user()->scholarship->project_id);
        return view("usuario.reportes.create", compact("proyecto", "mes"));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $user = auth()->user();
            $project = Project::find($user->scholarship->project_id);
            $currentMonth = Carbon::now()->translatedFormat("F");

            $report = Report::create([
                "project_id" => $project->id,
                "month" => $request->month,
                "theme" => $request->theme,
                "number_participants" => $request->number_participants,
                "description" => $request->description,
                "obstacles" => $request->obstacles,
                "sent_by" => $user->id,
                "date" => $request->date,
            ]);

            if ($request->hasFile("images")) {
                $images = $request->file("images");
                $directory = "reportes/{$project->slug}/{$request->month}";
                foreach ($images as $image) {
                    $path = $image->store($directory, "public");
                    ReportImages::create([
                        "report_id" => $report->id,
                        "path" => $path,
                    ]);
                }
            }

            DB::commit();

            $countProjects = Project::where("accept", 1)->count();
            $reportsCurrentsMonth = Report::where("month", $currentMonth)->count();

            if ($countProjects === $reportsCurrentsMonth) {
                $user = User::where("role", "admin")->first();
                Mail::to($user->email)->send(new ReportsCompleted($currentMonth));
            }

            return response()->json([
                "message" => "Reporte enviado correctamente",
                "redirect" => route("reportes.index")
            ]);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function show(Request $request, string $id = null)
    {
        $user = auth()->user();
        if ($user->role === "admin") {
            if ($id) {
                $report = Report::findOrFail($id);

                if (!$report) {
                    return redirect()->route("admin.proyectos.index")
                        ->with('error_title', 'Reporte no encontrado')
                        ->with('error_message', "No se ha encontrado el reporte solicitado");
                }

                return view("admin.proyectos.show-report", compact("report"));
            } else {
                return redirect()->route("admin.proyectos.index")
                    ->with('error_title', 'Reporte no encontrado')
                    ->with('error_message', "No se ha encontrado el reporte solicitado");
            }
        } else {
            $mes = $request->input("mes");
            if (!$mes) {
                return redirect()->route("reportes.index")
                    ->with("error_title", "Mes no especificado")
                    ->with("error_message", "No se ha especificado el mes del reporte");
            }
            $project = Project::find($user->scholarship->project_id);
            $report = Report::where("project_id", $project->id)->where("month", $mes)->first();
            if (!$report) {
                return redirect()->route("reportes.index")
                    ->with("error_title", "Reporte no encontrado")
                    ->with("error_message", "No se ha encontrado el reporte solicitado");
            }
            return view("usuario.reportes.show", compact("report"));
        }
    }

    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $report = Report::findOrFail($id);
            $report->delete();
            DB::commit();
            return redirect()->back()
                ->with('success_title', 'Reporte eliminado')
                ->with('success_message', 'El reporte se ha eliminado correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error_title', 'Error al eliminar el reporte')
                ->with('error_message', $e->getMessage());
        }
    }
}