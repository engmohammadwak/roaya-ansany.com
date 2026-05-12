<?php
namespace App\Http\Controllers;
use App\Models\FaqCategory;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index() {
        $categories = FaqCategory::orderBy('sort_order')->with(['faqs' => function($q){ $q->where('is_active', true)->orderBy('sort_order'); }])->get();
        $faqs = Faq::where('is_active', true)->whereNull('faq_category_id')->orderBy('sort_order')->get();
        return view('pages.faq', compact('categories', 'faqs'));
    }
}
