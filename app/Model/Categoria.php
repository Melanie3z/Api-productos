<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    public $table = "categoria";

    protected $fillable = ["id_categoria","nombre_categoria"];

    protected $primaryKey = 'id_categoria';
    
    public $timestamps = false;
}
