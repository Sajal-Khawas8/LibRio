<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        return view("pages.admin.settings");
    }

    public function edit()
    {
        return view("pages.admin.edit-user");
    }

    public function update(UpdateUserRequest $req)
    {
        $user = auth()->user();
        $validated = $req->validated();
        $userData = [
            "name" => $validated["name"],
            "email" => $validated["email"],
            "address" => $validated["address"],
            "password" => $validated["password"],
        ];
        if ($req->hasFile("profilePicture")) {
            $userData["image"] = $req->file("profilePicture")->store("users");
            if ($user->image) {
                Storage::delete($user->image);
            }
        }

        $user->update($userData);
        return redirect()->route("admin.settings.profile.show")->with("success", "Your data has been updated Successfully!");
    }

    public function destroy(Request $req)
    {
        $userId = auth()->id();

        // Logout the user
        Auth::logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();

        // Delete the user account
        User::destroy($userId);

        // Redirect the user
        return redirect("/")->with("success", "Your account has been deleted Successfully! Sorry to see you go!!");
    }
}
