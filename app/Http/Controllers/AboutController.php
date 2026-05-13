<?php

namespace App\Http\Controllers;

use App\Models\AboutPage;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $about = AboutPage::first();

        if ($about) {
            foreach (['goal_points_ar', 'goal_points_en'] as $field) {
                $raw = $about->$field;
                if (is_array($raw)) {
                    $flat = [];
                    foreach ($raw as $entry) {
                        if (is_array($entry) && isset($entry['item'])) {
                            $flat[] = $entry['item'];
                        } elseif (is_string($entry)) {
                            $flat[] = $entry;
                        }
                    }
                    $about->$field = $flat;
                }
            }
        }

        return view('pages.about', compact('about'));
    }
}
