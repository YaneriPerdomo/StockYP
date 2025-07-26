<?php

namespace App\Http\Controllers;

use App\Http\Requests\SuppliersStoreRequest;
use App\Http\Requests\SupplierUpdateRequest;
use App\Models\IdentityCard;
use App\Models\Supplier;
use Auth;
use Illuminate\Http\Request;

use App\Models\Category;
use DB;
use Exception;
use Illuminate\Database\QueryException;
use PDOException;
class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::with([
            'identityCard' => function ($query) {
                return $query;
            }
        ])->with([
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
                ])->paginate(8);



        return view(
            "admin.catalogs.master-data.suppliers.show-all",
            ["suppliers" => $suppliers]
        );
    }

    public function create()
    {
        $identity_cards = IdentityCard::get();


        return view(
            "admin.catalogs.master-data.suppliers.create",
            [
                'identity_cards' => $identity_cards
            ]

        );
    }

    public function store(SuppliersStoreRequest $request)
    {

        DB::beginTransaction();
        $slug = converter_slug($request->name);

        $insert_supplier = new Supplier();

        $insert_supplier->user_id = Auth::user()->user_id;
        $insert_supplier->card = $request->card;
        $insert_supplier->identity_card_id = $request->identity_card_id;
        $insert_supplier->slug = $slug;
        $insert_supplier->gender_id = $request->gender_id;
        $insert_supplier->name = $request->name;
        $insert_supplier->telephone_number = $request->telephone_number;
        $insert_supplier->address = $request->address;
        if ($request->active) {
            $insert_supplier->state = 1;
        } else {
            $insert_supplier->state = 0;
        }
        $insert_supplier->save();

        $message = $request->gender_id == 1 ? "El proveedor ha sido registrado" : "La proveedora ha sido registrada";
        DB::commit();
        return redirect('proveedores')->with("alert-success", $message . " con éxito.");


    }

    public function edit($slug)
    {
        $supplier = Supplier::where('slug', $slug)
            ->with([
                'identityCard' => function ($query) {
                    return $query;
                }
            ])
            ->first();

        $identity_cards = IdentityCard::get();

        return view(
            'admin.catalogs.master-data.suppliers.edit',
            [
                'supplier' => $supplier,
                'identity_cards' => $identity_cards,
            ]
        );
    }

    public function update(SupplierUpdateRequest $request, $old_slug)
    {
        try {
            DB::beginTransaction();

            $update_supplier = Supplier::where('slug', $old_slug)->first();

            if (!$update_supplier) {
                DB::rollBack();
                return redirect()->back()->with("alert-danger", "El proveedor a actualizar no fue encontrado.");
            }
            $new_slug = converter_slug($request->name);

            $update_supplier->user_id = Auth::user()->user_id;
            $update_supplier->card = $request->card;
            $update_supplier->identity_card_id = $request->identity_card_id;
            $update_supplier->slug = $new_slug;
            $update_supplier->gender_id = $request->gender_id;
            $update_supplier->name = $request->name;
            $update_supplier->telephone_number = $request->telephone_number;

            $update_supplier->address = $request->address;
            if ($request->active) {
                $update_supplier->state = 1;
            } else {
                $update_supplier->state = 0;
            }
            $update_supplier->save();


            DB::commit();

            $message = $request->gender_id == 1 ? "El proveedor ha sido actualizado" : "La proveedora ha sido actualizada";
            $route_gender = $request->gender_id == 1 ? "or" : "ora";
            return redirect('proveed' . $route_gender . '/' . $new_slug . '/editar')
                ->with("alert-success", $message . " correctamente.");

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

    public function delete($slug)
    {

        $gender_id = Supplier::select('gender_id')->where('slug', $slug)->first();


        return view(
            "admin.catalogs.master-data.suppliers.delete",
            ["slug" => $slug, "gender_id" => $gender_id->gender_id]
        );
    }
    public function destroy($slug)
    {


        //Eliminar el registro 
        $supplier = Supplier::where('slug', $slug)->first();

        $name = $supplier->name;
        $supplier->delete();

        $message = $supplier->gender_id == 1 ? "El proveedor '" . $name . "' ha sido eliminado"
            : "La proveedora '" . $name . "' ha sido eliminada";
        return redirect('proveedores')
            ->with("alert-success", $message . " correctamente.");
    }
}
