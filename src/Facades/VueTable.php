<?php

namespace Kovyakin\VueTable\Facades;

use Illuminate\Support\Facades\Facade;

class VueTable extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'vue-table';
    }
}
