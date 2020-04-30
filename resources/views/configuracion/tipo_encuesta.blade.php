@extends('layouts.app')

@section('content')
    @include('layouts.headers.main')
    
    <div class="container-fluid mt--9">
        <div class="row">
            <div class="col-xl-12 ">
            <section>
                    <div class="card card-box">
                            <div class="card-body">
                            <h5 class="card-title">Tipo Encuesta</h5>
                            <div class="table-responsive" style="height:18rem;">
                                <div>
                                    <table class="table align-items-center" id="tipoEncuestaTable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Descripción</th>
                                                <th scope="col">Acción</th>
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
        <div class="modal fade" id="tipoEncuestaModal" tabindex="-1" role="dialog" aria-labelledby="tipoEncuestamodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tipoEncuestamodalLabel">title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="tipoEncuestaForm">
                    <div class="form-group">
                        <label for="tipoEncuestaFormControlInput">tipoEncuesta</label>
                        <input type="text" class="form-control" id="tipoEncuestaFormControlInput" placeholder="">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnGuardarTipoEncuesta" onClick="guardarTipoEncuesta()" >Guardar</button>
            </div>
            </div>
        </div>
        </div>

        @include('layouts.footers.auth')
    </div>


        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
<script src="{{ asset('js/tipo_encuesta.js') }}"></script>

@endpush