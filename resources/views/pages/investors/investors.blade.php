@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="text-primary m-0 font-weight-bold">Inversionistas</p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 text-nowrap">
                        <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable">
                            <button class="btn btn-sm btn-info" type="button" data-toggle="modal" data-target="#exampleModal">
                                <i class="fa fa-plus"></i> Nuevo Inversionista
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
                                <th>Email</th>
                                <th>Vehículos</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($investors as $investor)
                            <tr>
                                <td><a href="{{ route('investor', $investor->id )}}">{{$investor->user->name}}</a></td>
                                <td>{{$investor->user->address}}</td>
                                <td>{{$investor->user->phone}}</td>
                                <td>{{$investor->user->email}}</td>
                                <td>{{$investor->vehicles->count()}}</td>                              
                                <td>
                                    <a class="btn btn-sm btn-danger" data-id="{{$investor->id}}" id="deleteemployee" data-toggle="modal" data-target="#deleteModal">
                                        <i style="color: white;" class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-6 align-self-center">
                        <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Mostrando 1 a 2 de 10</p>
                    </div>
                    <div class="col-md-6">
                        <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                            <ul class="pagination">
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL NUEVO -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('createinvestor') }}"  enctype="multipart/form-data"  method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header  primary">
                            <h5 class="modal-title" id="exampleModalLabel">Nuevo Inversionista</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body"> 
                            <div class="form-group">
                                <label for="name"><strong>Nombre</strong></label>
                                <input class="form-control" placeholder="Ingrese Nombre Inversionista" type="text" name="name" />
                            </div>
                            <div class="form-group">
                                <label for="name"><strong>Apellido</strong></label>
                                <input class="form-control" placeholder="Ingrese Apellido Inversionista" type="text" name="lname" />
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
                                        <label for="photo"><strong>Foto de perfil</strong></label>
                                        <div class="custom-file">
                                            <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label>
                                            <input type="file" name="photo" class="custom-file-input" id="customFileLang" lang="es">
                                        </div>
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