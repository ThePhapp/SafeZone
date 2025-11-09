<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MapAlert extends Component
{

    /**
     * Create a new component instance.
     */
    public $alerts;
    public $zoom;
    public $userAddresses;

    public function __construct($alerts = [], $zoom=8, $userAddresses = [])
    {
        //
        $this->alerts = $alerts;
        $this->zoom = $zoom;
        $this->userAddresses = $userAddresses;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.map-alert');
    }
}
