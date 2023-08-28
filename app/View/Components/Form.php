<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Form extends Component
{
    public $action;
    public $method;
    public $enctype;

    public function __construct($action, $method)
    {
        $this->action = $action;
        $this->method = $method;
        // if enctype there is no file dont use enctype

    }

    public function render()
    {
        return view('components.form');
    }
}
