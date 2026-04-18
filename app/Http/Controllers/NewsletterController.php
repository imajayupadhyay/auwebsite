<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|max:160|unique:newsletter_subscribers,email',
        ], [
            'email.unique' => 'This email is already subscribed.',
        ]);

        NewsletterSubscriber::create($data);

        return back()->with('newsletter_subscribed', true);
    }
}
