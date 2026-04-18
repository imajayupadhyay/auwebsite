<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceInquiry;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InquiriesController extends Controller
{
    public function index(Request $request)
    {
        $search = (string) $request->query('search', '');

        $inquiries = ServiceInquiry::query()
            ->when($search, fn ($q) => $q
                ->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('service', 'like', "%{$search}%")
                ->orWhere('company', 'like', "%{$search}%")
            )
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('Admin/Inquiries/Index', [
            'inquiries' => $inquiries,
            'filters'   => ['search' => $search],
            'stats'     => [
                'total'  => ServiceInquiry::count(),
                'unread' => ServiceInquiry::where('is_read', false)->count(),
            ],
        ]);
    }

    public function toggleRead(ServiceInquiry $inquiry)
    {
        $inquiry->update(['is_read' => !$inquiry->is_read]);

        return back();
    }

    public function destroy(ServiceInquiry $inquiry)
    {
        $inquiry->delete();

        return back()->with('inquiry_deleted', true);
    }
}
