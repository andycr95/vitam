@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h3 class="text-dark mb-0">Reportes</h3>
            <button class="btn btn-primary btn-sm d-none d-sm-inline-block" role="button" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-download fa-sm text-white-50"></i>&nbsp;Generar reporte</button>
        </div>
        {{ Breadcrumbs::render('reports') }}
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
                                <th>Codigo</th>
                                <th>Fecha</th>
                                <th>Monto</th>
                                <th>Tipo</th>
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
        <!-- MODAL PHOTO -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('updatePhoto') }}"  enctype="multipart/form-data"  method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-content">
                    <div class="modal-header  primary">
                        <h5 class="modal-title" id="exampleModalLabel">Generar reporte</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="form-group">
                                <label>Tipo de reporte</label>
                                <select class="form-control" name="type_report" id="type_report">
                                    <option value="#">Seleccione una opcion</option>
                                    <option value="1">Semanal</option>
                                    <option value="2">Mensual</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
@push('scripts')
    <script src="/js/payment.js"></script>
@endpush
