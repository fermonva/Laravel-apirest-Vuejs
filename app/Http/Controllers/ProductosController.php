<?php

namespace App\Http\Controllers;

use App\Productos;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductosController extends Controller
{



    public function consultarDatos()
    {

        //Consultar accesos de inicio se sesiÃ³n
        $productos = DB::select("SELECT  p.* , e.nombre as estado, b.nombre as bodega FROM productos p
                                inner join estados e on p.id_estado = e.id_estado
                                inner join  bodegas b on p.id_bodega = b.id_bodega");

        $estados = DB::select('SELECT  *  FROM estados e');

        //Respuesta positiva
        return response()->json([
            'productos' => $productos, 'estados' => $estados //Perfiles
        ], 200);
    }


    public function editarProducto(Request $request)
    {


        $request->validate([
            'id_producto' => 'required|integer',
            'nombre'      => 'required|string',
            'codigo'      => 'required|string',
            'existencia'  => 'required|integer',
            'bodega'      => 'nullable|string',
            'descripcion' => 'required|string',
            'estado'      => 'required|integer',
        ]);


        $productos = Productos::findOrFail($request->id_producto);

        // Inicia la transaccion
        DB::beginTransaction();
        try {

            $productos->nombre = $request->nombre;
            $productos->codigo = $request->codigo;
            $productos->existencia = $request->existencia;
            $productos->id_bodega = 1;
            $productos->descripcion = $request->descripcion;
            $productos->id_estado = $request->estado;

            $productos->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            /*
            return response()->json([
                'message' => 'Error!',
                'errors' => (object) [
                    'Error' => [
                        $e->getMessage()
                    ]
                ]
            ], 422);
            */
        } //FINALIZA Inicia la transacción




        return response()->json([
            'msg' => 'Su producto a sido editado',
        ], 200);
    }

    public function crearProducto(Request $request)
    {


        $request->validate([
            'nombre'      => 'required|string',
            'codigo'      => 'required|string',
            'existencia'  => 'required|integer',
            'bodega'      => 'nullable|string',
            'descripcion' => 'required|string',
            'estado'      => 'required|integer',
        ]);



        DB::beginTransaction();
        try {

            $productos = new Productos();

            $productos->nombre = $request->nombre;
            $productos->codigo = $request->codigo;
            $productos->existencia = $request->existencia;
            $productos->id_bodega = 1;
            $productos->descripcion = $request->descripcion;
            $productos->id_estado = $request->estado;


            $productos->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            var_dump($e);

            /*
            return response()->json([
                'message' => 'Error!',
                'errors' => (object) [
                    'Error' => [
                        $e->getMessage()
                    ]
                ]
            ], 422);
            */
        } //FINALIZA Inicia la transacción

        return response()->json(
            [
                'msg' => 'Su producto a sido Guardado',
            ],
            200
        );
    }




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Productos  $productos
     * @return \Illuminate\Http\Response
     */
    public function show(Productos $productos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Productos  $productos
     * @return \Illuminate\Http\Response
     */
    public function edit(Productos $productos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Productos  $productos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Productos $productos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Productos  $productos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Productos $productos)
    {
        //
    }
}