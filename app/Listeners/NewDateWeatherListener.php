<?php

namespace App\Listeners;

use App\Events\NewDateWeatherEvent;
use App\Http\Controllers\WeatherController;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NewDateWeatherListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewDateWeatherEvent  $event
     * @return void
     */
    public function handle(NewDateWeatherEvent $event)
    {
        $newdate = Carbon::parse($event->dt)->format('Y-m-d H:i:s');
        WeatherController::otherDateFromAPI($newdate);
        return true;
    }
}
