<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $search = (string) $request->query('search', '');

        $users = User::query()
            ->where('is_admin', true)
            ->when($search, fn ($q) => $q
                ->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
            )
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('Admin/Users/Index', [
            'users'   => $users,
            'filters' => ['search' => $search],
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'email', 'max:255', 'unique:users'],
            'password'              => ['required', Password::min(8), 'confirmed'],
            'password_confirmation' => ['required'],
        ]);

        User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => $data['password'],
            'is_admin' => true,
        ]);

        return back()->with('user_saved', 'created');
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password'              => ['nullable', Password::min(8), 'confirmed'],
            'password_confirmation' => ['nullable'],
        ]);

        $user->name  = $data['name'];
        $user->email = $data['email'];

        if (!empty($data['password'])) {
            $user->password = $data['password'];
        }

        $user->save();

        return back()->with('user_saved', 'updated');
    }

    public function destroy(Request $request, User $user)
    {
        if ($user->id === $request->user()->id) {
            return back()->withErrors(['delete' => 'You cannot delete your own account.']);
        }

        $user->delete();

        return back()->with('user_deleted', true);
    }
}
