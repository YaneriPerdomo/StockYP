<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function store(LoginRequest $request)
    {
        $credentials = $request->only('user', 'password');
        if (Auth::attempt($credentials)) {

            if (Auth::user()->state == 0) {
                return back()->withErrors([
                    'message_incorrect_credentials' => 'Lo sentimos, tu cuenta de usuario está deshabilitada. Para obtener asistencia, comunícate con el administrador.'
                ]);
            }
            $request->session()->regenerate();
            if (Auth::user()->rol_id == 2 || Auth::user()->rol_id == 3 || Auth::user()->rol_id == 4) {
                $user = Auth::user()->load('employee');
                $request->session()->put('name', $user->employee->name);
                $gender = Auth::user()->employee->gender_id == 1 ? '/bienvenido' : '/bienvenida';
                return redirect()->intended($gender);
            }
            return redirect()->intended('/bienvenido-a');

        } else {
            return back()->withErrors([
                'message_incorrect_credentials' => 'Credenciales incorrectos'
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/iniciar-sesion');
    }
}
