@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="text-primary m-0 font-weight-bold">Empleados</p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 text-nowrap">
                        <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable">
                            <button class="btn btn-sm btn-info" type="button" data-toggle="modal" data-target="#exampleModal">
                                <i class="fa fa-plus"></i> Nueva empleado
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
                                <th>Telefono</th>
                                <th>Sucursal</th>
                                <th>Vehículos</th>
                                <th>Salario</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $employee)
                            <tr>
                                <td><a href="{{ route('employee', $employee->id )}}">{{$employee->user->name}}</a></td>
                                <td>{{$employee->user->address}}</td>
                                <td>{{$employee->user->phone}}</td>
                                <td>{{$employee->branchoffice->name}}</td>
                                <td>{{$employee->branchoffice->vehicles->count()}}</td>
                                <td>{{$employee->salary}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-6 align-self-center">
                        <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Mostrando {{$employees->firstItem()}} a {{$employees->lastItem()}} de {{$employees->total()}}</p>
                    </div>
                    <div class="col-md-6">
                        <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                            <ul class="pagination">
                                {{$employees->links()}}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL NUEVO -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('createEmployee') }}"  enctype="multipart/form-data"  method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header  primary">
                            <h5 class="modal-title" id="exampleModalLabel">Nueva empleado</h5>
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
                                <label for="email"><strong>Correo</strong></label>
                                <input class="form-control" type="email" name="email" placeholder="ejemplo@vitamventure.com"/>
                            </div>
                            <div class="form-group">
                                <label for="address"><strong>Direccion</strong></label>
                                <input class="form-control" type="text" name="address" placeholder="Cr 64 #2-54"/>
                            </div>
                            <div class="form-group">
                                <label for="phone"><strong>Telefono</strong></label>
                                <input class="form-control" type="number" name="phone" placeholder="312569888"/>
                            </div>
                            <div class="form-group">
                                <label for="address"><strong>Salario</strong></label>
                                <input class="form-control" type="number" name="salary" placeholder="312569888"/>
                            </div>
                            <div class="form-group">
                                <label for="address"><strong>Contraseña</strong></label>
                                <input class="form-control" type="password" name="password" placeholder="******"/>
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
    </div>
@endsection