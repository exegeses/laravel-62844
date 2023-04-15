@extends( 'layouts.plantilla' )

    @section('contenido')

        <h1>Proceso de datos enviados</h1>

        @if( $nombre == 'marcos' )
            Bienvenido {{ $nombre }}
        @else
            usuario desconocido
        @endif

    <hr>
        @for( $i=0; $i<$numero; $i++ )
            {{ $i }}<br>
        @endfor
    <hr>

        <ul>
        @foreach( $marcas as $marca )
            <li>{{ $marca }}</li>
        @endforeach
        </ul>
    @endsection
