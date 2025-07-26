<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfirmPasswordRequest;
use App\Models\Employee;
use App\Models\IdentityCard;
use App\Models\Rol;
use App\Models\User;
use Auth;
use DB;
use Exception;
use Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use PDOException;

class ConfigurationAdminController extends Controller
{
    public function index()
    {

        $employee = Employee::select(
            'identity_card_id',
            'name',
            'user_id',
            'lastname',
            'telephone_number',
            'address',
            'slug',
            'card',
            'created_at',
            'gender_id'
        )->with([
                    'identityCard' => function ($query) {
                        $query->select('identity_card_id', 'identity_card');
                    }
                ])
            ->with([
                'user' => function ($query) {
                    return $query->select('user_id', 'user', 'rol_id', 'email')->with([
                        'rol' => function ($query) {
                            $query;
                        }
                    ]);
                }
            ])
            ->where('user_id', Auth::user()->user_id)
            ->first();

        $identity_cards = IdentityCard::get();
        $roles = Rol::whereNot('name', 'admin')->get();

        return view("admin.configuration",[
            'identity_cards' => $identity_cards,
            'roles' => $roles,
            'employee' => $employee
        ]);
    }

    public function update(Request $request)
    {
        try {
            // Inicia una transacción de base de datos.
            DB::beginTransaction();

            // Obtiene el ID del usuario actualmente autenticado.
            $user_id = Auth::user()->user_id;

            // Busca el modelo de usuario correspondiente al ID.
            $data_user = User::find($user_id);

            // Actualiza los datos del usuario con la información de la solicitud.
            $data_user->update([
                'user' => $request->user,
            ]);

            // Si todas las operaciones dentro de la transacción fueron exitosas,
            // se confirman los cambios en la base de datos.
            DB::commit();

            // Flashea un mensaje de éxito a la sesión para  la vista después de la redirección..
            $request->session()->flash('alert-success-update-data', 'Tu nombre de usuario ha sido actualizado');

            // Redirige al usuario a la página de configuración.
            return redirect('/configuracion');

            // --- Bloques catch para manejar diferentes tipos de errores ---
        } catch (QueryException $ex) {
            // Aborta la ejecución de la aplicación y devuelve un código de estado HTTP 500
            // con un mensaje personalizado. 
            abort(500, 'Sucedio un error de actualizacion de usuario');

            // Muestra el mensaje de la excepción y el número de línea donde ocurrió.
            echo $ex->getMessage() . ' ' . $ex->getLine();

        } catch (PDOException $ex) { // Este bloque captura errores relacionados directamente con PDO
            // Aborta la ejecución con un error 500 y un mensaje más genérico de base de datos.
            abort(500, 'Sucedio un error en la base de datos');
            echo $ex->getMessage() . ' ' . $ex->getLine();

        } catch (Exception $ex) { // Este es el bloque 'catch' más general.
            // Captura cualquier otra excepción que no haya sido atrapada
            // Aborta la ejecución con un error 500 y un mensaje de error genérico.
            abort(500, 'Error generico inesperado ');
            echo $ex->getMessage() . ' ' . $ex->getLine();
        }

    }

    function updatePassword(ConfirmPasswordRequest $request)
    {
        try {
            DB::beginTransaction();
            $data_user = User::find(Auth::user()->user_id);
            $data_user->update([
                'password' => Hash::make($request->password),
            ]);
            $request->session()->flash(
                'alert-success-update-password',
                'Tu contraseña de usuario ha sido actualizada.'
            );
            DB::commit();
            return redirect('/configuracion');
        } catch (QueryException $ex) { //Error de consulta de nuestra base de datos
            abort(500, 'Sucedio un error de actualizacion de usuario');
            echo $ex->getMessage() . ' ' . $ex->getLine();
        } catch (PDOException $ex) { //Error relacionado con la base de datos a mas detalles
            abort(500, 'Sucedio un error en la base de datos');
            echo $ex->getMessage() . ' ' . $ex->getLine();
        } catch (Exception $ex) { //Error generico que se puede presentar 
            abort(500, 'Error generico inesperado ');
            echo $ex->getMessage() . ' ' . $ex->getLine();
        }
    }
}
