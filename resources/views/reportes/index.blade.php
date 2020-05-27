@extends('layouts.app')

@section('content')
    @include('layouts.headers.main')
    <div class="container-fluid mt--9">
        <div class="row">
        <div class="col-sm">
        <h3 class="text-light" id="title_survey">Reporte</h3>
        </div>
        </div>
        <div class="row">
            <div class="col-xl-12 center">
                <div class="card bg-light shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h4 class="col-12 mb-0" >Resultados de Periodo Actual</h4>
                        </div>
                    </div>
                    <div class="card-body">
                                <div class="table-responsive">
                                        <!-- Projects table -->
                                        <table class="table align-items-center" id="resultadosPeriodoActualTable" style="margin-left: -100px; position:relative;">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>id</th>
                                                    <th>Pregunta</th>
                                                    <th>Respuesta</th>
                                                    <th>Usuario</th>
                                                    <th>Fecha Inicio</th>
                                                    <th>Fecha Fin</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                    </div>
                </div>
            </div>
        </div>
        
        @include('layouts.footers.auth')

</div>
@endsection


@push('js')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<script src="{{ asset('js/reportes.js') }}"></script>
@endpush