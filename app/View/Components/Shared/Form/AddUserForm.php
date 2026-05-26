<?php

namespace App\View\Components\Shared\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AddUserForm extends Component
{
    public $title, $action;
    /**
     * Create a new component instance.
     */
    public function __construct(string $title, string $action)
    {
        $this->title = $title;
        $this->action = $action;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shared.form.add-user-form');
    }
}
