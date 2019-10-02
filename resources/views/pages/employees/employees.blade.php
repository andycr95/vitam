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
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $employee)
                            <tr>
                                <td><a href="{{ route('employee', $employee->id )}}">{{$employee->user->name}}</a></td>
                                <td>{{$employee->user->address}}</td>
                                <td>{{$employee->user->phone}}</td>
                                @if ($employee->branchoffice == null)
                                    <td></td>
                                    <td></td>
                                @else
                                    <td>{{$employee->branchoffice->name}}</td>
                                    <td>{{$employee->branchoffice->vehicles->count()}}</td>
                                @endif
                                <td>{{$employee->salary}}</td>
                                <td>
                                    <a class="btn btn-sm btn-danger" data-id="{{$employee->id}}" id="deleteemployee" data-toggle="modal" data-target="#deleteModal">
                                        <i style="color: white;" class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    @if ($employees->total() > 0)
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
                    @else
                        
                    @endif
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
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="name"><strong>Nombre</strong></label>
                                        <input class="form-control" placeholder="Cosme Fulanito" type="text" name="name"  required/>
                                    </div>
                                    <div class="form-group">
                                        <label for="email"><strong>Correo</strong></label>
                                        <input class="form-control" type="email" name="email" placeholder="ejemplo@vitamventure.com" required/>
                                    </div>
                                    <div class="form-group">
                                        <label for="address"><strong>Direccion</strong></label>
                                        <input class="form-control" type="text" name="address" placeholder="Cr 64 #2-54" required/>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone"><strong>Telefono</strong></label>
                                        <input class="form-control" type="number" name="phone" placeholder="312569888" required/>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="photo"><strong>Foto de perfil</strong></label>
                                        <div class="custom-file">
                                            <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label>
                                            <input type="file" name="photo" class="custom-file-input" id="customFileLang" lang="es">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="address"><strong>Salario</strong></label>
                                        <input class="form-control" type="number" name="salary" placeholder="250.000" required/>
                                    </div>
                                    <div class="form-group">
                                        <label for="address"><strong>Sucursal</strong></label>
                                        <select name="branchoffice_id" class="form-control" required>
                                            <option>Seleccione una opción</option>
                                            @foreach ($branchoffices as $branchoffice)
                                                <option value="{{$branchoffice->id}}">{{$branchoffice->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="address"><strong>Contraseña</strong></label>
                                        <input class="form-control" type="password" name="password" placeholder="******" required/>
                                    </div>
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
        <!-- MODAL DELETE -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="{{ route('deleteEmployee') }}"  enctype="multipart/form-data"  method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="modal-content">
                            <div class="modal-header  primary">
                                <h5 class="modal-title" id="deleteModalLabel">Eliminar empleado</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body"> 
                                <div class="form-group">
                                    <h3>¿Seguro de eliminar este empleado?<h3>
                                    <input class="form-control" type="hidden" name="iddelete" id="iddelete" required/>
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