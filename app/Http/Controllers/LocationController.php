<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationStoreRequest;
use App\Http\Requests\LocationUpdateRequest;
use App\Models\Location;
use Auth;
use Illuminate\Http\Request;
use App\Models\Category;
use DB;
use Exception;
use Illuminate\Database\QueryException;
use PDOException;

class LocationController extends Controller
{
    public function index()
    {

        $locations = Location::select()->with([
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
            "admin.catalogs.catalog-configuration.locations.show-all",
            ["locations" => $locations]
        );
    }

    public function create()
    {
        return view(
            "admin.catalogs.catalog-configuration.locations.create",

        );
    }

    public function store(LocationStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $slug = converter_slug($request->name);

            $insert_location = new Location();

            $insert_location->slug = $slug;
            $insert_location->name = $request->name;
            $insert_location->user_id = Auth::user()->user_id;
            $insert_location->save();


            DB::commit();
            return redirect('ubicaciones')->with("alert-success", "La ubicacion ha sido registrada con éxito.");

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

    public function edit($slug)
    {
        $location = Location::where('slug', $slug)->first();

        return view(
            'admin.catalogs.catalog-configuration.locations.edit',
            [
                'location' => $location
            ]
        );
    }

    public function update(LocationUpdateRequest $request, $old_slug)
    {

        try {
            DB::beginTransaction();

            $update_location = Location::where('slug', $old_slug)->first();
            $new_slug = converter_slug($request->name);


            $update_location->user_id = Auth::user()->user_id;
            $update_location->slug = $new_slug;
            $update_location->name = $request->name;
            $update_location->save();

            DB::commit();
            return redirect('ubicacion/' . $new_slug . '/editar')
                ->with("alert-success", "La ubicacion se ha actualizado correctamente.");
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

        return view(
            "admin.catalogs.catalog-configuration.locations.delete",
            ["slug" => $slug]
        );
    }
    public function destroy($slug)
    {

        $supplier = Location::where('slug', $slug)->first();

        $name = $supplier->name;
        $supplier->delete();

        return redirect('ubicaciones')
            ->with("alert-success", 'La ubicacion "' . $name . '" ha sido eliminada' . " correctamente.");
    }
}
