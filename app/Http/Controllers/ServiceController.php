<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    /**
     * Obtiene todos las filas de una tabla especificada.
     *  el campo identificador de ir de ultimo as id
     * @return response json nombre del item manejado, cabeceras y filas
     */
    public function getAllRows()
    {
        $rows = DB::table('services')
        ->select(
            'nombre',
            'imagen',
            'tipo',
            'fecha_inicio',
            'fecha_fin',
            'observaciones',
            'id_servicio AS id'
            )
        ->get();
        $headers = [
            'Nombre',
            'Imagen',
            'Tipo',
            'Fecha Inicio',
            'Fecha Final',
            'Observaciones'
        ];

        $fields = [
            'nombre' => '',
            'imagen' => '',
            'tipo' => '',
            'fecha_inicio' => '',
            'fecha_fin' => '',
            'observaciones' => ''
        ];

        $item = 'servicio';
        
        return [ 'item' => $item, 'headers' => $headers, 'rows' => $rows, 'fields' => $fields ];
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('servicios.index');
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
        $result = DB::table('services')
        ->insert([
            'nombre' => $request->nombre,
            'imagen' => $request->imagen,
            'tipo' => $request->tipo,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'observaciones' => $request->observaciones
        ]);
        return  $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        $result = DB::table('services')
        ->where('id_servicio', $request->id)
        ->update([
            'nombre' => $request->nombre,
            'imagen' => $request->imagen,
            'tipo' => $request->tipo,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'observaciones' => $request->observaciones
        ]);
        return  $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        //
    }
}
