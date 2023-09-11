<?php
// app/View/Components/FormUpdate.php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

// Import the Transaction model
use App\Models\Transaction;

class FormUpdate extends Component
{
    public $id;
    public $data;
    public $action;

    /**
     * Create a new component instance.
     */
    public function __construct($id, $data, $action)
    {

        $this->id = $id;
        $this->data = $data;
        $this->action = $action;

        try {
            $modelClassName = 'App\Models\\' . ucfirst($data);
            $this->record = app($modelClassName)->findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Handle the case where the record is not found, e.g., show an error message
            abort(404); // Or return a custom response
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form-update', [
            'record' => $this->record,
        ]);
    }
}
