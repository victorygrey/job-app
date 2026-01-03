<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;

class ProfileController extends Controller
{
    public function show()
    {
        return Auth::user()->profile;
    }

    public function update(Request $request)
    {
        $request->validate([
            'full_name' => 'string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            // 'cv-file' => 'nullable|file|mimes:pdf,doc,docx|max:2048', // jika implementasi upload file
        ]);
        $profile = Auth::user()->profile;
        $profile->update($request->only(['full_name', 'phone', 'address']));
        return response()->json(['message' => 'Profile updated', 'data' => $profile]);
    }
}
