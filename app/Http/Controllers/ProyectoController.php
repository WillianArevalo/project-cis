<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\Project;
use App\Models\Report;
use App\Models\Scholarship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ProyectoController extends Controller
{

    public function __construct()
    {
        Carbon::setLocale("es");
    }

    public function index()
    {
        $proyectos = Project::with('community', 'scholarships')->get();
        $comunidades = Community::all();
        $currentMonth =
            Carbon::now()->translatedFormat("F");
        return view('admin.proyectos.index', compact('proyectos', 'comunidades', 'currentMonth'));
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string",
            "community_id" => "required|integer|exists:communities,id",
        ]);

        DB::beginTransaction();
        try {
            $proyecto = new Project();
            $proyecto->name = $request->name;
            $proyecto->community_id = $request->community_id;
            $proyecto->save();
            DB::commit();
            return redirect()->route('admin.proyectos.index')
                ->with('success_title', 'Proyecto guardado')
                ->with('success_message', 'El proyecto se ha guardado correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error_title', 'Error al guardar el proyecto')
                ->with('error_message', 'El proyecto no se ha guardado correctamente');
        }
    }

    public function edit($id)
    {
        $proyecto = Project::with("community")->findOrFail($id);
        return response()->json($proyecto);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => "required|string",
            "community_id" => "required|integer|exists:communities,id",
        ]);

        DB::beginTransaction();
        try {
            $proyecto = Project::findOrFail($id);
            $proyecto->name = $request->name;
            $proyecto->slug = Str::slug($request->name);
            $proyecto->community_id = $request->community_id;
            $proyecto->save();
            DB::commit();
            return redirect()->route('admin.proyectos.index')
                ->with('success_title', 'Proyecto actualizado')
                ->with('success_message', 'El proyecto se ha actualizado correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error_title', 'Error al actualizar el proyecto')
                ->with('error_message', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $proyecto = Project::findOrFail($id);

            Scholarship::where('project_id', $proyecto->id)
                ->update(['project_id' => null]);

            $proyecto->delete();
            DB::commit();
            return redirect()->route('admin.proyectos.index')
                ->with('success_title', 'Proyecto eliminado')
                ->with('success_message', 'El proyecto se ha eliminado correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error_title', 'Error al eliminar el proyecto')
                ->with('error_message', $e->getMessage());
        }
    }

    public function assign(string $slug)
    {
        $proyecto = Project::with('scholarships')->where('slug', $slug)->first();
        $becados = Scholarship::where(function ($query) use ($proyecto) {
            $query->whereNull('project_id')
                ->orWhere('project_id', '!=', $proyecto->id);
        })->get();
        return view('admin.proyectos.asignar', compact('proyecto', 'becados'));
    }

    public function assignStore(Request $request, string $id)
    {
        $request->validate([
            "scholarship_id" => "required|array|exists:scholarships,id",
        ]);

        DB::beginTransaction();
        try {
            $proyecto = Project::findOrFail($id);
            $currentlyAssigned = Scholarship::where('project_id', $proyecto->id)->pluck('id')->toArray();

            Scholarship::whereIn('id', $request->scholarship_id)
                ->update(['project_id' => $proyecto->id]);

            Scholarship::whereIn('id', $currentlyAssigned)
                ->whereNotIn('id', $request->scholarship_id)
                ->update(['project_id' => null]);

            DB::commit();
            return redirect()->route('admin.proyectos.index')
                ->with('success_title', 'Becados asignados')
                ->with('success_message', 'Becados asignados correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error_title', 'Error al asignar los becados')
                ->with('error_message', $e->getMessage());
        }
    }

    public function reportes(string $slug)
    {
        $proyecto = Project::with('scholarships')->where('slug', $slug)->first();
        $reportes = Report::where('project_id', $proyecto->id)->get();
        return view('admin.proyectos.reportes', compact('proyecto', 'reportes'));
    }

    public function showReport(string $id)
    {
        $user = auth()->user();
        $report = Report::findOrFail($id);
        return view("admin.proyectos.show-report", compact("report"));
    }
}