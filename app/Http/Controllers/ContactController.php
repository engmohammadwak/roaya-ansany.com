<?php
namespace App\Http\Controllers;
use App\Models\ContactPage;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index() {
        $contact = ContactPage::first();
        return view('pages.contact', compact('contact'));
    }

    public function send(Request $request) {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|min:10',
        ]);
        ContactMessage::create($request->only('name','email','subject','message'));
        return back()->with('success', app()->getLocale() === 'ar' ? 'تم إرسال رسالتك بنجاح!' : 'Your message has been sent successfully!');
    }
}
