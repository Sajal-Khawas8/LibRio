<?php

namespace App\View\Components\Shared\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FileInput extends Component
{
    public $name;
    public $accept;
    /**
     * Create a new component instance.
     */
    public function __construct(string $name, ?string $accept = '*')
    {
        $this->name=$name;
        $this->accept=$accept;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shared.form.file-input');
    }
}
