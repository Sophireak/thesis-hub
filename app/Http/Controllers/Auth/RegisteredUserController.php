<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Models\StudentProfile;
use App\Models\SupervisorProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(RegisterRequest $request): RedirectResponse
    {
        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Create profile based on role
        if ($request->role === 'student') {
            StudentProfile::create([
                'user_id' => $user->id,
                'student_id' => $request->student_id,
                'department' => $request->department,
                'academic_year' => $request->academic_year,
                'phone_number' => $request->phone_number,
            ]);
        } else {
            SupervisorProfile::create([
                'user_id' => $user->id,
                'department' => $request->department,
                'office_room' => $request->office_room,
                'max_students' => $request->max_students,
            ]);
        }

        // Trigger registration event and login
        event(new Registered($user));
        Auth::login($user);

        // Redirect to dashboard
        return redirect()->route('dashboard');
    }
}
