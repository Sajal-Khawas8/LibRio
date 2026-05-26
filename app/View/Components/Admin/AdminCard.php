<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AdminCard extends Component
{
    public $admin;
    /**
     * Create a new component instance.
     */
    public function __construct($admin)
    {
        $this->admin = $admin;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.admin-card');
    }
}
