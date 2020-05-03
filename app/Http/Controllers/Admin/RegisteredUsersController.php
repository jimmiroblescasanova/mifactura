<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisteredUsersController extends Controller
{
    public function index()
    {
        return view('admin.registered-users.index', [
            'usuarios' => User::all(),
        ]);
    }

    public function ChangeAdmin(Request $request)
    {
        $usuario = User::find($request['id']);

        if ($usuario->is_admin)
        {
            if ($this->checkLastAdmin() <= 1)
            {
                return redirect()->back()->with('status', 'Se debe tener al menos un usuario administrador.');
            }
            $usuario->is_admin = false;
        } else {
            $usuario->is_admin = true;
        }
        $usuario->save();

        return redirect()->back()->with('status', 'El rol del usuario se ha actualizado.');
    }

    private function checkLastAdmin()
    {
        return User::where('is_admin', 1)->count();
    }
}
