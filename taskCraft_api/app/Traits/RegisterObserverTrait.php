<?php

namespace App\Traits;

trait RegisterObserverTrait
{
    public static function boot(): void
    {
        $observedClass = self::getObserverClass();
        parent::boot();
        self::observe($observedClass);
    }
}
