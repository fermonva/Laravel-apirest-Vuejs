<?php

namespace App\Http\Controllers;

use App\Productos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductosController extends Controller
{

    public function consultarProductos()
    {

        //Consultar accesos de inicio se sesiÃ³n
        $productos = DB::select("SELECT  p.* , e.nombre as estado, b.nombre as bodega
        			 FROM productos p
                                inner join estados e on p.id_estado = e.id_estado
                                inner join  bodegas b on p.id_bodega = b.id_bodega");

        // Validar la información de la consulta y mostrar respuesta
        if (!empty($productos)) {
            $json = array(
                "code" => 200,
                "status" => "success",
                "total_results" => count($productos),
                "productos" => $productos
            );
        } else {
            $json = array(
                "code" => 404,
                "status" => "error",
                "total_results" => 0,
                "message" => "Ningun registro encontrado"
            );
        }

        return response()->json($json);
    }


    public function consultarEstados()
    {
        $estados = DB::select('SELECT  *  FROM estados e');

        // Validar la información de la consulta y mostrar respuesta
        if (!empty($estados)) {
            $json = array(
                "code" => 200,
                "status" => "success",
                "total_results" => count($estados),
                "estados" => $estados
            );
        } else {
            $json = array(
                "code" => 404,
                "status" => "error",
                "total_results" => 0,
                "message" => "Ningun registro encontrado"
            );
        }

        return response()->json($json);
    }


    public function editarProducto(Request $request)
    {

        $productos = Productos::findOrFail($request->id_producto);

        // Validar la información de la consulta y mostrar respuesta
        if (!empty($request)) {

            $validator = Validator::make(
                $request->all(),
                [
                    'id_producto' => 'required|integer',
                    'nombre'      => 'required|string',
                    'codigo'      => 'required|string',
                    'existencia'  => 'required|integer',
                    'bodega'      => 'nullable|string',
                    'descripcion' => 'required|string',
                    'id_estado'   => 'required|integer',
                ]
            );

            if ($validator->fails()) {

                $errors = $validator->errors();

                $json = array(
                    "code" => 400,
                    "status" => "error",
                    "errors" => $errors,
                    "message" => "El producto no se ha guardado"
                );
            } else {

                // Inicia la transaccion para guardar datos
                DB::beginTransaction();
                try {

                    $productos->nombre = $request->nombre;
                    $productos->codigo = $request->codigo;
                    $productos->existencia = $request->existencia;
                    $productos->id_bodega = 1;
                    $productos->descripcion = $request->descripcion;
                    $productos->id_estado = $request->id_estado;

                    $productos->save();


                    $json = array(
                        "code" => 200,
                        "status" => "success",
                        "message" => "Datos actualizados corectamente",
                        "producto" => $productos
                    );

                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();

                    $json = array(
                        "code" => 422,
                        "status" => "error",
                        "errors" => $e->getMessage(),
                    );
                } //FINALIZA Inicia la transacción
            }
        }

        return response()->json($json);
    }

    public function crearProducto(Request $request)
    {

        // Validar la información de la consulta y mostrar respuesta
        if (!empty($request)) {

            $validator = Validator::make(
                $request->all(),
                [
                    'nombre'      => 'required|string',
                    'codigo'      => 'required|string',
                    'existencia'  => 'required|integer',
                    'bodega'      => 'nullable|string',
                    'descripcion' => 'required|string',
                    'id_estado'   => 'required|integer',
                ]
            );

            if ($validator->fails()) {

                $errors = $validator->errors();

                $json = array(
                    "code" => 400,
                    "status" => "error",
                    "errors" => $errors,
                    "message" => "El producto no se ha guardado"
                );
            } else {

                // Inicia la transaccion para guardar datos
                DB::beginTransaction();
                try {

                    $productos = new Productos();

                    $productos->nombre = $request->nombre;
                    $productos->codigo = $request->codigo;
                    $productos->existencia = $request->existencia;
                    $productos->id_bodega = 1;
                    $productos->descripcion = $request->descripcion;
                    $productos->id_estado = $request->id_estado;

                    $productos->save();


                    $json = array(
                        "code" => 200,
                        "status" => "success",
                        "message" => "Datos guardados corectamente",
                        "producto" => $productos
                    );

                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();

                    $json = array(
                        "code" => 422,
                        "status" => "error",
                        "errors" => $e->getMessage(),
                    );
                } //FINALIZA Inicia la transacción
            }
        }

        return response()->json($json);
    }
}