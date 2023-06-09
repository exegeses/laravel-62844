<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;
    protected $primaryKey = 'idMarca';
    protected $fillable = [ 'mkNombre' ];
    // protected $guarded = []; //cuidado!
    public $timestamps = false;
}
