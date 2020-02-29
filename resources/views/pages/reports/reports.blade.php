@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{ Breadcrumbs::render('reports') }}
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="text-primary m-0 font-weight-bold">Reportes</p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8 text-nowrap">
                    </div>
                </div>
                <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">

                    <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable">
                        <button class="Rectngulo-2" type="button" data-toggle="modal" data-target="#payModal">
                            <i class="fa fa-plus"></i> Registrar pago
                        </button>
                    </div>
                </div>
                <div class="row">

                </div>
            </div>
        </div>
        <br />
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="text-primary m-0 font-weight-bold">Reportes</p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8 text-nowrap">
                        <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable">
                            <button class="btn btn-sm btn-info" type="button" data-toggle="modal" data-target="#payModal">
                                <i class="fa fa-plus"></i> Registrar pago
                            </button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                    <table class="table dataTable my-0" id="dataTable">
                        <thead>
                            <tr>
                                <th>Vehiculo</th>
                                <th>Cliente</th>
                                <th>Monto</th>
                                <th>Tipo</th>
                                <th>Faltantes</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="row">

                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script src="/js/payment.js"></script>
@endpush
