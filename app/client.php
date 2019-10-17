<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\sale;
use App\recomended;
use App\purchase;
use App\payment;

class client extends Model
{
    protected $table = 'clients';
    protected $fillable = ['name', 'documento', 'address', 'phone', 'email', 'cellphone'];

    public function sales()
    {
        return $this->hasMany(sale::class);
    }

    public function recomendeds()
    {
        return $this->hasOne(recomended::class);
    }

    public function payments()
    {
        return $this->hasMany(payment::class);
    }

    public function purchases()
    {
        return $this->hasMany(purchase::class);
    }
}
