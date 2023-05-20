@extends('layouts.plantilla')
@section('contenido')

    <h1>Modificación de un producto</h1>

    <div class="alert p-4 col-8 mx-auto shadow">
        <form action="/producto/update" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')
            <div class="form-group mb-4">
                <label for="prdNombre">Nombre del Producto</label>
                <input type="text" name="prdNombre"
                       value="{{ old('prdNombre', $Producto->prdNombre ) }}"
                       class="form-control" id="prdNombre">
                @if ($errors->has('prdNombre'))
                    <span class="fs-6 text-danger">{{ $errors->first('prdNombre') }}</span>
                @endif
            </div>

            <label for="prdPrecio">Precio del Producto</label>
            <div class="mb-4">
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">$</div>
                </div>
                <input type="number" name="prdPrecio"
                       value="{{ old('prdPrecio', $Producto->prdPrecio) }}"
                       class="form-control" id="prdPrecio" min="0" step="0.01">
            </div>
            @if ($errors->has('prdPrecio'))
                <span class="mt-0 fs-6 text-danger">{{ $errors->first('prdPrecio') }}</span>
            @endif
            </div>

            <div class="form-group mb-4">
                <label for="idMarca">Marca</label>
                <select class="form-select" name="idMarca" id="idMarca">
                    <option value="">Seleccione una marca</option>
            @foreach( $marcas as $marca )
                    <option @selected( $marca->idMarca == old('idMarca', $Producto->idMarca) ) value="{{ $marca->idMarca }}">{{ $marca->mkNombre }}</option>
            @endforeach
                </select>
                @if ($errors->has('idMarca'))
                    <span class="fs-6 text-danger">{{ $errors->first('idMarca') }}</span>
                @endif
            </div>

            <div class="form-group mb-4">
                <label for="idCategoria">Categoría</label>
                <select class="form-select" name="idCategoria" id="idCategoria">
                    <option value="">Seleccione una categoría</option>
            @foreach( $categorias as $categoria )
                    <option @selected( $categoria->idCategoria == old('idCategoria', $Producto->idCategoria) ) value="{{ $categoria->idCategoria }}">{{ $categoria->catNombre }}</option>
            @endforeach
                </select>
                @if ($errors->has('idCategoria'))
                    <span class="fs-6 text-danger">{{ $errors->first('idCategoria') }}</span>
                @endif
            </div>

            <div class="form-group mb-4">
                <label for="prdDescripcion">Descripción del Producto</label>
                <textarea name="prdDescripcion" class="form-control" id="prdDescripcion">{{ old('prdDescripcion', $Producto->prdDescripcion) }}</textarea>
                @if ($errors->has('prdDescripcion'))
                    <span class="mt-0 fs-6 text-danger">{{ $errors->first('prdDescripcion') }}</span>
                @endif
            </div>

            <div>
                Imagen actual:
                <figure class="d-flex justify-content-center">
                    <img src="/imagenes/productos/{{ $Producto->prdImagen }}" class="img-thumbnail">
                </figure>
            </div>

            <div class="custom-file mt-1 mb-4">
                Modificar imagen (opcional):
                <input type="file" name="prdImagen"  class="custom-file-input" id="customFileLang" lang="es">
                <label class="custom-file-label" for="customFileLang" data-browse="Buscar en disco">Seleccionar Archivo: </label>
                @if ($errors->has('prdImagen'))
                    <span class="mt-0 fs-6 text-danger">{{ $errors->first('prdImagen') }}</span>
                @endif
            </div>

            <input type="hidden" name="imgActual"
                   value="{{ $Producto->prdImagen }}">
            <input type="hidden" name="idProducto"
                   value="{{ $Producto->idProducto }}">

            <button class="btn btn-dark mr-3 px-4">Modificar producto</button>
            <a href="/productos" class="btn btn-outline-secondary">
                Volver a panel de productos
            </a>

        </form>
    </div>
    @if( $errors->any() )
        <div class="alert alert-danger p-4 col-8 mx-auto">
            <ul>
                @foreach( $errors->all() as $error )
                    <li>
                        <i class="bi bi-exclamation-triangle"></i>
                        {{ $error }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

@endsection
