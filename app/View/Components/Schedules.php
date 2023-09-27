<?php

namespace App\View\Components;

use Closure;
use App\Models\Schedule;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Schedules extends Component
{
    public $schedules;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        // get all data from schedules
        $this->schedules = Schedule::all();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.schedules');
    }
}
