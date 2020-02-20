@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @foreach ($sale as $sale)
    {{ Breadcrumbs::render('sale', $sale) }}
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col">
                    <div class="card shadow mb-12">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 font-weight-bold">Información de venta</p>
                            <label for="fee"><strong>   Estado</strong></label>
                            @if ($sale->state == 1)
                                <span class="badge badge-primary">En proceso</span>
                            @else
                                <span class="badge badge-success">Terminada</span>
                            @endif
                        </div>
                        <div class="card-body">
                            <form action=""  enctype="multipart/form-data"  method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="first_name"><strong>Cliente</strong></label>
                                            <input disabled class="form-control" type="text" value="{{$sale->client->name}} {{$sale->client->last_name}}" name="first_name">
                                            <input type="hidden" value="{{$sale->id}}" name="id">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="branchoffice_id"><strong>Sucursal</strong></label>
                                            <select name="branchoffice_id" class="form-control" disabled>
                                            <option style="color: red;" value="{{$sale->branchoffice_id}}">{{$sale->branchoffice->name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="date"><strong>Fecha de venta</strong></label>
                                            <input class="form-control" type="text" disabled value="{{$sale->date}}" name="date">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="placa"><strong>Placa del vehiculo</strong></label>
                                            <input class="form-control" type="text" disabled value="{{$sale->vehicle->placa}}" name="placa">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="fee"><strong>Coutas faltantes</strong></label>
                                            <input class="form-control" type="text" disabled value="{{$sale->amount - $sale->vehicle->payments->count()}}" name="fee">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="fee"><strong>Tipo de venta</strong></label>
                                            <input class="form-control" type="text" disabled value="{{$sale->typesale->name}}" name="fee">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="fee"><strong>Couta</strong></label>
                                            <input class="form-control precio" type="text" disabled value="{{$sale->fee}}" name="fee">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    @if ($sale->vehicle->payments->count() > 0)
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="fee"><strong>Ultimo pago</strong></label>
                                                <input class="form-control" type="text" disabled value="{{$payment->amount}}" name="fee">
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
@push('scripts')
    <script src="/js/sale.js"></script>
@endpush
