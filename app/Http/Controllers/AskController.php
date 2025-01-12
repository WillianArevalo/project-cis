<?php

namespace App\Http\Controllers;

use App\Http\Requests\AskRequest;
use App\Models\Ask;
use App\Models\AskLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AskController extends Controller
{
    public function index()
    {
        $asks = Ask::all();
        return view("admin.preguntas.index", compact("asks"));
    }

    public function store(AskRequest $request)
    {
        try {
            DB::beginTransaction();
            $validated = $request->validated();
            $ask = Ask::create($validated);

            foreach ($validated["level"] as $level) {
                AskLevel::create([
                    "ask_id" => $ask->id,
                    "level" => $level,
                    "type" => $validated["type"],
                ]);
            }

            DB::commit();
            return redirect()->route("admin.preguntas.index")->with("success_title", "Pregunta creada")
                ->with("success_message", "La pregunta se ha creado correctamente");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route("admin.preguntas.index")->with("error_title", "Error al crear la pregunta")
                ->with("error_message", "Ha ocurrido un error al crear la pregunta");
        }
    }

    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $ask = Ask::findOrFail($id);
            $ask->delete();
            DB::commit();
            return redirect()->route("admin.preguntas.index")
                ->with("success_title", "Pregunta eliminada")
                ->with("success_message", "La pregunta se ha eliminado correctamente");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route("admin.preguntas.index")
                ->with("error_title", "Error al eliminar la pregunta")
                ->with("error_message", "Ha ocurrido un error al eliminar la pregunta");
        }
    }

    public function edit(string $id)
    {
        $ask = Ask::findOrFail($id);
        return response()->json([
            "html" => view("layouts.__partials.ajax.form-edit-ask", compact("ask"))->render()
        ]);
    }

    public function update(AskRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $validated = $request->validated();
            $ask = Ask::findOrFail($id);
            $ask->update($validated);

            AskLevel::where("ask_id", $ask->id)->delete();
            foreach ($validated["level"] as $level) {
                AskLevel::create([
                    "ask_id" => $ask->id,
                    "level" => $level,
                    "type" => $validated["type"],
                ]);
            }
            DB::commit();
            return redirect()->route("admin.preguntas.index")->with("success_title", "Pregunta actualizada")
                ->with("success_message", "La pregunta se ha actualizado correctamente");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route("admin.preguntas.index")->with("error_title", "Error al actualizar la pregunta")
                ->with("error_message", "Ha ocurrido un error al actualizar la pregunta");
        }
    }
}