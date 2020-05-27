<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class EncuestaController extends Controller
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
        $procentaje_avance_encuesta_satisfaccion= $this->procentaje_avance_encuesta(1);
        $procentaje_avance_encuesta_liderazgo= $this->procentaje_avance_encuesta(2);
        
        return view('survey',compact('procentaje_avance_encuesta_satisfaccion','procentaje_avance_encuesta_liderazgo'));

     }

    function procentaje_avance_encuesta($tipo_encuesta){
        $session = Auth::user();
        $id_usuario = $session->id;
        $status=0;
        $procentaje_avance=0;

        $preguntas = DB::table('public.pregunta')
        ->select('pregunta.*')
        ->where([
            ['pregunta.id_tipo_encuesta','=',  $tipo_encuesta]
            ])
        ->orderBy('pregunta.id', 'asc')
        ->get();

        $preguntas_id_list=[];
        if(count($preguntas)>0){
            $status=200;
            foreach($preguntas as $data){
                $preguntas_id_list[]=$data->id;
            }
        }else{
            $status=500;
        }

        $fecha_actual=date('Y-m-d');
        $periodo = DB::table('public.periodo')
        ->select('periodo.*')
        ->where('periodo.fecha_inicio', '<=', $fecha_actual)
        ->where('periodo.fecha_fin', '>=', $fecha_actual)
        ->get();

        if(count($periodo) >0){
            if($periodo->first()->id >0){
                $respuesta = DB::table('public.respuesta')
                ->select('respuesta.*')
                ->where([
                    ['respuesta.id_usuario','=',  $id_usuario],
                    ['respuesta.id_periodo','=',  $periodo->first()->id]
                    ])
                ->whereIn('respuesta.id_pregunta',$preguntas_id_list)
                ->orderBy('respuesta.id', 'asc')
                ->get();
    
                $respuestas_id_list=[];
                if(count($respuesta)>0){
                    $status=200;
                    foreach($respuesta as $data){
                        $respuestas_id_list[]=$data->id;
                    }
                    $total_preguntas=count($preguntas_id_list);
                    $total_respuestas=count($respuestas_id_list);
                    
                    if($total_preguntas >0 && $total_respuestas >=0){
                        $procentaje_avance= doubleval(number_format((($total_respuestas*100)/$total_preguntas),2));
                    }else{
                        $procentaje_avance=0;
                    }

                }else{
                    $status=500;
    
                }
    
            }else{
                $status=500;
            }
        }else{
            $status=500;

        }



 


        $ouput=['status'=> $status, 'porcentaje_avance'=>$procentaje_avance];
        return $ouput;
    }

   
    public function survey_form($tipo)
    {
        if($tipo == 'satisfaccion'){
            $id_tipo_encuesta=1;
        }else if($tipo == 'liderazgo'){
            $id_tipo_encuesta=2;
        }

        $escalas = $this->get_escalas();
        $tipo_encuesta = $this->get_tipo_encuesta_by_id($id_tipo_encuesta);
        $preguntas = $this->get_preguntas_usuario($tipo_encuesta);
        // $preguntas = [];
        $usuario =  Auth::user();
        return view('survey.form',compact('tipo_encuesta','escalas','preguntas', 'usuario'));
    }

    
    function get_escalas(){
        $escalas = DB::table('public.escala')
        ->select('escala.*')
        ->orderBy('escala.id', 'asc')
        ->get();
        return $escalas;
    }

    public function get_tipo_encuesta_by_id($tipo){
        $tipo_encuesta = DB::table('public.tipo_encuesta')
        ->select('tipo_encuesta.*')
        ->where('tipo_encuesta.id','=', $tipo)
        // ->where('tipo_encuesta.descripcion','ilike', '%'.$tipo.'%')
        ->orderBy('tipo_encuesta.id', 'asc')
        ->first();
        return $tipo_encuesta;
        // return response()->json($tipo_encuesta);

    }

    function get_encuesta_respondida($id_tipo_encuesta){
        $session = Auth::user();
        $id_usuario = $session->id;
        $fecha_actual=date('Y-m-d');

        $periodo = DB::table('public.periodo')
        ->select('periodo.*')
        ->where('periodo.fecha_inicio', '<=', $fecha_actual)
        ->where('periodo.fecha_fin', '>=', $fecha_actual)
        ->get();

        $id_periodo_list=[];

        foreach($periodo as $data){
            $id_periodo_list[]= $data->id;
        }

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
            ['respuesta.id_usuario', '=', $id_usuario],
            ['pregunta.id_tipo_encuesta','=',$id_tipo_encuesta]
        ])
        ->whereIn('respuesta.id_periodo', $id_periodo_list)
        ->get();

 
        return $respuesta;
    }

    function refresh_preguntas_usuario(Request $request){
       $preguntas = $this->get_preguntas_usuario($request);
        return response()->json($preguntas);

    }
    
    function get_preguntas_usuario($tipo_encuesta){
        $id_tipo_encuesta= $tipo_encuesta->id;
        $preguntas = $this->get_preguntas($id_tipo_encuesta);

        $preguntas_respuesta=[];
        foreach($preguntas as $data){
            $preguntas_respuesta[]=[
                'id'=>$data->id,
                'pregunta'=>$data->descripcion,
                'id_periodo'=>'',
                'respuesta'=>''
            ];
        }
        $pregunta_respondida = $this->get_encuesta_respondida($id_tipo_encuesta);

        foreach($preguntas_respuesta as $keyPreguntaRespuesta => $dataPreguntaRespuesta){
            foreach($pregunta_respondida as $keyPreguntaRespondida => $dataPreguntaRespondida){
                $preguntas_respuesta[$keyPreguntaRespuesta]['id_periodo'] = $dataPreguntaRespondida->id_periodo;

                if($dataPreguntaRespuesta['id'] == $dataPreguntaRespondida->id_pregunta){
                    $preguntas_respuesta[$keyPreguntaRespuesta]['respuesta'] = $dataPreguntaRespondida->id_escala;
                }
            } 
        } 
        return $preguntas_respuesta;

    }

    function get_preguntas($id_tipo_encuesta){
        $preguntas = DB::table('public.pregunta')
        ->select('pregunta.*')
        ->where('pregunta.id_tipo_encuesta','=', $id_tipo_encuesta)
        ->orderBy('pregunta.id', 'asc')
        ->get();
        return $preguntas;
    }


    function guardar_respuesta(Request $request){
        $id_usuario = $request->id_usuario;
        $id_pregunta = $request->id_pregunta;
        $id_escala = $request->id_escala;
        $id_periodo = $request->id_periodo;
        $status='';
        $respuesta_save=0;
        $respuesta_actualizada=0;

        $pregunta = DB::table('public.respuesta')
        ->select('respuesta.*')
        ->where([
            ['respuesta.id_pregunta','=', $id_pregunta],
            ['respuesta.id_periodo','=', $id_periodo],
            ['respuesta.id_usuario','=', $id_usuario],
        ])
        ->orderBy('respuesta.id', 'asc')
        ->get();

        if($pregunta->count() >0){
            $id_pregunta_existente = $pregunta->first()->id;
        
            $respuesta_actualizada = DB::table('public.respuesta')
            ->where('respuesta.id' ,$id_pregunta_existente)
            ->update([
                'id_escala' => $id_escala
            ]);
        }else{

            $respuesta_save = DB::table('public.respuesta')->insertGetId(
                [
                    'id_pregunta'       => $id_pregunta,
                    'id_usuario'         => $id_usuario,
                    'id_escala'         => $id_escala,
                    'id_periodo'        => $id_periodo,        
                    'created_at'        => date('Y-m-d H:i:s'),
                    'updated_at'        => date('Y-m-d H:i:s')
                ],
                'id'
            );

        }



        if($respuesta_save > 0 || $respuesta_actualizada > 0){
            $status =200;
        }

        $output=['status'=>$status];

        return json_encode($output);
    }

}
