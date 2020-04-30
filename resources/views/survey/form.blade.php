@extends('layouts.app')

@section('content')
    @include('layouts.headers.main')
    <div class="container-fluid mt--9">
        <div class="row">
        <div class="col-sm">
        <h3 class="text-light" id="title_survey">Encuesta</h3>
        </div>
        </div>
        <div class="row">
            <div class="col-xl-10 order-xl-1 center">
                <div class="card bg-light shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h4 class="col-12 mb-0" id="pregunta">?</h4>
                            <input type="hidden" id="id_pregunta">
                            <input type="hidden" id="id_periodo">

                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="http://127.0.0.1:8000/profile" autocomplete="off">
                            <input type="hidden" name="_token" value="4U50LTtbIdO6V5RNZy2Lr8ykIQsQjett3KA7r6Gy">                            
                            <input type="hidden" name="_method" value="put">
                            <h2 class="heading-small text-muted mb-4">Marque una opción</h2>
                            
                            <div class="pl-lg-4" id="contenedor_opciones">
                            @foreach ($escalas as $key => $escala)
                                <div class="custom-control custom-radio mb-3">
                                    <input type="radio" id="{{'customRadio'.$key}}" name="customRadio" class="custom-control-input" value="{{$escala->id}}">
                                    <label class="custom-control-label" for="{{'customRadio'.$key}}">{{$escala->descripcion}}</label>
                                </div>
                            @endforeach
                                <div class="text-center">
                                    <button type="button" class="btn btn-default mt-4" id="btnAnterior" onClick="anterior_pregunta();">Anterior</button>
                                    <button type="button" class="btn btn-primary mt-4" id="btnSiguiente" onClick="siguiente_pregunta();">Siguiente</button>
                                </div>
                            </div>

                        </form> 
                    </div>
                </div>
            </div>
        </div>
        
        @include('layouts.footers.auth')

</div>
@endsection


@push('js')
<script>
        var tipo_encuesta = {!! json_encode($tipo_encuesta) !!};
        var preguntas = {!! json_encode($preguntas) !!};
        var usuario = {!! json_encode($usuario) !!};

</script>

    <script src="{{ asset('js/survey.js') }}"></script>
@endpush