@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{ Breadcrumbs::render('clients') }}
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="text-primary m-0 font-weight-bold">Clientes</p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 text-nowrap">
                        <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable">
                            <button class="btn btn-sm btn-info" type="button" data-toggle="modal" data-target="#exampleModal">
                                <i class="fa fa-plus"></i> Nuevo cliente
                            </button>
                        </div>
                    </div>
                    <div class="col">
                        <form action="{{ route('clients')}}">
                            <div class="input-group form-2 pl-0">
                                <input class="form-control my-0 py-1 red-border" type="text" placeholder="Search" name="buscar" aria-label="Search">
                                <div class="input-group-append">
                                    <button class="input-group-text" style="background-color: #1cc88a; color: white;" type="submit" ><i class="fas fa-search text-grey" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                    <table class="table dataTable my-0" id="dataTable">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Documento</th>
                                <th>Dirección</th>
                                <th>Telefono</th>
                                <th>Vehículos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                            <tr>
                                <td><a href="{{ route('client', $client->id )}}">{{$client->name}} {{$client->last_name}}</a></td>
                                <td>{{$client->documento}}</td>
                                <td>{{$client->address}}</td>
                                <td>{{$client->celphone}}</td>
                                @if ($client->sales == null)
                                    <td>0</td>
                                @else
                                    <td>{{$client->sales->count()}}</td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    @if ($clients->total() > 1)
                        <div class="col-md-6 align-self-center">
                            <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Mostrando {{$clients->firstItem()}} a {{$clients->lastItem()}} de {{$clients->total()}}</p>
                        </div>
                        <div class="col-md-6">
                            <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                                <ul class="pagination">
                                    {{$clients->links()}}
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
            <form action="{{ route('createclient') }}"  enctype="multipart/form-data"  method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header  primary">
                            <h5 class="modal-title" id="exampleModalLabel">Nueva cliente</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="name"><strong>Nombre</strong></label>
                                        <input class="form-control" placeholder="Cosme" type="text" name="name"  required/>
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name"><strong>Apellido</strong></label>
                                        <input class="form-control" placeholder="Fulanito" type="text" name="last_name"  required/>
                                    </div>
                                    <div class="form-group">
                                        <label for="documento"><strong>Documento</strong></label>
                                        <input class="form-control" placeholder="1.111.258.369" type="text" name="documento"  required/>
                                    </div>
                                    <div class="form-group">
                                        <label for="email"><strong>Correo</strong></label>
                                        <input class="form-control" type="email" name="email" placeholder="ejemplo@vitamventure.com" required/>
                                    </div>
                                    <div class="form-group">
                                        <label for="address"><strong>Direccion</strong></label>
                                        <input class="form-control" type="text" name="address" placeholder="Cr 64 #2-54" required/>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="phone"><strong>Telefono fijo</strong></label>
                                        <input class="form-control" type="number" name="phone" placeholder="2422222" required/>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone"><strong>Celular</strong></label>
                                        <input class="form-control" type="number" name="celphone" placeholder="312569888" required/>
                                    </div>
                                    <div class="form-group">
                                        <label for="photo"><strong>Foto de perfil</strong></label>
                                        <div class="custom-file">
                                            <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label>
                                            <input type="file" name="photo" class="custom-file-input" id="customFileLang" lang="es">
                                        </div>
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
        <!-- MODAL Delete -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('deleteclient') }}" id="deleteform"  enctype="multipart/form-data"  method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-content">
                        <div class="modal-header  primary">
                            <h5 class="modal-title" id="deleteModalLabel">Eliminar cliente</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <h3>¿Seguro de eliminar este cliente?<h3>
                                <input class="form-control" type="hidden" name="id" id="id" required/>
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
@push('scripts')
    <script src="/js/client.js"></script>
@endpush
