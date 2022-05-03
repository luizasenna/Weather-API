<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class City extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['name', 'country', 'lat','long'];


    public function weather(){
        return $this->hasMany(Weather::class);
    }


}
