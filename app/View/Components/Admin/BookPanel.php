<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BookPanel extends Component
{
    public $book;
    /**
     * Create a new component instance.
     */
    public function __construct($book)
    {
        $this->book = $book;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.book-panel');
    }
}
