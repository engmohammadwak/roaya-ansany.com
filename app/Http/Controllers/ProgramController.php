<?php
namespace App\Http\Controllers;
use App\Models\Program;

class ProgramController extends Controller
{
    public function index() {
        $programs = Program::where('is_active', true)->orderBy('sort_order')->paginate(9);
        $categories_ar = Program::where('is_active', true)->whereNotNull('category_ar')->distinct()->pluck('category_ar');
        $categories_en = Program::where('is_active', true)->whereNotNull('category_en')->distinct()->pluck('category_en');
        return view('pages.programs', compact('programs', 'categories_ar', 'categories_en'));
    }
}
