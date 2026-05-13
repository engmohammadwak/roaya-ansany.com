<?php
namespace App\Http\Controllers;
use App\Models\FaqCategory;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index() {
        $categories = FaqCategory::orderBy('sort_order')
            ->with(['faqs' => function($q){
                $q->orderBy('sort_order');
                // لا نفلتر is_active حتى تظهر كل الأسئلة — الإخفاء يتم بال toggle من الداشبورد
            }])
            ->get();

        $faqs = Faq::whereNull('faq_category_id')->orderBy('sort_order')->get();

        return view('pages.faq', compact('categories', 'faqs'));
    }
}
