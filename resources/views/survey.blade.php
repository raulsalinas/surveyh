@extends('layouts.app')

@section('content')
    @include('layouts.headers.main')
    
    <div class="container-fluid mt--9">
        <div class="row" id="contenedor_tipo_encuesta">
            <div class="col-xl-6 mb-5 mb-xl-0">
                <section>
                <a href="{{ route('survey.form','satisfaccion') }}">
                    <div class="card card-box">
                        <img class="card-img-top" src="/argon/img/survey/winter_designer.svg" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">Satisfacción Laboral</h5>
          
                            <h4 class="card-title" id="porcentaje_avance_encuesta_satisfaccion">{{$procentaje_avance_encuesta_satisfaccion['porcentaje_avance']}} %</h4>
                        </div>
                    </div>
                    </a>
                </section>

            </div>
            <div class="col-xl-6 ">
            <section>
                <a href="{{ route('survey.form','liderazgo') }}">
                    <div class="card card-box" >
                        <img class="card-img-top" src="/argon/img/survey/in_the_office.svg" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">Liderazgo</h5>
                            <h4 class="card-title" id="porcentaje_avance_encuesta_liderazgo">{{$procentaje_avance_encuesta_liderazgo['porcentaje_avance']}}%</h4>
                        </div>
                    </div>
                </a>

            </section>


            </div>
        </div>
 

        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
<script>
    if(({!! json_encode($hasPeriodo) !!}).length >0){
        console.log('ok');
    }else{
        alert('Actualmente no existe un periodo definido para iniciar la encuesta, espere que el administrador inicie un nuevo periodo');
        
        document.querySelectorAll("div[id='contenedor_tipo_encuesta'] section a")[0].removeAttribute('href')
        document.querySelectorAll("div[id='contenedor_tipo_encuesta'] section a")[1].removeAttribute('href')
    }
</script>
@endpush