<?php

namespace App\View\Components\Shared\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SubmitButton extends Component
{
    public $disabled;
    /**
     * Create a new component instance.
     */
    public function __construct($disabled = false)
    {
        $this->disabled = $disabled;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shared.form.submit-button');
    }
}
