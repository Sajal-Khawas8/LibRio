<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shared\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $admins = User::role(['admin', 'super-admin'])->whereNot('id', auth()->id())->filter(request('search'))->orderBy("id")->simplePaginate(4);
        return view("pages.admin.admins", compact("admins"));
    }

    public function create()
    {
        return view("pages.admin.add-admin");
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
        $user->assignRole('admin');
        return redirect()->route("admin.team.index")->with("success", "New admin has been registered Successfully!");
    }

    public function makeSuperAdmin(Request $req, User $user)
    {
        $user->syncRoles('super-admin');
        return redirect()->back()->with("success", "{$user->name} is now a Super Admin");
    }

    public function removeSuperAdmin(Request $req, User $user)
    {
        $user->syncRoles('admin');
        return redirect()->back()->with("success", "{$user->name} is not a Super Admin anymore");
    }

    public function removeAdmin(Request $req, User $user)
    {
        $user->delete();
        return redirect()->back()->with("success", "Admin has been removed");
    }
}
