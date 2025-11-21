<?php

namespace Allyouneed\AdvancedControls;

use Illuminate\Support\Facades\Facade;

class AdvancedControls extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'advancedcontrols';
    }
}
