<?php
namespace App\Http\Controllers;
use App\Models\Contact;
use App\Models\ContactPage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index() {
        $contact = ContactPage::first();
        return view('pages.contact', compact('contact'));
    }

    // POST /contact  (route name: contact.store)
    public function store(Request $request) {
        return $this->send($request);
    }

    // POST /contact/send  (route name: contact.send)
    public function send(Request $request) {
        $isAr = app()->getLocale() === 'ar';
        $page = ContactPage::first();

        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'nullable|string|max:100',
            'email'      => 'required|email|max:255',
            'phone'      => 'nullable|string|max:30',
            'message'    => 'required|string|min:5',
        ]);

        Contact::create($request->only('first_name','last_name','email','phone','message'));

        $successMsg = $isAr
            ? ($page->success_msg_ar ?? 'تم إرسال رسالتك بنجاح! سنتواصل معك قريباً.')
            : ($page->success_msg_en ?? 'Your message has been sent successfully!');

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => $successMsg]);
        }
        return back()->with('success', $successMsg);
    }
}
