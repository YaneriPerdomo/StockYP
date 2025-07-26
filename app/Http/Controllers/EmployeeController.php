<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Models\Employee;
use App\Models\IdentityCard;
use App\Models\Rol;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Hash;
use Illuminate\Http\Request;
use PDOException;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::select(
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
                    return $query->select('user_id', 'user', 'rol_id', 'state')->with([
                        'rol' => function ($query) {
                            $query;
                        }
                    ]);
                }
            ])
            ->paginate(9);



        return view(
            "admin.catalogs.master-data.employee.show-all",
            ['employees' => $employees]
        );
    }

    public function create()
    {
        $identity_cards = IdentityCard::get();
        $roles = Rol::whereNot('rol_id', 1)->
            get();
        return view(
            "admin.catalogs.master-data.employee.create",
            [
                'identity_cards' => $identity_cards,
                'roles' => $roles
            ]

        );
    }

    public function store(EmployeeStoreRequest $request)
    {

        try {
            DB::beginTransaction();
            $insert_user = new User();

            $insert_user->user = $request->user;
            $insert_user->email = $request->employee_email;
            $insert_user->password = Hash::make($request->password);
            $insert_user->rol_id = $request->role_id;
             if ($request->active ) {
                $insert_user->state = 1;
            }else{
                 $insert_user->state = 0;
            }
            $insert_user->save();

            $slug = converter_slug($request->employee_name
                . ' ' . $request->employee_lastname, $request->card);
            $insert_employee = new Employee();
           
            $insert_employee->name = $request->employee_name;
            $insert_employee->lastname = $request->employee_lastname;
            $insert_employee->card = $request->card;
            $insert_employee->identity_card_id = $request->identity_card_id;
            $insert_employee->gender_id = $request->gender_id;
            $insert_employee->address = $request->address;
            $insert_employee->telephone_number = $request->telephone_number;
            $insert_employee->user_id = $insert_user->user_id;
            $insert_employee->slug = $slug;
            $insert_employee->save();

            $message = $request->gender_id == 1 ? "El empleado ha sido registrado" : "La empleada ha sido registrada";
            DB::commit();
            return redirect('empleados')->with("alert-success", $message . " con éxito.");

        } catch (PDOException $ex) {
            DB::rollBack();
            echo $ex->getMessage();
        }
    }

    public function edit($slug)
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
                    return $query->select('user_id', 'user', 'rol_id', 'email', 'state')->with([
                        'rol' => function ($query) {
                            $query;
                        }
                    ]);
                }
            ])
            ->where('slug', $slug)
            ->first();

        $identity_cards = IdentityCard::get();
        $roles = Rol::whereNot('name', 'admin')->get();

        return view(
            "admin.catalogs.master-data.employee.edit",
            [
                'identity_cards' => $identity_cards,
                'roles' => $roles,
                'employee' => $employee
            ]

        );
    }

    public function update(EmployeeUpdateRequest $request, $old_slug)
    {
        try {
            DB::beginTransaction();

            $update_employee = Employee::where('slug', $old_slug)->first();

            $new_slug = converter_slug($request->employee_name
                . ' ' . $request->employee_lastname, $request->card);
            $update_employee->name = $request->employee_name;
            $update_employee->lastname = $request->employee_lastname;
            $update_employee->card = $request->card;
            $update_employee->identity_card_id = $request->identity_card_id;
            $update_employee->gender_id = $request->gender_id;
            $update_employee->address = $request->address;
            $update_employee->telephone_number = $request->telephone_number;
            $update_employee->slug = $new_slug;
          
            $update_employee->save();
 
            $update_user = User::where('user_id', $update_employee->user_id)->first();

            $update_user->user = $request->employee_user;
            $update_user->email = $request->employee_email;
            $update_user->rol_id = $request->role_id;
            if ($request->active ) {
                $update_user->state = 1;
            }else{
                 $update_user->state = 0;
            }
            $update_user->updated_at = Carbon::now();
            $update_user->save();

            if ($request->password != "" && $request->password_confirmation != "") {
                $update_user->password = Hash::make($request->password);
                $update_user->save();
            }


            $message = $request->gender_id == 1 ? "El empleado ha sido actualizado" : "La empleada ha sido actualizada";
            $letter = $request->gender_id == 1 ? 'o' : 'a';
            DB::commit();
            return redirect('emplead' . $letter . '/' . $new_slug . '/editar')->with("alert-success", $message . " con éxito.");
        } catch (PDOException $ex) {
            DB::rollBack();
            echo $ex->getMessage();
        }
    }

    public function delete($slug)
    {

        $gender_id = Employee::select('gender_id')->where('slug', $slug)->first();


        return view(
            "admin.catalogs.master-data.employee.delete",
            ['slug' => $slug, 'gender_id' => $gender_id->gender_id]
        );
    }
}
