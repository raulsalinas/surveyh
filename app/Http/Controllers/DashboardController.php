<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
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
 

    
    function get_cantidad_encuestas_empezadas(){
        $fecha_actual=date('Y-m-d');
        $output=[];

        $users = DB::table('public.users')
        ->select(
            'users.*'
            )
        ->orderBy('users.id', 'asc')
        ->get();

        $users_id_list=[];
        foreach($users as $data){
            $users_id_list[]=$data->id;
        }

        $respuesta = DB::table('public.respuesta')
        ->select(
            'respuesta.*',
            'tipo_encuesta.id as id_tipo_encuesta'
            )
        ->leftJoin('public.pregunta', 'pregunta.id', '=', 'respuesta.id_pregunta')
        ->leftJoin('public.tipo_encuesta', 'tipo_encuesta.id', '=', 'pregunta.id_tipo_encuesta')
        ->leftJoin('public.periodo', 'periodo.id', '=', 'respuesta.id_periodo')
        ->where('periodo.fecha_inicio', '<=', $fecha_actual)
        ->where('periodo.fecha_fin', '>=', $fecha_actual)
        ->orderBy('respuesta.id', 'asc')
        ->get();

  
        $total_empezadas=0;
        foreach($respuesta as $data){
            if(in_array($data->id_usuario, $users_id_list)){
                $total_empezadas+=1;
            }
        
        }
        

        $respuesta_encuesta_1 = DB::table('public.respuesta')
        ->select(
            'respuesta.*',
            'tipo_encuesta.id as id_tipo_encuesta'
            )
        ->leftJoin('public.pregunta', 'pregunta.id', '=', 'respuesta.id_pregunta')
        ->leftJoin('public.tipo_encuesta', 'tipo_encuesta.id', '=', 'pregunta.id_tipo_encuesta')
        ->leftJoin('public.periodo', 'periodo.id', '=', 'respuesta.id_periodo')
        ->where('periodo.fecha_inicio', '<=', $fecha_actual)
        ->where('periodo.fecha_fin', '>=', $fecha_actual)
        ->where('tipo_encuesta.id', '=', 1)
        ->orderBy('respuesta.id', 'asc')
        ->get();

        $total_empezadas_1=0;
        if($respuesta_encuesta_1){
            foreach($respuesta_encuesta_1 as $data){
                if(in_array($data->id_usuario, $users_id_list)){
                    $total_empezadas_1+=1;
                }
            }
        }


        $respuesta_encuesta_2 = DB::table('public.respuesta')
        ->select(
            'respuesta.*',
            'tipo_encuesta.id as id_tipo_encuesta'
            )
        ->leftJoin('public.pregunta', 'pregunta.id', '=', 'respuesta.id_pregunta')
        ->leftJoin('public.tipo_encuesta', 'tipo_encuesta.id', '=', 'pregunta.id_tipo_encuesta')
        ->leftJoin('public.periodo', 'periodo.id', '=', 'respuesta.id_periodo')
        ->where('periodo.fecha_inicio', '<=', $fecha_actual)
        ->where('periodo.fecha_fin', '>=', $fecha_actual)
        ->where('tipo_encuesta.id', '=', 2)
        ->orderBy('respuesta.id', 'asc')
        ->get();

        $total_empezadas_2=0;
        if($respuesta_encuesta_2){
            foreach($respuesta_encuesta_2 as $data){
                if(in_array($data->id_usuario, $users_id_list)){
                    $total_empezadas_2+=1;
                }
            }
        }


        $output=['total_empezadas'=>$total_empezadas, 'total_empezadas_satisfaccion'=>$total_empezadas_1, 'total_empezadas_liderazgo'=>$total_empezadas_2];

        return response()->json($output);

    }

    function get_cantidad_encuestas_completadas(){
        $fecha_actual=date('Y-m-d');
        $output=[];

        $users = DB::table('public.users')
        ->select(
            'users.*'
            )
        ->orderBy('users.id', 'asc')
        ->get();

        $users_id_list=[];
        foreach($users as $data){
            $users_id_list[]=$data->id;
        }

        $pregunta = DB::table('public.pregunta')
        ->select(
            'pregunta.*'
            )
        ->orderBy('pregunta.id', 'asc')
        ->get();

        $cantidad_preguntas_satisfaccion=0;
        $cantidad_preguntas_liderazgo=0;
        foreach($pregunta as $data){
            if($data->id_tipo_encuesta== 1){
                $cantidad_preguntas_satisfaccion+=1;
            }else if($data->id_tipo_encuesta== 2){
                $cantidad_preguntas_liderazgo+=1;

            }

        }


        
        $cantidad_completado_satisfaccion =0;

        $respuesta_satisfaccion = DB::table('public.respuesta') // satisfaccion
        ->select(
            'respuesta.*',
            'tipo_encuesta.id as id_tipo_encuesta'
            )
        ->leftJoin('public.pregunta', 'pregunta.id', '=', 'respuesta.id_pregunta')
        ->leftJoin('public.tipo_encuesta', 'tipo_encuesta.id', '=', 'pregunta.id_tipo_encuesta')
        ->leftJoin('public.periodo', 'periodo.id', '=', 'respuesta.id_periodo')
        ->where('periodo.fecha_inicio', '<=', $fecha_actual)
        ->where('periodo.fecha_fin', '>=', $fecha_actual)
        ->where('pregunta.id_tipo_encuesta', '=', 1)
        ->orderBy('respuesta.id', 'asc')
        ->get();
        
        if(count($respuesta_satisfaccion)>0){
            foreach($users as $user){
                $tempSum=0;
                foreach($respuesta_satisfaccion as $respuesta){
                    if($user->id == $respuesta->id_usuario){
                        $tempSum=+1;
                    }
                }
                if($tempSum == $cantidad_preguntas_satisfaccion){
                    $cantidad_completado_satisfaccion=+1;
                }
            }
        }


        $cantidad_completado_liderazgo =0;

        $respuesta_liderazgo= DB::table('public.respuesta') // satisfaccion
        ->select(
            'respuesta.*',
            'tipo_encuesta.id as id_tipo_encuesta'
            )
        ->leftJoin('public.pregunta', 'pregunta.id', '=', 'respuesta.id_pregunta')
        ->leftJoin('public.tipo_encuesta', 'tipo_encuesta.id', '=', 'pregunta.id_tipo_encuesta')
        ->leftJoin('public.periodo', 'periodo.id', '=', 'respuesta.id_periodo')
        ->where('periodo.fecha_inicio', '<=', $fecha_actual)
        ->where('periodo.fecha_fin', '>=', $fecha_actual)
        ->where('pregunta.id_tipo_encuesta', '=', 2)
        ->orderBy('respuesta.id', 'asc')
        ->get();

        if(count($respuesta_liderazgo)>0){
            foreach($users as $user){
                $tempSum=0;
                foreach($respuesta_liderazgo as $respuesta){
                    if($user->id == $respuesta->id_usuario){
                        $tempSum=+1;
                    }
                }
                if($tempSum == $cantidad_preguntas_liderazgo){
                    $cantidad_completado_liderazgo=+1;
                }
            }
        }

        
        $output=[
            'cantidad_total_completado'=>($cantidad_completado_liderazgo+$cantidad_completado_satisfaccion),
            'cantidad_completado_liderazgo'=>$cantidad_completado_liderazgo,
            'cantidad_completado_satisfaccion'=>$cantidad_completado_satisfaccion,
            'cantidad_preguntas_liderazgo'=>$cantidad_preguntas_liderazgo,
            'cantidad_preguntas_satisfaccion'=>$cantidad_preguntas_satisfaccion
        ];

        return response()->json($output);

    }

    function get_cantidad_usuarios(){

        $count_users = DB::table('public.users')
        ->select(
            'users.*'
            )
        ->orderBy('users.id', 'asc')
        ->count();

        $output =['cantidad_usuarios'=>$count_users];
        return response()->json($output);

    }


    function get_encuestas_satisfacion_comenzadas_mensual(){
        $fecha_actual=date('Y-m-d');
        $output=[];

        $users = DB::table('public.users')
        ->select(
            'users.*'
            )
        ->orderBy('users.id', 'asc')
        ->get();

        $respuesta_satisfaccion = DB::table('public.respuesta') // satisfaccion
        ->select(
            'respuesta.*',
            'tipo_encuesta.id as id_tipo_encuesta'
            )
        ->leftJoin('public.pregunta', 'pregunta.id', '=', 'respuesta.id_pregunta')
        ->leftJoin('public.tipo_encuesta', 'tipo_encuesta.id', '=', 'pregunta.id_tipo_encuesta')
        ->leftJoin('public.periodo', 'periodo.id', '=', 'respuesta.id_periodo')
        ->where('periodo.fecha_inicio', '<=', $fecha_actual)
        ->where('periodo.fecha_fin', '>=', $fecha_actual)
        ->where('pregunta.id_tipo_encuesta', '=', 1)
        ->orderBy('respuesta.id', 'asc')
        ->get();
        
        $participacion_menusal_satisfaccion=[
            1=>0,
            2=>0,
            3=>0,
            4=>0,
            5=>0,
            6=>0,
            7=>0,
            8=>0,
            9=>0,
            10=>0,
            11=>0,
            12=>0
        ];

        if(count($respuesta_satisfaccion)>0){
            foreach($users as $user){
                $tempMes=[];
                foreach($respuesta_satisfaccion as $respuesta){
                    if($user->id == $respuesta->id_usuario){
                        $tempSum=+1;
                        $tempMes[]=intval(date("m",strtotime($respuesta->created_at)));
                    }
                }
                    $arrMes = array_unique($tempMes);
                    foreach($participacion_menusal_satisfaccion as $key => $mes){
                        foreach($arrMes as $k => $arr){
                            if($key == $arr){
                                $participacion_menusal_satisfaccion[$key]++; 
                            }
                        }
                    }
            }
        }
        return response()->json(array_values($participacion_menusal_satisfaccion));

    }

    function get_encuestas_liderazgo_comenzadas_mensual(){
        $fecha_actual=date('Y-m-d');
        $output=[];

        $users = DB::table('public.users')
        ->select(
            'users.*'
            )
        ->orderBy('users.id', 'asc')
        ->get();

        $respuesta_liderazgo = DB::table('public.respuesta') // satisfaccion
        ->select(
            'respuesta.*',
            'tipo_encuesta.id as id_tipo_encuesta'
            )
        ->leftJoin('public.pregunta', 'pregunta.id', '=', 'respuesta.id_pregunta')
        ->leftJoin('public.tipo_encuesta', 'tipo_encuesta.id', '=', 'pregunta.id_tipo_encuesta')
        ->leftJoin('public.periodo', 'periodo.id', '=', 'respuesta.id_periodo')
        ->where('periodo.fecha_inicio', '<=', $fecha_actual)
        ->where('periodo.fecha_fin', '>=', $fecha_actual)
        ->where('pregunta.id_tipo_encuesta', '=', 2)
        ->orderBy('respuesta.id', 'asc')
        ->get();
        
        $participacion_menusal_liderazgo=[
            1=>0,
            2=>0,
            3=>0,
            4=>0,
            5=>0,
            6=>0,
            7=>0,
            8=>0,
            9=>0,
            10=>0,
            11=>0,
            12=>0
        ];

        if(count($respuesta_liderazgo)>0){
            foreach($users as $user){
                $tempMes=[];
                foreach($respuesta_liderazgo as $respuesta){
                    if($user->id == $respuesta->id_usuario){
                        $tempSum=+1;
                        $tempMes[]=intval(date("m",strtotime($respuesta->created_at)));
                    }
                }
                    $arrMes = array_unique($tempMes);
                    foreach($participacion_menusal_liderazgo as $key => $mes){
                        foreach($arrMes as $k => $arr){
                            if($key == $arr){
                                $participacion_menusal_liderazgo[$key]++; 
                            }
                        }
                    }
            }
        }
        return response()->json(array_values($participacion_menusal_liderazgo));
    }


    
    function get_avance_encuestas_liderazgo(){
        $output=[];
        $total_preguntas =0;
        $respuesta_list=[];

        $users = DB::table('public.users')
        ->select(
            'users.*'
            )
        ->orderBy('users.id', 'asc')
        ->get();

        $users_list=[];
        foreach($users as $data){
            $users_list[]=[
                'id_usuario'=>$data->id,
                'nombre'=>$data->name,
                'preguntas_respondidas'=> 0,
                'porcentaje_avance'=> 0,
            ];
        }


        $preguntas = DB::table('public.pregunta')
        ->select('pregunta.*')
        ->where([
            ['pregunta.id_tipo_encuesta','=',  2]
            ])
        ->orderBy('pregunta.id', 'asc')
        ->get();

        $preguntas_id_list=[];
        if(count($preguntas)>0){
            foreach($preguntas as $data){
                $preguntas_id_list[]=$data->id;
            }
        }

        $total_preguntas = count($preguntas_id_list);

        $fecha_actual=date('Y-m-d');
        $periodo = DB::table('public.periodo')
        ->select('periodo.*')
        ->where('periodo.fecha_inicio', '<=', $fecha_actual)
        ->where('periodo.fecha_fin', '>=', $fecha_actual)
        ->get();


        $respuesta = DB::table('public.respuesta')
        ->select('respuesta.*')
        ->where([
            ['respuesta.id_periodo','=',  $periodo->first()->id]
            ])
        ->whereIn('respuesta.id_pregunta',$preguntas_id_list)
        ->orderBy('respuesta.id', 'asc')
        ->get();
        
        foreach($respuesta as $res){
            $respuesta_list[]=[
                'id'=> $res->id,
                'id_pregunta'=> $res->id_pregunta,
                'id_usuario'=> $res->id_usuario
            ];
        }


        foreach($users_list as $k => $user){
            foreach($respuesta_list as $res){
                if($user['id_usuario'] == $res['id_usuario']){
                    $users_list[$k]['preguntas_respondidas']++;
                }
            }
        }


        foreach($users_list as $k => $user){
            if($user['preguntas_respondidas'] >0){
                $users_list[$k]['porcentaje_avance']= doubleval(number_format(intval($user['preguntas_respondidas']) *100 / intval($total_preguntas),2));
            }
        }



        return response()->json($users_list);
    }

    function get_avance_encuestas_satisfaccion(){
        $output=[];
        $total_preguntas =0;
        $respuesta_list=[];

        $users = DB::table('public.users')
        ->select(
            'users.*'
            )
        ->orderBy('users.id', 'asc')
        ->get();

        $users_list=[];
        foreach($users as $data){
            $users_list[]=[
                'id_usuario'=>$data->id,
                'nombre'=>$data->name,
                'preguntas_respondidas'=> 0,
                'porcentaje_avance'=> 0,
            ];
        }


        $preguntas = DB::table('public.pregunta')
        ->select('pregunta.*')
        ->where([
            ['pregunta.id_tipo_encuesta','=',  1]
            ])
        ->orderBy('pregunta.id', 'asc')
        ->get();

        $preguntas_id_list=[];
        if(count($preguntas)>0){
            foreach($preguntas as $data){
                $preguntas_id_list[]=$data->id;
            }
        }

        $total_preguntas = count($preguntas_id_list);

        $fecha_actual=date('Y-m-d');
        $periodo = DB::table('public.periodo')
        ->select('periodo.*')
        ->where('periodo.fecha_inicio', '<=', $fecha_actual)
        ->where('periodo.fecha_fin', '>=', $fecha_actual)
        ->get();


        $respuesta = DB::table('public.respuesta')
        ->select('respuesta.*')
        ->where([
            ['respuesta.id_periodo','=',  $periodo->first()->id]
            ])
        ->whereIn('respuesta.id_pregunta',$preguntas_id_list)
        ->orderBy('respuesta.id', 'asc')
        ->get();
        
        foreach($respuesta as $res){
            $respuesta_list[]=[
                'id'=> $res->id,
                'id_pregunta'=> $res->id_pregunta,
                'id_usuario'=> $res->id_usuario
            ];
        }


        foreach($users_list as $k => $user){
            foreach($respuesta_list as $res){
                if($user['id_usuario'] == $res['id_usuario']){
                    $users_list[$k]['preguntas_respondidas']++;
                }
            }
        }


        foreach($users_list as $k => $user){
            if($user['preguntas_respondidas'] >0){
                $users_list[$k]['porcentaje_avance']= doubleval(number_format(intval($user['preguntas_respondidas']) *100 / intval($total_preguntas),2));
            }
        }



        return response()->json($users_list);
    }

}