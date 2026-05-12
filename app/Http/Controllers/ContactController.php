<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Setting;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $settings = Setting::getAllSettings();
        return view('pages.contact', compact('settings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'phone'   => 'nullable|string|max:20',
            'message' => 'required|string',
        ]);

        Contact::create($request->only('name', 'email', 'phone', 'message'));

        return back()->with('success', __('general.message_sent'));
    }
}
