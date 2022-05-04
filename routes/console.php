<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('current', function () {
    $this->comment(\App\Jobs\StoreCurrentDataJob::dispatch());
})->purpose('Populate our API with external data 4 times a day');

Artisan::command('populate', function () {
    $this->comment(\App\Jobs\StoreOtherDataJob::dispatch());
})->purpose('Populate our API with another data inputted');
