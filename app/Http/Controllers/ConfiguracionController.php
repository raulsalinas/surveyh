<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class ConfiguracionController extends Controller
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
    public function configuracion_pregunta_index()
    {       
        return view('configuracion.pregunta');
    }
    public function configuracion_tipo_encuesta_index()
    {       
        return view('configuracion.tipo_encuesta');
    }
    public function configuracion_periodo_index()
    {       
        return view('configuracion.periodo');
    }

    
    function get_pregunta(){
        $pregunta = DB::table('public.pregunta')
        ->select(
            'pregunta.*',
            'tipo_encuesta.descripcion as tipo_encuesta_descripcion'
            )
        ->leftJoin('public.tipo_encuesta', 'tipo_encuesta.id', '=', 'pregunta.id_tipo_encuesta')

        ->orderBy('pregunta.id', 'asc')
        ->get();
        return response()->json($pregunta);

    }
    function get_pregunta_by_id($id){
        $pregunta = DB::table('public.pregunta')
        ->select(
            'pregunta.*',
            'tipo_encuesta.descripcion as tipo_encuesta_descripcion'
            )
        ->leftJoin('public.tipo_encuesta', 'tipo_encuesta.id', '=', 'pregunta.id_tipo_encuesta')
        ->where('pregunta.id' ,$id)
        ->orderBy('pregunta.id', 'asc')
        ->first();
        return response()->json($pregunta);

    }

    function guardar_pregunta(Request $request){
        $pregunta= $request->pregunta;
        $tipo_encuesta= $request->tipo_encuesta;
        $output=0;

        $pregunta = DB::table('public.pregunta')->insertGetId(
            [
                'descripcion'       => $pregunta,
                'id_tipo_encuesta'  => $tipo_encuesta,        
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => date('Y-m-d H:i:s')
            ],
            'id'
        );
        if($pregunta > 0){
            $status =200;
        }
        $output=['status'=>$status];
        return json_encode($output);
    }

    function eliminar_pregunta($id){
        $status=0;
        $pregunta = DB::table('public.pregunta')
        ->where('pregunta.id' ,$id)
        ->delete();
        if($pregunta>0){
            $status=200;
        }
        $output=['status'=>$status];

        return response()->json($output);
    }

    function actualizar_pregunta(Request $request){
        $id= $request->id;
        $pregunta= $request->pregunta;
        $tipo_encuesta= $request->tipo_encuesta;
        $output=0;

        $pregunta = DB::table('public.pregunta')
        ->where('id' ,$id)
        ->update(
            [
                'descripcion'       => $pregunta,
                'id_tipo_encuesta'  => $tipo_encuesta,        
                'updated_at'        => date('Y-m-d H:i:s')
            ],
            'id'
        );
        if($pregunta > 0){
            $status =200;
        }
        $output=['status'=>$status];
        return json_encode($output);
    }



    function get_tipo_encuesta(){
        $tipo_encuesta = DB::table('public.tipo_encuesta')
        ->select('tipo_encuesta.*')
        ->orderBy('tipo_encuesta.id', 'asc')
        ->get();
        return response()->json($tipo_encuesta);
    }

    function get_tipo_encuesta_by_id($id){
        $tipo_encuesta = DB::table('public.tipo_encuesta')
        ->select('tipo_encuesta.*')
        ->where('tipo_encuesta.id' ,$id)
        ->orderBy('tipo_encuesta.id', 'asc')
        ->first();
        return response()->json($tipo_encuesta);
    }
    
    function actualizar_tipo_encuesta(Request $request){
        $id= $request->id;
        $descripcion= $request->descripcion;
        $output=0;

        $tipo_encuesta = DB::table('public.tipo_encuesta')
        ->where('id' ,$id)
        ->update(
            [
                'descripcion'       => $descripcion,
                'updated_at'        => date('Y-m-d H:i:s')
            ],
            'id'
        );
        if($tipo_encuesta > 0){
            $status =200;
        }
        $output=['status'=>$status];
        return json_encode($output);
    }



    function get_periodo(){
        $periodo = DB::table('public.periodo')
        ->select('periodo.*')
        ->orderBy('periodo.id', 'asc')
        ->get();
        return response()->json($periodo);
    }

    function get_periodo_by_id($id){
        $periodo = DB::table('public.periodo')
        ->select('periodo.*')
        ->where('periodo.id' ,$id)
        ->orderBy('periodo.id', 'asc')
        ->first();
        return response()->json($periodo);
    }

    function guardar_periodo(Request $request){
        $request_fecha_inicio = new \DateTime($request->fecha_inicio);
        $fecha_inicio = $request_fecha_inicio->format('Y-m-d');
        $request_fecha_fin = new \DateTime($request->fecha_fin);
        $fecha_fin = $request_fecha_fin->format('Y-m-d');
        $output=0;

        $periodo = DB::table('public.periodo')->insertGetId(
            [
                'fecha_inicio'  => $fecha_inicio,
                'fecha_fin'     => $fecha_fin,        
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s')
            ],
            'id'
        );
        if($periodo > 0){
            $status =200;
        }
        $output=['status'=>$status];
        return json_encode($output);
    }

    function actualizar_periodo(Request $request){
        $id= $request->id;
        $request_fecha_inicio = new \DateTime($request->fecha_inicio);
        $fecha_inicio = $request_fecha_inicio->format('Y-m-d');
        $request_fecha_fin = new \DateTime($request->fecha_fin);
        $fecha_fin = $request_fecha_fin->format('Y-m-d');
       
        $output=0;

        $periodo = DB::table('public.periodo')
        ->where('id' ,$id)
        ->update(
            [
                'fecha_inicio'  => $fecha_inicio,
                'fecha_fin'     => $fecha_fin,        
                'updated_at'    => date('Y-m-d H:i:s')
            ],
            'id'
        );
        if($periodo > 0){
            $status =200;
        }
        $output=['status'=>$status];
        return json_encode($output);
    }

    function eliminar_periodo($id){
        $status=0;
        $periodo = DB::table('public.periodo')
        ->where('periodo.id' ,$id)
        ->delete();
        if($periodo>0){
            $status=200;
        }
        $output=['status'=>$status];

        return response()->json($output);
    }


}





