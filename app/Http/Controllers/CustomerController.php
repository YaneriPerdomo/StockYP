<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Models\Customer;
use App\Models\IdentityCard;
use Auth;
use DB;
use Illuminate\Http\Request;
use PDOException;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::select(
            'identity_card_id',
            'name',
            'lastname',
            'phone',
            'address',
            'slug',
            'card',
            'created_at',
            'gender_id',
            'user_id'
        )
            ->with([
                'identityCard' => function ($query) {
                    $query->select('identity_card_id', 'identity_card');
                }
            ])
            ->with([
                'user' => function ($query) {
                    return $query
                        ->with([
                            'rol' => function ($query) {
                                $query;
                            }
                        ])
                        ->with([
                            'employee' => function ($query) {
                                $query;
                            }
                        ]);
                }
            ])->paginate(9);


        return view(
            "admin.catalogs.master-data.customers.show-all",
            ['customers' => $customers]
        );
    }


    public function create()
    {
        $identity_cards = IdentityCard::get();
        return view(
            "admin.catalogs.master-data.customers.create",
            [
                'identity_cards' => $identity_cards
            ]

        );
    }

    public function store(CustomerStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $customer = new Customer();
            $slug = converter_slug($request->customer_name
                . ' ' . $request->customer_lastname, $request->card);
            $customer->name = $request->customer_name;
            $customer->lastname = $request->customer_lastname;
            $customer->gender_id = $request->gender_id;
            $customer->identity_card_id = $request->identity_card_id;
            $customer->card = $request->card;
            $customer->phone = $request->phone;
            $customer->address = $request->address;
            $customer->slug = $slug;
            $customer->user_id = Auth::user()->user_id;
            $customer->save();
            $message = $request->gender_id == 1 ? "El cliente ha sido registrado" : "La cliente ha sido registrada";
            DB::commit();
            return redirect('clientes')->with("alert-success", $message . " con éxito.");
        } catch (PDOException $ex) {
            DB::rollBack();
            return $ex->getMessage();
        }
    }
    public function edit($slug)
    {
        $customer = Customer::where('slug', $slug)->first();
        $identity_cards = IdentityCard::all();
        return view(
            "admin.catalogs.master-data.customers.edit",
            ['customer' => $customer, 'identity_cards' => $identity_cards]
        );
    }

    public function update(CustomerUpdateRequest $request, $slug)
    {
        $customer = Customer::where('slug', $slug)->first();

        $customer->name = $request->customer_name;
        $customer->lastname = $request->customer_lastname;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->card = $request->card;
        $customer->gender_id = $request->gender_id;
        $customer->phone = $request->phone;
        $customer->user_id = Auth::user()->user_id;
        $customer->identity_card_id = $request->identity_card_id;
        $customer->slug = 123;
        $customer->save();

        $new_slug = converter_slug($request->customer_name
            . ' ' . $request->customer_lastname, $request->card);
        $customer->slug = $new_slug;
        $customer->save();


        $message = $request->gender_id == 1 ? "El cliente ha sido actualizado" : "La cliente ha sido actualizada";
        $genderView = $request->gender_id == 1 ? "e" : "a";

        DB::commit();
        return redirect('client'.$genderView.'/' . $new_slug . '/editar')->with("alert-success", $message . " con éxito.");
    }

    public function delete($slug)
    {
        $gender_id = Customer::select('gender_id')->where('slug', $slug)->first();
        return view(
            "admin.catalogs.master-data.customers.delete",
            ['slug' => $slug, 'gender_id'  => $gender_id->gender_id]
        );
    }

    public function destroy($slug)
    {
        $deleted = Customer::where('slug', $slug)->first();
        $information = match ($deleted->gender_id) {
            1 =>
            'El cliente ' . $deleted->name . ' ' . $deleted->lastname . 'con el número de identificación "' . $deleted->card . '" ha sido eliminado'
            ,
            2 => 'La cliente ' . $deleted->name . ' ' . $deleted->lastname . ' con el número de identificación "' . $deleted->card . '" ha sido eliminada'
            ,
        };
        $deleted->delete();
        return redirect('clientes')
            ->with("alert-success", $information . " correctamente.");
    }
}
