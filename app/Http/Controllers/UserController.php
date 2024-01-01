<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function editSettings()
    {
        $user = Auth::user();
        return view('Admin.user_edit', compact('user'));
    }

    public function updateSettings(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'profile_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'user_type' => 'required|in:user,admin',
        ]);

        $user->name = $validatedData['name'];
        $user->user_type = $validatedData['user_type'];

        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $user->profile_picture = 'images/' . $imageName;
        }

        $user->save();
        return redirect()->back()->with('success', 'Settings updated successfully');
    }

    public function showActivityLog()
    {
        $logs = Activity::all();
        return view('Admin.activity_log', ['logs' => $logs]);
    }
}
