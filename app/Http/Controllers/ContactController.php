<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('pages.contact');
    }

    public function store(Request $request, ApiService $api)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'message' => 'required|string',
        ]);

        $result = $api->sendContactMessage($validated);

        if (isset($result['error'])) {
            return back()->withErrors(['msg' => __('contact.error')])->withInput();
        }

        return back()->with('success', __('contact.success'));
    }
}
