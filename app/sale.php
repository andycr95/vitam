<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\branchoffice;
use App\vehicle;
use App\client;

class sale extends Model
{
    protected $table = 'sales';
    protected $fillable = ['client_id', 'amount', 'date', 'branchoffice_id', 'vehicle_id'];

    public function client()
    {
        return $this->belongsTo(client::class);
    }

    public function branchoffice()
    {
        return $this->belongsTo(branchoffice::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(vehicle::class);
    }
}
