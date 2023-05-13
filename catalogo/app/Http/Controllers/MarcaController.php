<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        //obtenemos listado de marcas
        //$marcas = Marca::all();
        $marcas = Marca::paginate(8);
        return view('marcas', [ 'marcas'=>$marcas ]);
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
                    [ 'campo'=>'reglas' ],
                    [ 'campo.regla1'=>'mensaje1' ]
                 */
                [ 'mkNombre'=>'required|unique:marcas,mkNombre|min:2|max:30' ],
                [
                    'mkNombre.required'=>'El campo "Nombre de la marca" es obligatorio',
                    'mkNombre.unique'=>'Ya existe una marca con ese nombre',
                    'mkNombre.min'=>'El campo "Nombre de la marca" debe tener al menos 2 caractéres',
                    'mkNombre.max'=>'El campo "Nombre de la marca" debe tener 30 caractéres como máximo'
                ]
        );
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : RedirectResponse
    {
        //validación
        $this->validarForm( $request );
        $mkNombre = $request->mkNombre;
        try {
            //instanciamos
            $Marca = new Marca;
            //asignamos atributos
            $Marca->mkNombre = $mkNombre;
            //almacenamos en tabla marcas
            $Marca->save();
            return redirect('/marcas')
                    ->with([
                            'mensaje'=>'Marca: '.$mkNombre.' agregada correctamente.',
                            'css'=>'success'
                            ]);
        }
        catch ( \Throwable $th ){
            return redirect('/marcas')
                ->with([
                    'mensaje'=>'No se pudo agregar la marca: '.$mkNombre,
                    'css'=>'danger'
                ]);
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
    public function edit(string $id) : View
    {
        //obtenemos datos de una marca filtrada por su id
        $Marca = Marca::find($id);
        return view('marcaEdit', [ 'Marca'=>$Marca ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request) : RedirectResponse
    {
        //validación
        $this->validarForm( $request );
        $mkNombre = $request->mkNombre;
        try {
            //obtenemos marca por su id
            $Marca = Marca::find($request->idMarca);
            //reasignamos valores de atributos
            $Marca->mkNombre = $mkNombre;
            $Marca->save();
            return redirect('/marcas')
                ->with([
                    'mensaje'=>'Marca: '.$mkNombre.' modificada correctamente.',
                    'css'=>'success'
                ]);
        }
        catch ( \Throwable $th ){
            return redirect('/marcas')
                ->with([
                    'mensaje'=>'No se pudo modificar la marca: '.$mkNombre,
                    'css'=>'danger'
                ]);
        }
    }

    public function confirmarBaja()
    {
        
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
