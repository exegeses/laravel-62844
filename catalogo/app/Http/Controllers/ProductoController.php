<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        //obtenemos listado de productos
        /*
        $productos = Producto::join('marcas', 'marcas.idMarca', '=','productos.idMarca')
                                ->join('categorias', 'categorias.idCategoria', '=', 'productos.idCategoria')
                                ->paginate(8);
        */
        $productos = Producto::with(['getMarca','getCategoria'])->paginate(8);
        return view('productos', [ 'productos'=>$productos ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        //obtenemos listado de marcas y de categorias
        $marcas = Marca::all();
        $categorias = Categoria::all();
        return view('productoCreate',
                [
                    'marcas'=>$marcas,
                    'categorias'=>$categorias
                ]
            );
    }

    private function validarForm(Request $request)
    {
        $request->validate(
            [
                'prdNombre'=>'required|min:2|max:30',
                'prdPrecio'=>'required|numeric|min:0',
                'idMarca'=>'required',
                'idCategoria'=>'required',
                'prdDescripcion'=>'required|min:3|max:150',
                'prdImagen'=>'mimes:png,jpg,jpeg,webp,svg,gif|max:2048'
            ],
            [
                'prdNombre.required' => 'El campo "Nombre del producto" es obligatorio.',
                'prdNombre.min'=>'El campo "Nombre del producto" debe tener como mínimo 2 caractéres.',
                'prdNombre.max'=>'El campo "Nombre" debe tener 30 caractéres como máximo.',
                'prdPrecio.required'=>'Complete el campo Precio.',
                'prdPrecio.numeric'=>'Complete el campo Precio con un número.',
                'prdPrecio.min'=>'Complete el campo Precio con un número mayor a 0.',
                'idMarca.required'=>'Seleccione una marca.',
                'idCategoria.required'=>'Seleccione una categoría.',
                'prdDescripcion.required'=>'Complete el campo Descripción.',
                'prdDescripcion.min'=>'Complete el campo Descripción con al menos 3 caractéres',
                'prdDescripcion.max'=>'Complete el campo Descripción con 150 caractéres como máxino.',
                'prdImagen.mimes'=>'Debe ser una imagen.',
                'prdImagen.max'=>'Debe ser una imagen de 2MB como máximo.'
            ]
        );
    }

    private function subirImagen( Request $request ) : string
    {
        //si no enviaron una imagen en productoCreate
        $prdImagen = 'noDisponible.png';

        //si no enviaron imagen en productoEdit
        if( $request->has('imgActual') ){
            $prdImagen = $request->imgActual;
        }

        //si enviaron imagen
        if( $request->file('prdImagen') ){
            $archivo = $request->file('prdImagen');
            //renombramos archivo
            $extension = $archivo->getClientOriginalExtension();
            $prdImagen = time().'.'.$extension;
            //movemos archivo a directorio
            $archivo->move( public_path('imagenes/productos/'), $prdImagen );
        }

        return $prdImagen;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : RedirectResponse
    {
        $prdNombre = $request->prdNombre;
        //validación
        $this->validarForm($request);

        //subir imagen *
        $prdImagen = $this->subirImagen( $request );
        try {
            $Producto = new Producto;
            $Producto->prdNombre = $prdNombre;
            $Producto->prdPrecio = $request->prdPrecio;
            $Producto->idMarca = $request->idMarca;
            $Producto->idCategoria = $request->idCategoria;
            $Producto->prdDescripcion = $request->prdDescripcion;
            $Producto->prdImagen = $prdImagen;
            //$Producto->prdActivo = 1;
            $Producto->save();
            return redirect('/productos')
                ->with(
                    [
                        'mensaje'=>'Producto: '.$prdNombre.' agregado correctamente.',
                        'css'=>'success'
                    ]
                );
        }
        catch ( Throwable $th ){
            return redirect('/productos')
                ->with(
                    [
                        'mensaje'=>'No se puedo agregar el roducto: '.$prdNombre,
                        'css'=>'danger'
                    ]
                );
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id ) : View
    {
        //obtenemos datos de Producto
        $Producto = Producto::find($id);
        //obtenemos listados de marcas y de categorias
        $marcas = Marca::all();
        $categorias = Categoria::all();
        return view('productoEdit',
            [
                'Producto'=>$Producto,
                'marcas'=>$marcas,
                'categorias'=>$categorias
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request) : RedirectResponse
    {
        $prdNombre = $request->prdNombre;
        //validación
        $this->validarForm( $request );
        //subir imagen *
        $prdImagen = $this->subirImagen( $request );
        try {
            $Producto = Producto::find($request->idProducto);
            $Producto->prdNombre = $prdNombre;
            $Producto->prdPrecio = $request->prdPrecio;
            $Producto->idMarca = $request->idMarca;
            $Producto->idCategoria = $request->idCategoria;
            $Producto->prdDescripcion = $request->prdDescripcion;
            $Producto->prdImagen = $prdImagen;
            $Producto->save();
            return redirect('/productos')
                ->with(
                    [
                        'mensaje'=>'Producto: '.$prdNombre.' modificado correctamente.',
                        'css'=>'success'
                    ]
                );
        }
        catch ( Throwable $th ){
            return redirect('/productos')
                ->with(
                    [
                        'mensaje'=>'No se puedo modificar el roducto: '.$prdNombre,
                        'css'=>'danger'
                    ]
                );
        }

    }

    public function delete( string $id ) : View
    {
        //obtenemos los datos de un produto
        $Producto = Producto::with(['getMarca','getCategoria'])->find($id);
        return view('productoDelete', [ 'Producto'=>$Producto ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy( Request $request ) : RedirectResponse
    {
        $prdNombre = $request->prdNombre;
        try {
            Producto::destroy($request->idProducto);
            return redirect('/productos')
                ->with(
                    [
                        'mensaje'=>'Producto: '.$prdNombre.' eliminado correctamente.',
                        'css'=>'success'
                    ]
                );
        }
        catch ( Throwable $th ){
            return redirect('/productos')
                ->with(
                    [
                        'mensaje'=>'No se puedo eliminar el roducto: '.$prdNombre,
                        'css'=>'danger'
                    ]
                );
        }
    }
}
