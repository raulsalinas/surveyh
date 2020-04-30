<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class ReportesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */

    public function index()
    {   

        return view('reportes.index');

    }


    function reporte_respuesta_periodo_actual(){
        $ouput=[];
        $status=0;

        $fecha_actual=date('Y-m-d');
        $periodo = DB::table('public.periodo')
        ->select('periodo.*')
        ->where('periodo.fecha_inicio', '<=', $fecha_actual)
        ->where('periodo.fecha_fin', '>=', $fecha_actual)
        ->get();

        if($periodo->first()->id >0){
            $respuesta = DB::table('public.respuesta')
            ->select(
                'respuesta.id as id_respuesta',
                'respuesta.id_pregunta',
                'pregunta.descripcion as pregunta',
                'respuesta.id_escala',
                'escala.descripcion as respuesta',
                'respuesta.id_periodo',
                'periodo.fecha_inicio as escala_fecha_inicio',
                'periodo.fecha_fin as escala_fecha_fin',
                'users.name as user_name',
                'users.email as user_email'
                )
                ->leftJoin('public.pregunta', 'pregunta.id', '=', 'respuesta.id_pregunta')
                ->leftJoin('public.escala', 'escala.id', '=', 'respuesta.id_escala')
                ->leftJoin('public.periodo', 'periodo.id', '=', 'respuesta.id_periodo')
                ->leftJoin('public.users', 'users.id', '=', 'respuesta.id_usuario')
                ->leftJoin('public.tipo_encuesta', 'tipo_encuesta.id', '=', 'pregunta.id_tipo_encuesta')
            ->where([
                ['respuesta.id_periodo','=',  $periodo->first()->id]
                ])
            ->orderBy('respuesta.id', 'asc')
            ->get();
        
            if(count($respuesta)>0){
                $status=200;

            }else{
                $status=500;
            }
        

        }else{
            $status=500;
        }
        $ouput=['status'=> $status, 'data'=>$respuesta];


        return response()->json($ouput);

    }

}