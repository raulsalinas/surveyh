@extends('layouts.app')

@section('content')
    @include('layouts.headers.main')
    
    <div class="container-fluid mt--9">
        <div class="row">
            <div class="col-xl-12 ">
            <section>
                    <div class="card card-box">
                            <div class="card-body">
                            <h5 class="card-title">Preguntas</h5>
                            <div class="table-responsive" style="height:18rem;">
                                <div>
                                    <table class="table align-items-center" id="preguntaTable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Pregunta</th>
                                                <th scope="col">Tipo Pregunta</th>
                                                <th scope="col">
                                                    <button class="btn btn-icon btn-success" type="button" data-toggle="modal" data-target="#preguntaModal" onclick="agregarPregunta()">
                                                        <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                                                        <span class="btn-inner--text">Agregar</span>
                                                    </button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="list">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
            </section>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="preguntaModal" tabindex="-1" role="dialog" aria-labelledby="preguntamodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="preguntamodalLabel">title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="preguntaForm">
                    <div class="form-group">
                        <label for="preguntaFormControlInput">Pregunta</label>
                        <input type="text" class="form-control" id="preguntaFormControlInput" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="tipoPreguntaFormControlSelect">Tipo Encuesta</label>
                        <select class="form-control" id="tipoPreguntaFormControlSelect">
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnGuardarPregunta" onClick="guardarPregunta()" >Guardar</button>
            </div>
            </div>
        </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
<script src="{{ asset('js/pregunta.js') }}"></script>

@endpush