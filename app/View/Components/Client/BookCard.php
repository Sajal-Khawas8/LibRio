<?php

namespace App\View\Components\Client;

use App\Models\Book;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BookCard extends Component
{
    public $book, $href;
    /**
     * Create a new component instance.
     */
    public function __construct(Book $book, string $href)
    {
        $this->book = $book;
        $this->href = $href;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.client.book-card');
    }
}
