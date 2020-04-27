<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use Auth;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $user = User::findOrFail(Auth::id());

        return view('users.edit', [
            'user' => $user,
        ]);
    }

    public function update(UpdateUserRequest $request)
    {
        $user = User::findOrFail(Auth::id());

        $user->update($request->validated());
        $user->save();

        return redirect()->route('home')->with('status', 'Actualizado correctamente.');
    }
}
