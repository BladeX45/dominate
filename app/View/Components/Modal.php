<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Modal extends Component
{
    public $title;
    public $idModal;

    public function __construct($title, $idModal)
    {
        $this->title = $title;
        $this->idModal = $idModal;
    }

    public function render()
    {
        return view('components.modal');
    }
}

