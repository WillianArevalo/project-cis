<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function create()
    {
        $proyecto = Project::find(auth()->user()->scholarship->project_id);
        return view("usuario.reportes.index", compact("proyecto"));
    }
}