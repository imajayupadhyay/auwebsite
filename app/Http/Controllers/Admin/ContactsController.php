<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactsController extends Controller
{
    public function index(Request $request)
    {
        $search = (string) $request->query('search', '');

        $contacts = ContactMessage::query()
            ->when($search, fn ($q) => $q
                ->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
            )
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('Admin/Contacts/Index', [
            'contacts' => $contacts,
            'filters'  => ['search' => $search],
            'stats'    => [
                'total'  => ContactMessage::count(),
                'unread' => ContactMessage::where('is_read', false)->count(),
            ],
        ]);
    }

    public function toggleRead(ContactMessage $contact)
    {
        $contact->update(['is_read' => !$contact->is_read]);

        return back();
    }

    public function destroy(ContactMessage $contact)
    {
        $contact->delete();

        return back()->with('contact_deleted', true);
    }
}
