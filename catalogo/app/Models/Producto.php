<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'idProducto';
    /**
     * método para chekear si hay productos relacionados a una marca
     */
    static function checkProductoPorMarca( $idMarca )
    {
        return Producto::where('idMarca', $idMarca)->count();
    }
    /* métodos de relación */
    public function getMarca()
    {
        return $this->belongsTo(
                Marca::class,
                'idMarca',
                'idMarca'
        );
    }

    public function getCategoria()
    {
        return $this->belongsTo(
                Categoria::class,
                'idCategoria',
                'idCategoria'
        );
    }
}
