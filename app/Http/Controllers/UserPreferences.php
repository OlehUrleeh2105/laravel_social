<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class UserPreferences extends Controller
{
    public function onUserSettings() {
        $user = User::find(Auth::user()->id);

        return view('settings', ['user' => $user]);
    }

    public function onEditProfile(Request $request) {
        $user = User::find($request->id);

        return view('edit_settings', ['user' => $user]);
    }
}
