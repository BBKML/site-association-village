<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.contacts.index', compact('contacts'));
    }

    public function show(Contact $contact)
    {
        // Marquer comme lu
        if (!$contact->is_read) {
            $contact->update(['is_read' => true]);
        }
        
        return view('admin.contacts.show', compact('contact'));
    }

    public function markAsRead(Contact $contact)
    {
        $contact->update(['is_read' => true]);
        return redirect()->back()->with('success', 'Message marqué comme lu.');
    }

    public function markAsUnread(Contact $contact)
    {
        $contact->update(['is_read' => false]);
        return redirect()->back()->with('success', 'Message marqué comme non lu.');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('admin.contacts.index')->with('success', 'Message supprimé avec succès.');
    }
}
