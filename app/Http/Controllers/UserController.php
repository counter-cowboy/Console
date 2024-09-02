<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{
    public function listUsers()
    {
        return UserResource::collection(User::all());
    }

    public function createUser(UserRequest $request)
    {
        return new UserResource(User::create($request->validated()));
    }


    public function deleteUser(User $user)
    {
        $user->delete();

        return response()->json(['message' => "User $user->id deleted"]);
    }
}
