<?php

namespace App\Http\Controllers;

use App\Models\Community;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComunidadController extends Controller
{
    public function index()
    {
        $comunidades = Community::all();
        return view('admin.comunidades.index', compact('comunidades'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            Community::create([
                'name' => $request->name,
            ]);
            DB::commit();
            return redirect()->route('admin.comunidades.index')
                ->with("success_title", "Exito")
                ->with("success_message", "Comunidad creada correctamente");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.comunidades.index')
                ->with('error_title', 'Error')
                ->with('error_message', 'Error al crear la comunidad');
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            Community::destroy($id);
            DB::commit();
            return redirect()->route('admin.comunidades.index')
                ->with("success_title", "Exito")
                ->with("success_message", "Comunidad eliminada correctamente");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.comunidades.index')
                ->with('error_title', 'Error')
                ->with('error_message', 'Error al eliminar la comunidad');
        }
    }

    public function edit($id)
    {
        $comunidad = Community::find($id);
        return response()->json($comunidad);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $comunidad = Community::find($id);
            $comunidad->name = $request->name;
            $comunidad->save();
            DB::commit();
            return redirect()->route('admin.comunidades.index')
                ->with("success_title", "Exito")
                ->with("success_message", "Comunidad actualizada correctamente");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.comunidades.index')
                ->with('error_title', 'Error')
                ->with('error_message', 'Error al actualizar la comunidad');
        }
    }
}