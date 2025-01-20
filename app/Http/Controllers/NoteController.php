<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NoteController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'answer_id' => 'required|exists:answers,id',
            'content' => 'required|string|min:1',
        ]);

        DB::beginTransaction();
        $answer = Answer::where('id', $validated['answer_id'])->firstOrFail();
        try {
            $note = new Note();
            $note->answer_id = $validated['answer_id'];
            $note->content = $validated['content'];
            $note->user_id = auth()->id();
            $note->save();
            DB::commit();
            return redirect()->route("admin.respuestas.show", $answer->scholarship_id)
                ->with("success_title", "Nota creada")
                ->with("success_message", "La nota ha sido creada correctamente");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route("admin.respuestas.show", $answer->scholarship_id)
                ->with("error_title", "Error al crear la nota")
                ->with("error_message", "Ha ocurrido un error al crear la nota");
        }
    }

    public function destroy(string $id)
    {
        DB::beginTransaction();
        $note = Note::where('id', $id)->firstOrFail();
        $answer = Answer::where('id', $note->answer_id)->firstOrFail();
        try {
            $note->delete();
            DB::commit();
            return redirect()->route("admin.respuestas.show", $answer->scholarship_id)
                ->with("success_title", "Nota eliminada")
                ->with("success_message", "La nota ha sido eliminada correctamente");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route("admin.respuestas.show", $answer->scholarship_id)
                ->with("error_title", "Error al eliminar la nota")
                ->with("error_message", "Ha ocurrido un error al eliminar la nota");
        }
    }
}