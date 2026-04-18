<?php

namespace App\Http\Controllers;

use App\Models\ServiceInquiry;
use Illuminate\Http\Request;

class ServiceInquiryController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'service'  => 'required|string|max:120',
            'name'     => 'required|string|max:120',
            'email'    => 'required|email|max:160',
            'phone'    => 'nullable|string|max:40',
            'company'  => 'nullable|string|max:160',
            'budget'   => 'nullable|string|max:80',
            'timeline' => 'nullable|string|max:80',
            'details'  => 'required|string|max:5000',
        ]);

        ServiceInquiry::create($data);

        return back()->with('inquiry_sent', true);
    }
}
