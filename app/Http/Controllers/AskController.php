<?php

namespace App\Http\Controllers;

use App\Http\Requests\AskRequest;
use App\Models\Ask;
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
            DB::commit();
            return redirect()->route("admin.preguntas.index")->with("success_title", "Pregunta creada")
                ->with("success_message", "La pregunta se ha creado correctamente");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route("admin.preguntas.index")->with("error_title", "Error al crear la pregunta")
                ->with("error_message", "Ha ocurrido un error al crear la pregunta");
        }
    }
}