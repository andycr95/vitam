<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\employee; 
use App\vehicle; 
use App\sale; 
use App\city; 

class branchoffice extends Model
{
    use Searchable;

    protected $table = 'branchoffices';
    protected $fillable = ['state','id', 'name', 'address', 'city_id'];

    public function employee()
    {
        return $this->hasMany(employee::class);
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

    public function searchableAs()
    {
        return 'branchoffices_index';
    }

    public function toSearchableArray()
    {
        $array = $this->toArray();
     
        return array('id' => $array['id'],'name' => $array['name'],'address' => $array['address']);
    }

    public function getScoutKey()
    {
        return $this->name;
    }

}
