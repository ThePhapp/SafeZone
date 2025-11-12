<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MapView extends Component
{
    /**
     * Create a new component instance.
     */
    public $locations;
    public $zoom;

    public function __construct($locations = [], $zoom=8)
    {
        $this->locations = $locations;
        $this->zoom = $zoom;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.map-view');
    }
}
