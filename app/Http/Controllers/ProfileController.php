<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectEditRequest;
use App\Models\Project;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('usuario.profile', compact('user'));
    }

    public function verifyEmail()
    {
        $user = auth()->user();

        if ($user->email_verified_at) {
            return redirect()->route('profile')
                ->with("warning_title", "Correo electrónico ya verificado")
                ->with("warning_message", "Tu correo electrónico ya ha sido verificado.");
        }
        return view('usuario.email', compact('user'));
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|string|same:password',
        ]);

        $user = auth()->user();
        $user->password = Hash::make($request->password);
        $user->save();

        if ($user->role === "admin") {
            return redirect()->route('admin.profile')
                ->with("success_title", "Contraseña actualizada")
                ->with("success_message", "Tu contraseña ha sido actualizada correctamente.");
        } else {
            return redirect()->route('profile')
                ->with("success_title", "Contraseña actualizada")
                ->with("success_message", "Tu contraseña ha sido actualizada correctamente.");
        }
    }

    public function admin()
    {
        $user = auth()->user();
        $maintenance = Setting::where('key', 'maintenance')->first();
        $project_mode = Setting::where('key', 'project_mode')->first();
        $question_mode = Setting::where('key', 'question_mode')->first();
        return view('admin.profile', [
            'user' => $user,
            'maintenance' => $maintenance,
            'project_mode' => $project_mode,
            'question_mode' => $question_mode,
        ]);
    }

    public function project()
    {
        $user = auth()->user();
        $proyecto = $user->scholarship->project;
        $comunidad = $user->scholarship->community;
        return view('usuario.proyecto', [
            'user' => $user,
            'proyecto' => $proyecto,
            'comunidad' => $comunidad,
        ]);
    }

    public function updateProject(ProjectEditRequest $request, $id)
    {
        //dd($request->all());
        DB::beginTransaction();
        try {
            $proyecto = Project::findOrFail($id);
            $oldSlug = $proyecto->slug;
            $newSlug = Str::slug($request->name);

            $proyecto->fill($request->all());
            $proyecto->slug = $newSlug;

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

            if ($request->has("specific_objectives") && is_array($request->specific_objectives)) {
                $proyecto->specificObjetives()->delete();
                $specificObjectives = $request->specific_objectives;
                foreach ($specificObjectives as $objective) {
                    $proyecto->specificObjetives()->create([
                        "specific_objective" => $objective
                    ]);
                }
            }

            $proyecto->save();

            DB::commit();
            return redirect()->route('proyectos.index')
                ->with('success_title', 'Proyecto actualizado')
                ->with('success_message', 'El proyecto se ha actualizado correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error_title', 'Error al actualizar el proyecto')
                ->with('error_message', $e->getMessage());
        }
    }
}
