<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectEditRequest;
use App\Http\Requests\ProjectRequest;
use App\Models\Community;
use App\Models\Project;
use App\Models\Report;
use App\Models\Scholarship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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

    public function create()
    {
        $comunidades = Community::all();
        return view('admin.proyectos.create', compact('comunidades'));
    }

    public function store(ProjectRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = auth()->user();
            $search = Project::where('name', $request->name)->first();
            if ($search) {
                if ($user->role === "admin") {
                    return redirect()->route('admin.proyectos.index')
                        ->with('error_title', 'Error al guardar el proyecto')
                        ->with('error_message', 'El proyecto ya existe');
                } else {
                    return redirect()->route('home')
                        ->with('success_title', 'Error al enviar el proyecto')
                        ->with('success_message', 'El nombre del proyecto ya existe');
                }
            }

            $proyecto = new Project();
            $proyecto->fill($request->all());
            $proyecto->slug = Str::slug($request->name);
            $proyecto->sent_by = $user->id;
            $directory = "proyectos/{$proyecto->slug}";

            if ($request->hasFile("document")) {
                $document = $request->file("document");
                $filename = $document->getClientOriginalName();
                $path = $document->storeAs($directory, $filename, 'public');
                $proyecto->document = $path;
            }

            if ($request->hasFile("schedule")) {
                $schedule = $request->file("schedule");
                $filename = "cronograma." . $schedule->getClientOriginalExtension();
                $path = $schedule->storeAs($directory, $filename, 'public');
                $proyecto->schedule = $path;
            }

            if ($request->hasFile("map")) {
                $map = $request->file("map");
                $filename = "mapa." . $map->getClientOriginalExtension();
                $path = $map->storeAs($directory, $filename, 'public');
                $proyecto->map = $path;
            }

            $proyecto->accept = $request->has("accept") ? 1 : 0;

            $proyecto->save();

            if ($request->has("specific_objectives") && is_array($request->specific_objectives)) {
                $specificObjectives = $request->specific_objectives;
                foreach ($specificObjectives as $objective) {
                    $proyecto->specificObjetives()->create([
                        "specific_objective" => $objective
                    ]);
                }
            }

            $scholarships = explode(",", $request->scholarship_id);
            foreach ($scholarships as $scholarship) {
                Scholarship::where('id', $scholarship)
                    ->update(['project_id' => $proyecto->id]);
            }

            DB::commit();

            if ($user->role === "admin") {
                return redirect()->route('admin.proyectos.index')
                    ->with('success_title', 'Proyecto guardado')
                    ->with('success_message', 'El proyecto se ha guardado correctamente');
            } else {
                return redirect()->route('home')
                    ->with('success_title', 'Proyecto guardado')
                    ->with('success_message', 'El proyecto se ha enviado correctamente, espera a que sea aprobado');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error_title', 'Error al guardar el proyecto')
                ->with('error_message', 'El proyecto no se ha guardado correctamente' . $e->getMessage());
        }
    }

    public function show(string $slug)
    {
        $proyecto = Project::with('community', 'specificObjetives', 'scholarships')->where('slug', $slug)->first();
        $reports = Report::where('project_id', $proyecto->id)->get();
        return view('admin.proyectos.show', compact('proyecto', 'reports'));
    }

    public function edit(string $slug)
    {
        $proyecto = Project::with("community")->where('slug', $slug)->first();
        $comunidades = Community::all();
        return view('admin.proyectos.edit', compact('proyecto', 'comunidades'));
    }

    public function update(ProjectEditRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $proyecto = Project::findOrFail($id);
            $oldSlug = $proyecto->slug;
            $newSlug = Str::slug($request->name);

            $proyecto->fill($request->all());
            $proyecto->slug = $newSlug;
            $proyecto->accept = $request->has("accept") ? 1 : 0;

            if ($request->has("accept")) {
                if ($proyecto->sentBy->role !== "admin") {
                    $scholarship = Scholarship::where("user_id", $proyecto->sent_by)->firstOrFail();
                    $scholarship->update(["project_id" => $proyecto->id]);
                }
            }

            if ($oldSlug !== $newSlug) {
                $oldDirectory = "proyectos/{$oldSlug}";
                $newDirectory = "proyectos/{$newSlug}";

                if (Storage::disk('public')->exists($oldDirectory)) {
                    Storage::disk('public')->move($oldDirectory, $newDirectory);
                }

                if ($proyecto->document) {
                    $proyecto->document = str_replace($oldDirectory, $newDirectory, $proyecto->document);
                }
                if ($proyecto->schedule) {
                    $proyecto->schedule = str_replace($oldDirectory, $newDirectory, $proyecto->schedule);
                }
                if ($proyecto->map) {
                    $proyecto->map = str_replace($oldDirectory, $newDirectory, $proyecto->map);
                }
            }

            $directory = "proyectos/{$proyecto->slug}";

            if ($request->hasFile("document")) {
                if ($proyecto->document && Storage::disk('public')->exists($proyecto->document)) {
                    Storage::disk('public')->delete($proyecto->document);
                }
                $document = $request->file("document");
                $filename = $document->getClientOriginalName();
                $path = $document->storeAs($directory, $filename, 'public');
                $proyecto->document = $path;
            }

            if ($request->hasFile("schedule")) {
                if ($proyecto->schedule && Storage::disk('public')->exists($proyecto->schedule)) {
                    Storage::disk('public')->delete($proyecto->schedule);
                }
                $schedule = $request->file("schedule");
                $filename = "cronograma." . $schedule->getClientOriginalExtension();
                $path = $schedule->storeAs($directory, $filename, 'public');
                $proyecto->schedule = $path;
            }

            if ($request->hasFile("map")) {
                if ($proyecto->map && Storage::disk('public')->exists($proyecto->map)) {
                    Storage::disk('public')->delete($proyecto->map);
                }
                $map = $request->file("map");
                $filename = "mapa." . $map->getClientOriginalExtension();
                $path = $map->storeAs($directory, $filename, 'public');
                $proyecto->map = $path;
            }

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
            $document = $proyecto->document;
            if ($document) {
                if (Storage::disk('public')->exists($document)) {
                    Storage::disk('public')->delete($document);
                }
            }

            Scholarship::where('project_id', $proyecto->id)
                ->update(['project_id' => null]);

            $proyecto->specificObjetives()->delete();
            $proyecto->reports()->delete();

            $proyecto->delete();
            DB::commit();
            return redirect()->route('admin.proyectos.index')
                ->with('success_title', 'Proyecto eliminado')
                ->with('success_message', 'El proyecto se ha eliminado correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error_title', 'Error al eliminar el proyecto')
                ->with('error_message', 'Verifica que no tenga becados asignados o reportes');
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
}
