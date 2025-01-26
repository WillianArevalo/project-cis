<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Scholarship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnswerController extends Controller
{
    public function index()
    {
        $becados = Scholarship::all();
        return view('admin.respuestas.index', compact('becados'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'answers' => 'nullable|array',
            'answers.*.ask_id' => 'nullable|exists:asks,id',
            'answers.*.content' => 'nullable|string|min:1',
        ]);

        try {
            DB::beginTransaction();
            $scholarship = Scholarship::where('user_id', auth()->id())->firstOrFail();

            if ($request->has("phone")) {
                $scholarship->phone = $request->phone;
                $scholarship->save();
            }

            foreach ($validated['answers'] as $answer) {
                Answer::create([
                    'content' => $answer['content'],
                    'ask_id' => $answer['ask_id'],
                    'scholarship_id' => $scholarship->id,
                    'status' => "pending",
                ]);
            }

            DB::commit();
            return redirect()->route("home")
                ->with("success_title", "Respuestas creadas")
                ->with("success_message", "Las respuestas han sido enviadas correctamente");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route("home")
                ->with("error_title", "Error al crear las respuestas")
                ->with("error_message", "Ha ocurrido un error al crear las respuestas");
        }
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'answers' => 'nullable|array',
            'answers.*.ask_id' => 'nullable|exists:asks,id',
            'answers.*.content' => 'nullable|string|min:1',
            'scholarship_id' => 'required|exists:scholarships,id',
        ]);

        $user = auth()->user();

        try {
            DB::beginTransaction();
            $scholarship = Scholarship::where('id', $validated['scholarship_id'])->firstOrFail();

            foreach ($validated['answers'] as $answer) {
                $answerModel = Answer::where('ask_id', $answer['ask_id'])
                    ->where('scholarship_id', $scholarship->id)
                    ->firstOrFail();
                $answerModel->content = $answer['content'];
                $answerModel->save();
            }
            DB::commit();

            if ($user->role == 'admin') {
                return redirect()->route("admin.respuestas.show", $scholarship->id)
                    ->with('success_title', 'Respuestas actualizadas')
                    ->with('success_message', 'Las respuestas han sido actualizadas correctamente.');
            } else {
                return redirect()->route("home")
                    ->with('success_title', 'Respuestas actualizadas')
                    ->with('success_message', 'Las respuestas han sido actualizadas correctamente.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            if ($user->rol == 'admin') {
                return redirect()->route("admin.respuestas.show", $scholarship->id)
                    ->with('error_title', 'Error al actualizar las respuestas')
                    ->with('error_message', 'Ha ocurrido un error al actualizar las respuestas.');
            } else {
                return redirect()->route("home")
                    ->with('error_title', 'Error al actualizar las respuestas')
                    ->with('error_message', 'Ha ocurrido un error al actualizar las respuestas.');
            }
        }
    }

    public function show(string $id)
    {
        $scholarship = Scholarship::where("id", $id)->first();
        $asks = $scholarship->asks()->with(['answers' => function ($query) use ($scholarship) {
            $query->where('scholarship_id', $scholarship->id);
        }])->get();

        return view('admin.respuestas.show', compact('scholarship', 'asks'));
    }

    public function changeStatus(Request $request, string $id)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,approved,rejected',
        ]);
        $answer = Answer::where('id', $id)->firstOrFail();
        $answer->status = $validated['status'];
        $answer->save();
        return response()->json(['message' => 'Estado actualizado correctamente']);
    }
}
