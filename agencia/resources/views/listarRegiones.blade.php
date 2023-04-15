@extends( 'layouts.plantilla' )

    @section('contenido')
        <h1>Listado de regiones</h1>

        <ul>
        @foreach( $regiones as $region )
            <li>
                {{ $region->idRegion }}:
                {{ $region->regNombre }}
            </li>
        @endforeach
        </ul>

    @endsection
