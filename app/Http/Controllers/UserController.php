<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::all();
        return view("admin.usuarios.index", compact("usuarios"));
    }

    public function create()
    {
        return view("admin.usuarios.create");
    }

    public function store(Request $request)
    {
        $request->validate([
            "user" => "required|string",
            "email" => "required|email",
            "password" => "required|min:8",
            "role" => "required"
        ]);
        DB::beginTransaction();
        try {
            User::create([
                "user" => $request->user,
                "email" => $request->email,
                "password" => Hash::make($request->password),
                "role" => $request->role
            ]);
            DB::commit();
            return redirect()->route("admin.usuarios.index")
                ->with("success_title", "Usuario creado")
                ->with("success_message", "El usuario se creó correctamente");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route("admin.usuarios.index")
                ->with("error_title", "Error al crear usuario")
                ->with("error_message", $e->getMessage());
        }
    }

    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        return view("admin.usuarios.edit", compact("usuario"));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "user" => "required|string",
            "email" => "required|email",
            "role" => "required"
        ]);
        DB::beginTransaction();
        try {
            $usuario = User::findOrFail($id);
            $usuario->update([
                "user" => $request->user,
                "email" => $request->email,
                "role" => $request->role,
                "password" => $request->password ? Hash::make($request->password) : $usuario->password
            ]);
            DB::commit();
            return redirect()->route("admin.usuarios.index")
                ->with("success_title", "Usuario actualizado")
                ->with("success_message", "El usuario se actualizó correctamente");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route("admin.usuarios.index")
                ->with("error_title", "Error al actualizar usuario")
                ->with("error_message", $e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $usuario = User::findOrFail($id);
            $usuario->delete();
            DB::commit();
            return redirect()->route("admin.usuarios.index")
                ->with("success_title", "Usuario eliminado")
                ->with("success_message", "El usuario se eliminó correctamente");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route("admin.usuarios.index")
                ->with("error_title", "Error al eliminar usuario")
                ->with("error_message", $e->getMessage());
        }
    }
}