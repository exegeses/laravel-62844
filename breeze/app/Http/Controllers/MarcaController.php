<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use function Termwind\render;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        $marcas = Marca::paginate(5);
        return view('marcas',
            [ 'marcas'=>$marcas ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        return view('marcaCreate');
    }

    private function validarForm( Request $request ) : void
    {
        $request->validate(
                /*
                 * [ 'campo'=>'reglas' ],
                 * [ 'campo.regla'=>'mensaje' ]
                 */
            [ 'mkNombre'=>'required|unique:marcas,mkNombre|min:2|max:30' ],
            [
              'mkNombre.required'=>'El campo: "Nombre de la marca" es obligatorio',
              'mkNombre.unique'=>'Ya existe una marca con ese nombre',
              'mkNombre.min'=>'El campo: "Nombre de la marca" debe contener al menos 2 caractéres',
              'mkNombre.max'=>'El campo: "Nombre de la marca" debe tener 30 caractéres ccomo máximo'
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validación
        $this->validarForm( $request );
        //capturamos dato enviado (para mensaje flash)
        $mkNombre = $request->mkNombre;

        //almacenamos dato en la tabla marcas
        try {
            /*
            //instanciamos
            $Marca = new Marca;
            //asignamos atributos
            $Marca->mkNombre = $mkNombre;
            //almacenamos dato
            $Marca->save();
            */

            //mass assignment  | asignación masiva
            Marca::create(
                [
                    'mkNombre'=>$mkNombre,
                ]
            );


            return redirect('/marcas')
                    ->with(
                        [
                            'mensaje'=>'Marca: '.$mkNombre.' agregada correctamente',
                            'css'=>'green'
                        ]
                    );
        }
        catch ( Throwable $th ){
            return redirect('/marcas')
                    ->with(
                        [
                            'mensaje'=>'No se pudo agregar la marca: '.$mkNombre,
                            'css'=>'red'
                        ]
                    );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( Marca $marca ) : View
    {
        /*
        //obtenemos datos de una marca por su id
        $Marca = Marca::find($id);
        */

        return view('marcaEdit',
            [
                'Marca'=>$marca
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( Request $request ) : RedirectResponse
    {
        //validación
        $this->validarForm($request);

        //capturamos dato enviado (para mensaje flash)
        $mkNombre = $request->mkNombre;

        try {
            //obtenemos datos de una marca por su id
            $Marca = Marca::find( $request->idMarca );
            /*
            //asignamos atributos
            $Marca->mkNombre = $mkNombre;
            //almacenamos dato
            $Marca->save();
            */
            //mass assignment  | asignación masiva
            $Marca->fill(
                [
                    'mkNombre'=>$mkNombre,
                ]
            );
            $Marca->save();

            return redirect('/marcas')
                ->with(
                    [
                        'mensaje'=>'Marca: '.$mkNombre.' agregada correctamente',
                        'css'=>'green'
                    ]
                );
        }
        catch ( Throwable $th ){
            return redirect('/marcas')
                ->with(
                    [
                        'mensaje'=>'No se pudo modificar la marca: '.$mkNombre,
                        'css'=>'red'
                    ]
                );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
