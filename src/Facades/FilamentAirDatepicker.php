<?php

namespace DiegoBas\FilamentAirDatepicker\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \DiegoBas\FilamentAirDatepicker\FilamentAirDatepicker
 */
class FilamentAirDatepicker extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \DiegoBas\FilamentAirDatepicker\FilamentAirDatepicker::class;
    }
}
