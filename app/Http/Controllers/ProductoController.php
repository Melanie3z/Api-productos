<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Producto;
use App\Model\Categoria;
use Config;


use Validator;

class ProductoController extends Controller
{

    public function index()
    {

        try {
            $productos = Producto::select("producto.*", "categoria.nombre_categoria")
                ->join("categoria", "producto.id_categoria", "=", "categoria.id_categoria")
                ->get();
            $categorias = Categoria::all();

            return response()->json([
                Config::get('constants.respuesta_json_ok') => true,
                Config::get('constants.respuesta_json_data') => $productos,
                Config::get('constants.respuesta_json_ok_categorias') =>  $categorias,
            ], 200);
        } catch (\Exception $ex) {
            return response()->json([
                Config::get('constants.respuesta_json_ok') => false,
                Config::get('constants.respuesta_json_error') => Config::get('constants.error_de_servidor')
            ], 500);
        }
    }


    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [

            'nombre_producto' => 'required|max:30',
            'referencia' => 'required|max:20',
            'precio' => 'required|numeric',
            'peso' => 'required|numeric',
            'id_categoria' => 'required|numeric',
            'stock' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                Config::get('constants.respuesta_json_ok') => false,
                Config::get('constants.respuesta_json_error') => Config::get('constants.error_diligenciar_campos')
            ], 400);
        }

        try {
            Producto::create($input);

            return response()->json([
                Config::get('constants.respuesta_json_ok') => true,
                Config::get('constants.respuesta_json_mensaje') => Config::get('constants.registro_exitoso')
            ], 200);
        } catch (\Exception $ex) {
            return response()->json([
                Config::get('constants.respuesta_json_ok') => false,
                Config::get('constants.respuesta_json_error') => Config::get('constants.error_de_servidor')
            ], 500);
        }
    }


    public function show($id)
    {


        try {

            $productos = Producto::select("producto.*", "categoria.nombre_categoria")
                ->join("categoria", "producto.id_categoria", "=", "categoria.id_categoria")
                ->where("producto.id", $id)
                ->first();

            return response()->json([
                Config::get('constants.respuesta_json_ok') => true,
                Config::get('constants.respuesta_json_data') => $productos
            ], 200);
        } catch (\Exception $ex) {
            return response()->json([
                Config::get('constants.respuesta_json_ok') => false,
                Config::get('constants.respuesta_json_error') => Config::get('constants.error_de_servidor')
            ], 500);
        }
    }


    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'nombre_producto' => 'required|max:30',
            'referencia' => 'required|max:20',
            'precio' => 'required|numeric',
            'peso' => 'required|numeric',
            'id_categoria' => 'required|numeric',
            'stock' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                Config::get('constants.respuesta_json_ok') => false,
                Config::get('constants.respuesta_json_error') => Config::get('constants.error_diligenciar_campos')
            ]);
        }

        try {
            $producto = Producto::find($id);

            if ($producto == false) {
                return response()->json([
                    Config::get('constants.respuesta_json_ok') => false,
                    Config::get('constants.respuesta_json_error') => Config::get('constants.error_producto_no_encontrado')
                ]);
            }

            $producto->update($input);

            return response()->json([
                Config::get('constants.respuesta_json_ok') => true,
                Config::get('constants.respuesta_json_mensaje') => Config::get('constants.actualizacion_exitosa')
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                Config::get('constants.respuesta_json_ok') => false,
                Config::get('constants.respuesta_json_error') => Config::get('constants.error_de_servidor')
            ], 500);
        }
    }


    public function destroy($id)
    {
        try {
            $producto = Producto::find($id);

            if ($producto == false) {
                return response()->json([
                    Config::get('constants.respuesta_json_ok') => false,
                    Config::get('constants.respuesta_json_error') => Config::get('constants.error_producto_no_encontrado')
                ]);
            }

            $producto->delete($id);

            return response()->json([
                Config::get('constants.respuesta_json_ok') => true,
                Config::get('constants.respuesta_json_mensaje') => Config::get('constants.eliminacion_exitosa')
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                Config::get('constants.respuesta_json_ok') => false,
                Config::get('constants.respuesta_json_error') => Config::get('constants.error_de_servidor')
            ], 500);
        }
    }
}
