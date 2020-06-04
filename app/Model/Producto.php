<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    public $table = "producto";

    protected $fillable = ["id", "nombre_producto", "referencia",
    "precio", "peso", "id_categoria", "stock",
    "fecha_creacion","fecha_ultima_venta"];

    protected $primaryKey = 'id';
    
    public $timestamps = false;
}
