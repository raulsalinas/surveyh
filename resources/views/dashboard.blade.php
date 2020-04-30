@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')
    
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 mb-5 mb-xl-0">
                <div class="card bg-gradient-default shadow">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="text-uppercase text-light ls-1 mb-1">Vista General</h6>
                                <h2 class="text-white mb-0">Participación por Periodo</h2>
                            </div>
                            <div class="col">
                                <ul class="nav nav-pills justify-content-end">
                                    <li class="nav-item mr-2 mr-md-0" data-toggle="chart" data-target="#chart-sales"  data-prefix="" data-suffix="" id="chartLiderazgo">
                                        <a href="#" class="nav-link py-2 px-3" data-toggle="tab" id="btnChartLiderazgo">
                                            <span class="d-none d-md-block">Liderazgo</span>
                                            <span class="d-md-none">L</span>
                                        </a>
                                    </li>
                                    <li class="nav-item" data-toggle="chart" data-target="#chart-sales"   data-prefix="" data-suffix="" id="chartSatisfaccion">
                                        <a href="#" class="nav-link py-2 px-3" data-toggle="tab" id="btnChartSatisfaccion">
                                            <span class="d-none d-md-block">Satisfacción Laboral</span>
                                            <span class="d-md-none">SL</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Chart -->
                        <div class="chart">
                            <!-- Chart wrapper -->
                            <canvas id="chart-sales" class="chart-canvas"></canvas>
                        </div>
                    </div>
                </div>
            </div>
 
        </div>
        <div class="row mt-5">
            <div class="col-xl-6 mb-5 mb-xl-0">
                <div class="card shadow">
                        <div class="card-header border-0">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="mb-0">Avance Encuesta Liderazgo</h3>
                                </div>

                            </div>
                        </div>
                        <div class="table-responsive">
                            <!-- Projects table -->
                            <table class="table align-items-center table-flush " id="avanceLiderazgoTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Usuario</th>
                                        <th scope="col">Completadas</th>
                                        <th scope="col">Avance</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <div class="col-xl-6">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Avance Encuesta Satisfacción</h3>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-flush " id="avanceSatisfaccionTable">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Usuario</th>
                                    <th scope="col">Completadas</th>
                                    <th scope="col">Avance</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>

@endpush