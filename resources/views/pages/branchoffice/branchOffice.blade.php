@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="text-primary m-0 font-weight-bold">Sucursales</p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 text-nowrap">
                        <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable">
                            <button class="btn btn-sm btn-info" type="button" data-toggle="modal" data-target="#exampleModal">
                                <i class="fa fa-plus"></i> Nueva sucursal
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-md-right dataTables_filter" id="dataTable_filter"><label><input type="search" class="form-control form-control-sm" aria-controls="dataTable" placeholder="Search"></label></div>
                    </div>
                </div>
                <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                    <table class="table dataTable my-0" id="dataTable">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Dirección</th>
                                <th>Encargado</th>
                                <th>Ciudad</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($branchoffices as $branchoffice)
                            <tr>
                                <td><a href="{{ route('branchoffice', $branchoffice->id )}}">{{$branchoffice->name}}</a></td>
                                <td>{{$branchoffice->address}}</td>
                                <td>{{$branchoffice->employee->user->name}}</td>
                                <td>{{$branchoffice->city->name}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-6 align-self-center">
                        <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Mostrando {{$branchoffices->firstItem()}} a {{$branchoffices->lastItem()}} de {{$branchoffices->total()}}</p>
                    </div>
                    <div class="col-md-6">
                        <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                            <ul class="pagination">
                                {{$branchoffices->links()}}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL NUEVO -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('createBranch') }}"  enctype="multipart/form-data"  method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header  primary">
                            <h5 class="modal-title" id="exampleModalLabel">Nueva sucursal</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body"> 
                            <div class="form-group">
                                <label for="name"><strong>Nombre</strong></label>
                                <input class="form-control" placeholder="Nueva granada" type="text" name="name" />
                            </div>
                            <div class="form-group">
                                <label for="address"><strong>Direccion</strong></label>
                                <input class="form-control" type="text" name="address" placeholder="Cr 64 #2-54"/>
                            </div>
                            <input type="hidden" name="state" value="activo"/>
                            <div class="form-group">
                                <label for="city"><strong>Ciudad</strong></label>
                                <select name="city_id" class="form-control">
                                    <option>Seleccione una opción</option>
                                    @foreach ($city as $city)
                                        <option value="{{$city->id}}">{{$city->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="employee"><strong>Encargado</strong></label>
                                <select name="employee_id" class="form-control">
                                    <option>Seleccione una opción</option>
                                    @foreach ($employee as $employee)
                                        <option value="{{$employee->id}}">{{$employee->User->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection