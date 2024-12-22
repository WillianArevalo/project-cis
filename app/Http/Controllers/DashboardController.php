<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\Project;
use App\Models\Scholarship;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $usuarios = User::count();
        $becados = Scholarship::count();
        $proyectos = Project::count();
        $comunidades = Community::count();
        return view("admin.dashboard.index", compact("usuarios", "becados", "proyectos", "comunidades"));
    }
}