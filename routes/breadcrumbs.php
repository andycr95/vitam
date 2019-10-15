<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('home'));
});

Breadcrumbs::for('clients', function ($trail) {
    $trail->parent('home');
    $trail->push('Clientes', route('clients'));
});

Breadcrumbs::for('client', function ($trail, $client) {
    $trail->parent('clients');
    $name = $client->name.' '.$client->last_name;
    $trail->push($name, route('client', $client->id));
});

Breadcrumbs::for('vehicles', function ($trail) {
    $trail->parent('home');
    $trail->push('Vehiculos', route('vehicles'));
});

Breadcrumbs::for('vehicle', function ($trail, $vehicle) {
    $trail->parent('vehicles');
    $trail->push($vehicle->placa, route('vehicle', $vehicle->id));
});

Breadcrumbs::for('branchOffices', function ($trail) {
    $trail->parent('home');
    $trail->push('Sucursales', route('branchOffices'));
});

Breadcrumbs::for('branchoffice', function ($trail, $branchoffice) {
    $trail->parent('branchOffices');
    $trail->push($branchoffice->name, route('branchoffice', $branchoffice->id));
});

Breadcrumbs::for('employees', function ($trail) {
    $trail->parent('home');
    $trail->push('Empleados', route('employees'));
});

Breadcrumbs::for('employee', function ($trail, $employee) {
    $trail->parent('employees');
    $name = $employee->user->name.' '.$employee->user->last_name;
    $trail->push($name, route('employee', $employee->id));
});

Breadcrumbs::for('payments', function ($trail) {
    $trail->parent('home');
    $trail->push('Recaudos', route('payments'));
});
