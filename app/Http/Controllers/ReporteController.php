<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Report;
use App\Models\ReportImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReporteController extends Controller
{
    public function __construct()
    {
        Carbon::setLocale("es");
    }

    public function index()
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

    public function create(Request $request)
    {
        $mes = $request->input("mes");
        $proyecto = Project::find(auth()->user()->scholarship->project_id);
        return view("usuario.reportes.create", compact("proyecto", "mes"));
    }

    public function store(Request $request)
    {
        //return response()->json($request->all());
        try {
            DB::beginTransaction();
            $user = auth()->user();
            $project = Project::find($user->scholarship->project_id);

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
                    $name = $image->getClientOriginalName();
                    $path = $image->store($directory, "public");
                    ReportImages::create([
                        "report_id" => $report->id,
                        "path" => $path,
                    ]);
                }
            }

            DB::commit();
            return response()->json([
                "message" => "Reporte enviado correctamente",
                "redirect" => route("reporte.index")
            ]);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function show(string $mes)
    {
        $user = auth()->user();
        $project = Project::find($user->scholarship->project_id);
        $report = Report::where("project_id", $project->id)->where("month", $mes)->first();
        return view("usuario.reportes.show", compact("report"));
    }
}