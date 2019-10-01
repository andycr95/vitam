<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\employee; 
use App\vehicle; 
use App\sale; 
use App\city; 

class branchoffice extends Model
{
    protected $table = 'branchoffices';
    protected $fillable = ['employee_id','state','id', 'name', 'address', 'city_id'];

    public function employee()
    {
        return $this->belongsTo(employee::class);
    }

    public function city()
    {
        return $this->belongsTo(city::class);
    }

    public function vehicles()
    {
        return $this->hasMany(vehicle::class);
    }

    public function sales()
    {
        return $this->hasMany(sale::class);
    }

}
