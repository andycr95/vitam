@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @foreach ($vehicle as $vehicle)
    {{ Breadcrumbs::render('vehicle', $vehicle) }}
    <div class="row mb-3">
        <div class="col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="text-primary font-weight-bold m-0">{{$vehicle->placa}}<span class="float-right">{{$vehicle->payments->count()}} pagos</span></h6>
                </div>
                <div class="card-body">
                    <div class="progress progress-sm mb-3">
                        @if (($vehicle->payments->count()/$vehicle->type->counter)*100 <= 20)
                            <div class="progress-bar bg-danger" aria-valuenow="{{($vehicle->payments->count()/$vehicle->type->counter)*100}}" aria-valuemin="0" aria-valuemax="100" style="width: {{ (($vehicle->payments->count())/$vehicle->type->counter)*100 }}%;">
                                <span class="sr-only">{{ (($vehicle->payments->count())/$vehicle->type->counter)*100 }}</span>
                            </div>
                        @elseif(($vehicle->payments->count()/$vehicle->type->counter)*100 > 20 && ($vehicle->payments->count()/$vehicle->type->counter)*100 < 50)
                            <div class="progress-bar bg-warning" aria-valuenow="{{($vehicle->payments->count()/$vehicle->type->counter)*100}}" aria-valuemin="0" aria-valuemax="100" style="width: {{ (($vehicle->payments->count())/$vehicle->type->counter)*100 }}%;">
                                <span class="sr-only">{{ (($vehicle->payments->count())/$vehicle->type->counter)*100 }}</span>
                            </div>
                        @elseif(($vehicle->payments->count()/$vehicle->type->counter)*100 > 50 && ($vehicle->payments->count()/$vehicle->type->counter)*100 < 70)
                            <div class="progress-bar bg-primary" aria-valuenow="{{($vehicle->payments->count()/$vehicle->type->counter)*100}}" aria-valuemin="0" aria-valuemax="100" style="width: {{ (($vehicle->payments->count())/$vehicle->type->counter)*100 }}%;">
                                <span class="sr-only">{{ (($vehicle->payments->count())/$vehicle->type->counter)*100 }}</span>
                            </div>
                        @elseif(($vehicle->payments->count()/$vehicle->type->counter)*100 > 70 && ($vehicle->payments->count()/$vehicle->type->counter)*100 < 100)
                            <div class="progress-bar bg-info" aria-valuenow="{{($vehicle->payments->count()/$vehicle->type->counter)*100}}" aria-valuemin="0" aria-valuemax="100" style="width: {{ (($vehicle->payments->count())/$vehicle->type->counter)*100 }}%;">
                                <span class="sr-only">{{ (($vehicle->payments->count())/$vehicle->type->counter)*100 }}</span>
                            </div>
                        @elseif(($vehicle->payments->count()/$vehicle->type->counter)*100 == 100)
                            <div class="progress-bar bg-success" aria-valuenow="{{($vehicle->payments->count()/$vehicle->type->counter)*100}}" aria-valuemin="0" aria-valuemax="100" style="width: {{ (($vehicle->payments->count())/$vehicle->type->counter)*100 }}%;">
                                <span class="sr-only">{{ (($vehicle->payments->count())/$vehicle->type->counter)*100 }}</span>
                            </div>
                        @endif
                    </div>
                    <div style="max-height: 300px; overflow-y: auto;">
                        <table class="table dataTable my-0" id="dataTable">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Monto</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vehicle->payments as $pay)
                                <tr>
                                    <td><h4 style="font-size: 14px;">{{$pay->sale->client->name}}<span class="badge badge-success">Activo</span></h4></td>
                                    <td><span class="h3" style="font-size: 14px;">${{$pay->amount}}</span><br /><strong></strong></td>
                                    <td><p class="text-muted" style="font-size: 12px;">&nbsp;{{($pay->created_at)->diffForhumans()}}</p></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card shadow mb-4">
                    <div class="card-body">
                        @if ($photo != false)
                            @foreach ($photos as $photo)
                                @if ($photo->photo1 == null)
                                    
                                @else
                                    <img class="mb-3 mt-4" src="/storage/{{$photo->photo1}}"  id="photo1" alt="{{$vehicle->placa}}" width="160" height="160">  
                                @endif
                                @if ($photo->photo2 == null)
                                    <form action="{{ route('updatePhotovehicle') }}" id="form1" enctype="multipart/form-data"  method="POST">
                                        @csrf
                                        @method('PATCH')               
                                            <input type="file" class="btn btn-primary btn-block" name="photo2" id="photo1" value="Agregar foto 2" />
                                            <input type="hidden" name="id" value="{{$vehicle->id}}"/>
                                    </form><br>
                                @else
                                    <img class="mb-3 mt-4" alt="{{$vehicle->placa}}" id="photo2" src="/storage/{{$photo->photo2}}" width="160" height="160">  
                                @endif
                                @if ($photo->photo3 == null)
                                    <form action="{{ route('updatePhotovehicle') }}" id="form2" enctype="multipart/form-data"  method="POST">
                                        @csrf
                                        @method('PATCH')               
                                            <input type="file" class="btn btn-primary btn-block"  name="photo3" id="photo2" value="Agregar foto 3" />
                                            <input type="hidden" name="id" value="{{$vehicle->id}}"/>
                                    </form>
                                @else
                                    <img class="mb-3 mt-4" alt="{{$vehicle->placa}}"  id="photo3" src="/storage/{{$photo->photo3}}" width="160" height="160">  
                                @endif
                            @endforeach
                        @else
                            <h4>No tiene fotos</h4>
                            <form action="{{ route('updatePhotovehicle') }}" id="form"  enctype="multipart/form-data"  method="POST">
                                @csrf
                                @method('PATCH')               
                                    <input type="file" class="btn btn-primary btn-block" value="Agregar" name="photo1" id="photo" value="Agregar foto 1"/>
                                    <input type="hidden" name="id" value="{{$vehicle->id}}"/>
                            </form>
                        @endif
                    </div>
                </div>
        </div>
        <div class="col-lg-7">
            <div class="row">
                <div class="col">
                    <div class="card shadow mb-3">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 font-weight-bold">Información del cliente</p>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('updateClient', $vehicle->id) }}"  enctype="multipart/form-data"  method="POST">
                                @csrf
                                @method('PUT')               
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="placa"><strong>Placa</strong></label>
                                            <input disabled class="form-control" type="text" value="{{$vehicle->placa}}" name="placa" required>
                                            <input type="hidden" value="{{$vehicle->id}}" name="idclient">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="model"><strong>Modelo</strong></label>
                                            <input disabled class="form-control" id="model" type="text" value="{{$vehicle->model}}" name="model" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="color"><strong>Color</strong></label>
                                    <input disabled class="form-control" id="color" type="text" value="{{$vehicle->color}}" name="color" required>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="motor"><strong>Motor</strong></label>
                                        <input class="form-control" type="text" value="{{$vehicle->motor}}" id="motor" disabled name="motor" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="chasis"><strong>Chasis</strong></label>
                                        <input class="form-control" type="text" value="{{$vehicle->chasis}}" id="chasis" disabled name="chasis" required>
                                        </div>
                                    </div>
                                </div>
                                <div id="modal-buttons" class="form-group">
                                    <button disabled id="clientSave" class="btn btn-primary btn-sm" type="submit">Guardar</button>
                                    <button class="btn btn-info btn-sm" id="clientUpdate" type="button"><span>Actualizar</span></button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <div id="myModal" class="modalphoto">
        <!-- The Close Button -->
        <span id="close" class="close">&times;</span>
        <!-- Modal Content (The Image) -->
        <img class="modal-content" id="img01">    
        <!-- Modal Caption (Image Text) -->
        <div id="caption"></div>
    </div>
</div>
@endsection
@push('scripts')
    <script src="/js/photos.js"></script>
    <script src="/js/vehicle.js"></script>
@endpush