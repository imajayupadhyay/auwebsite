<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NewsletterController extends Controller
{
    public function index(Request $request)
    {
        $search = (string) $request->query('search', '');

        $subscribers = NewsletterSubscriber::query()
            ->when($search, fn ($q) => $q->where('email', 'like', "%{$search}%"))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return Inertia::render('Admin/Newsletter/Index', [
            'subscribers' => $subscribers,
            'filters'     => ['search' => $search],
            'stats'       => [
                'total'    => NewsletterSubscriber::count(),
                'active'   => NewsletterSubscriber::where('is_active', true)->count(),
                'inactive' => NewsletterSubscriber::where('is_active', false)->count(),
            ],
        ]);
    }

    public function toggleActive(NewsletterSubscriber $subscriber)
    {
        $subscriber->update(['is_active' => !$subscriber->is_active]);

        return back();
    }

    public function destroy(NewsletterSubscriber $subscriber)
    {
        $subscriber->delete();

        return back()->with('subscriber_deleted', true);
    }
}
