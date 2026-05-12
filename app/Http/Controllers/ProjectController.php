<?php
namespace App\Http\Controllers;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index() {
        $projects = Project::where('is_active', true)->orderBy('sort_order')->paginate(9);
        return view('pages.projects', compact('projects'));
    }
}
