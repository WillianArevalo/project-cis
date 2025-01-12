<?php

namespace App\Http\Controllers;

use App\Http\Requests\BecadoRequest;
use App\Models\Community;
use App\Models\Scholarship;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class BecadoController extends Controller
{
    public function index()
    {
        $becados = Scholarship::paginate(30);
        return view("admin.becados.index", compact("becados"));
    }

    public function create()
    {
        $users = User::all();
        $comunidades = Community::all();
        return view("admin.becados.create", compact("users", "comunidades"));
    }

    public function store(BecadoRequest $request)
    {
        $validated = $request->validated();
        DB::beginTransaction();
        try {

            if ($request->has("user") && !$request->user_id) {
                $user = User::create([
                    "user" => $validated["user"],
                    "email" => null,
                    "password" => Hash::make("nuevobecado"),
                    "role" => "user"
                ]);
                $validated["user_id"] = $user->id;
            }

            if ($request->hasFile("photo")) {
                $name = $request->file("photo")->getClientOriginalName();
                $path = $request->file("photo")->storeAs("images/becados", $name, "public");
                $validated["photo"] = $path;
            }

            $validated["project_id"] = null;
            Scholarship::create($validated);

            DB::commit();
            return redirect()->route("admin.becados.index")
                ->with("success_title", "Becado creado")
                ->with("success_message", "El becado ha sido creado correctamente");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route("admin.becados.index")
                ->with("error_title", "Error al crear becado")
                ->with("error_message", $e->getMessage());
        }
    }

    public function edit($id)
    {
        $becado = Scholarship::find($id);
        $users = User::all();
        $comunidades = Community::all();
        return view("admin.becados.edit", compact("becado", "users", "comunidades"));
    }

    public function update(BecadoRequest $request, $id)
    {
        $validated = $request->validated();
        DB::beginTransaction();
        try {
            $becado = Scholarship::find($id);
            if ($request->hasFile("photo")) {
                Storage::disk("public")->delete($becado->photo);
                $name = $request->file("photo")->getClientOriginalName();
                $path = $request->file("photo")->storeAs("images/becados", $name, "public");
                $validated["photo"] = $path;
            }
            $becado->update($validated);
            DB::commit();
            return redirect()->route("admin.becados.index")
                ->with("success_title", "Becado actualizado")
                ->with("success_message", "El becado ha sido actualizado correctamente");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route("admin.becados.index")
                ->with("error_title", "Error al actualizar becado")
                ->with("error_message", $e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $becado = Scholarship::find($id);
            if ($becado->photo) {
                Storage::disk("public")->delete($becado->photo);
            }
            $becado->delete();
            DB::commit();
            return redirect()->route("admin.becados.index")
                ->with("success_title", "Becado eliminado")
                ->with("success_message", "El becado ha sido eliminado correctamente");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route("admin.becados.index")
                ->with("error_title", "Error al eliminar becado")
                ->with("error_message", $e->getMessage());
        }
    }
}
