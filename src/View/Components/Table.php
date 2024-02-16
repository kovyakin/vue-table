<?php

namespace Kovyakin\VueTable\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Table extends Component
{

    public function __construct()
    {
        dd(1);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
//        return view('kovyakin::components.table');
    }
}
