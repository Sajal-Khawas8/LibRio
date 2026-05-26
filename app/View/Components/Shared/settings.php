<?php

namespace App\View\Components\shared;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class settings extends Component
{
    public $user, $update, $delete;
    /**
     * Create a new component instance.
     */
    public function __construct($update, $delete)
    {
        $this->user = auth()->user();
        $this->update = $update;
        $this->delete = $delete;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shared.settings');
    }
}
