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
            "document" => "nullable|file|mimes:pdf,doc,docx",
        ]);

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
            $proyecto->name = $request->name;
            $proyecto->community_id = $request->community_id;
            $proyecto->slug = Str::slug($request->name);
            $proyecto->sent_by = auth()->id();

            if ($request->hasFile("document")) {
                $document = $request->file("document");
                $directory = "proyectos/{$proyecto->slug}";
                $filename = $document->getClientOriginalName();
                $path = $document->storeAs($directory, $filename, 'public');
                $proyecto->document = $path;
            }

            $proyecto->save();
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

    public function edit($id)
    {
        $proyecto = Project::with("community")->findOrFail($id);
        $comunidades = Community::all();
        return response()->json([
            "html" => view('layouts.__partials.ajax.form-edit-project', [
                "proyecto" => $proyecto,
                "comunidades" => $comunidades
            ])->render()
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => "required|string",
            "community_id" => "required|integer|exists:communities,id",
            "accept" => "nullable|boolean",
        ]);

        DB::beginTransaction();
        try {
            $proyecto = Project::findOrFail($id);
            $proyecto->name = $request->name;
            $proyecto->slug = Str::slug($request->name);
            $proyecto->community_id = $request->community_id;
            $proyecto->accept = $request->has("accept") ? 1 : 0;

            if ($request->has("accept") && $request->accept) {
                if ($proyecto->sentBy->role !== "admin") {
                    $scholarship = Scholarship::where("user_id", $proyecto->sent_by)->firstOrFail();
                    $scholarship->update(["project_id" => $proyecto->id]);
                }
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
                $path = public_path("storage/{$document}");
                $directory = dirname($path);

                if (file_exists($path)) {
                    unlink($path);
                }

                if (is_dir($directory) && count(scandir($directory)) == 2) {
                    rmdir($directory);
                }
            }

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