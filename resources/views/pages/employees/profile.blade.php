@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @foreach ($employee as $employee)
    <h3 class="text-dark mb-4">Perfil</h3>
    <div class="row mb-3">
        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-body text-center shadow">
                    @if ($employee->user->photo == '')
                        <img class="rounded-circle mb-3 mt-4" src="/img/avatars/avatar1.jpeg" width="160" height="160">                   
                    @else
                        <img class="rounded-circle mb-3 mt-4" src="/img/avatars/avatar2.jpeg" width="160" height="160">                        
                    @endif
                    <div class="mb-3"><button class="btn btn-primary btn-sm" type="button" data-toggle="modal" data-target="#exampleModal">Cambiar foto</button></div>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="text-primary font-weight-bold m-0">Vehiculos vendidos</h6>
                </div>
                <div class="card-body">
                    @foreach ($employee->branchoffice->sales as $sale)
                        <h4 class="small font-weight-bold">{{$sale->vehicle->placa}}<span class="float-right">{{$sale->vehicle->payments->count()}} pagos</span></h4>
                        <div class="progress progress-sm mb-3">
                            @if (($sale->vehicle->payments->count()/$sale->vehicle->type->counter)*100 <= 20)
                                <div class="progress-bar bg-danger" aria-valuenow="{{($sale->vehicle->payments->count()/$sale->vehicle->type->counter)*100}}" aria-valuemin="0" aria-valuemax="100" style="width: {{ (($sale->vehicle->payments->count())/$sale->vehicle->type->counter)*100 }}%;">
                                    <span class="sr-only">{{ (($sale->vehicle->payments->count())/$sale->vehicle->type->counter)*100 }}</span>
                                </div>
                            @elseif(($sale->vehicle->payments->count()/$sale->vehicle->type->counter)*100 > 20 && ($sale->vehicle->payments->count()/$sale->vehicle->type->counter)*100 < 50)
                                <div class="progress-bar bg-warning" aria-valuenow="{{($sale->vehicle->payments->count()/$sale->vehicle->type->counter)*100}}" aria-valuemin="0" aria-valuemax="100" style="width: {{ (($sale->vehicle->payments->count())/$sale->vehicle->type->counter)*100 }}%;">
                                    <span class="sr-only">{{ (($sale->vehicle->payments->count())/$sale->vehicle->type->counter)*100 }}</span>
                                </div>
                            @elseif(($sale->vehicle->payments->count()/$sale->vehicle->type->counter)*100 > 50 && ($sale->vehicle->payments->count()/$sale->vehicle->type->counter)*100 < 70)
                                <div class="progress-bar bg-primary" aria-valuenow="{{($sale->vehicle->payments->count()/$sale->vehicle->type->counter)*100}}" aria-valuemin="0" aria-valuemax="100" style="width: {{ (($sale->vehicle->payments->count())/$sale->vehicle->type->counter)*100 }}%;">
                                    <span class="sr-only">{{ (($sale->vehicle->payments->count())/$sale->vehicle->type->counter)*100 }}</span>
                                </div>
                            @elseif(($sale->vehicle->payments->count()/$sale->vehicle->type->counter)*100 > 70 && ($sale->vehicle->payments->count()/$sale->vehicle->type->counter)*100 < 100)
                                <div class="progress-bar bg-info" aria-valuenow="{{($sale->vehicle->payments->count()/$sale->vehicle->type->counter)*100}}" aria-valuemin="0" aria-valuemax="100" style="width: {{ (($sale->vehicle->payments->count())/$sale->vehicle->type->counter)*100 }}%;">
                                    <span class="sr-only">{{ (($sale->vehicle->payments->count())/$sale->vehicle->type->counter)*100 }}</span>
                                </div>
                            @elseif(($sale->vehicle->payments->count()/$sale->vehicle->type->counter)*100 == 100)
                                <div class="progress-bar bg-success" aria-valuenow="{{($sale->vehicle->payments->count()/$sale->vehicle->type->counter)*100}}" aria-valuemin="0" aria-valuemax="100" style="width: {{ (($sale->vehicle->payments->count())/$sale->vehicle->type->counter)*100 }}%;">
                                    <span class="sr-only">{{ (($sale->vehicle->payments->count())/$sale->vehicle->type->counter)*100 }}</span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="row">
                <div class="col">
                    <div class="card shadow mb-3">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 font-weight-bold">Información de usuario</p>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="first_name"><strong>Nombre</strong></label>
                                            <input disabled class="form-control" type="text" value="{{$employee->user->name}}" name="first_name">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="last_name"><strong>Apellido</strong></label>
                                            <input disabled class="form-control" type="text" value="{{$employee->user->name}}" name="last_name">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="password"><strong>Contraseña</strong></label>
                                            <input class="form-control" type="password" id="pass" disabled name="password">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="email"><strong>Email Address</strong></label>
                                            <input class="form-control" disabled type="email" value="{{$employee->user->email}}" name="email">
                                        </div>
                                    </div>
                                </div>
                                <div id="modal-buttons" class="form-group">
                                    <button disabled id="employeeSave" class="btn btn-primary btn-sm" type="submit">Guardar</button>
                                    <button class="btn btn-info btn-sm" id="employeeUpdate" type="button"><span>Actualizar</span></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 font-weight-bold">Información de sucursal</p>
                        </div>
                        <div class="card-body">
                            <form>
                            <div class="form-group"><label for="address"><strong>Dirección</strong></label><input class="form-control" type="text" disabled value="{{$employee->branchoffice->address}}" name="address"></div>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group"><label for="city"><strong>Ciudad</strong></label><input class="form-control" type="text" disabled value="{{$employee->branchoffice->city->name}}" name="city"></div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group"><label for="country"><strong>Nombre de sucursal</strong></label><input class="form-control" type="text" disabled value="{{$employee->branchoffice->name}}" name="country"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <!-- MODAL NUEVO -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('updateEmployee', $employee->user->id) }}"  enctype="multipart/form-data"  method="POST">
                @csrf
                <input type="hidden" name="_method" value="PUT">                
                <div class="modal-content">
                    <div class="modal-header  primary">
                        <h5 class="modal-title" id="exampleModalLabel">Cambiar foto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"> 
                        <div class="form-group">
                            <label for="name"><strong>Foto</strong></label>
                            <input type="file" name="file">
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