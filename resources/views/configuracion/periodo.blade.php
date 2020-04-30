@extends('layouts.app')

@section('content')
    @include('layouts.headers.main')
    
    <div class="container-fluid mt--9">
        <div class="row">
            <div class="col-xl-12 ">
            <section>
                    <div class="card card-box">
                            <div class="card-body">
                            <h5 class="card-title">Periodo</h5>
                            <div class="table-responsive" style="height:18rem;">
                                <div>
                                    <table class="table align-items-center" id="periodoTable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Fecha Inicio</th>
                                                <th scope="col">Fecha Fin</th>
                                                <th scope="col">
                                                    <button class="btn btn-icon btn-success" type="button" data-toggle="modal" data-target="#periodoModal" onclick="agregarPeriodo()">
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
        <div class="modal fade" id="periodoModal" tabindex="-1" role="dialog" aria-labelledby="periodomodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="periodomodalLabel">title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="periodoForm">
                <div class="form-group">
                    <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                            </div>
                            <input class="form-control datepicker" placeholder="Fecha Inicio" type="text"  id="fecha_inicio_periodo">
                    </div>
                    <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                            </div>
                            <input class="form-control datepicker" placeholder="Fecha Fin" type="text"  id="fecha_fin_periodo">
                    </div>  
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnGuardarPeriodo" onClick="guardarPeriodo()" >Guardar</button>
            </div>
            </div>
        </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
<script src="{{ asset('js/periodo.js') }}"></script>
<script src="{{ asset('argon') }}/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

@endpush