<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shared\RegisterUserRequest;
use App\Http\Requests\Client\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function show()
    {
        return view("pages.client.settings");
    }

    public function create()
    {
        return view("pages.client.register");
    }

    public function store(RegisterUserRequest $req)
    {
        $validated = $req->validated();
        $userData = [
            "name" => $validated["name"],
            "email" => $validated["email"],
            "password" => $validated["password"],
            "address" => $validated["address"],
        ];
        if ($req->hasFile("profilePicture")) {
            $userData["image"] = $req->file("profilePicture")->store("users");
        }
        $user = User::create($userData);
        $user->assignRole('reader');
        Auth::login($user, true);
        return redirect()->intended()->with("success","Your account has been created Successfully!");
    }

    public function edit()
    {
        return view("pages.client.edit-user");
    }

    public function update(UpdateUserRequest $req)
    {
        $user = auth()->user();
        $validated = $req->validated();
        $userData = [
            "name" => $validated["name"],
            "email" => $validated["email"],
            "password" => $validated["password"],
            "address" => $validated["address"],
        ];
        if ($req->hasFile("profilePicture")) {
            $userData["image"] = $req->file("profilePicture")->store("users");
            if ($user->image) {
                Storage::delete($user->image);
            }
        }

        $user->update($userData);
        return redirect("/settings")->with("success","Your data has been updated Successfully!");
    }

    public function destroy(Request $req)
    {
        $userId = Auth::id();
        
        // Logout the user
        Auth::logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();

        // Delete the user account
        User::destroy($userId);

        // Redirect the user
        return redirect("/")->with("success","Your account has been deleted Successfully! Sorry to see you go!!");
    }
}