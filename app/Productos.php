<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    //
    protected $table = 'productos';
    protected $primaryKey = 'id_producto';
    protected $fillable = [
        'nombre', 'codigo', 'existencia', 'id_bodega', 'descripcion', 'id_estado'
    ];
    public $timestamps = false;
}