<?php

namespace App\View\Components\Client;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class BookList extends Component
{
    public $books;
    /**
     * Create a new component instance.
     */
    public function __construct(Collection $books)
    {
        $this->books= $books;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.client.book-list');
    }
}
