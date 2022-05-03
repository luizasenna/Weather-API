<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Weather extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $fillable = ['city_id', 'main', 'description','temp', 'feels_like',
        'temp_min', 'temp_max', 'pressure', 'humidity'];
    use SoftDeletes;


    protected $dates = ['deleted_at'];

    public function city(){
        return $this->belongsTo(City::class);
    }
}
