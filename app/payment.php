<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use App\sale;
use App\vehicle;

class payment extends Model
{
    use Searchable;
    protected $table = 'payments';
    protected $fillable = ['sale_id','vehicle_id'];

    public function sale()
    {
        return $this->belongsTo(sale::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(vehicle::class);
    }

    public function searchableAs()
    {
        return 'payments_index';
    }

    public function toSearchableArray()
    {
        $array = $this->toArray();
     
        return $array;
    }
}
