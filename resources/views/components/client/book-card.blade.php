<figure class="relative">
    <div class="h-72 w-full border">
        <img src="{{ Storage::url($book->cover) }}" alt="{{ $book->title }}" class="h-full w-full object-fill">
    </div>
    <figcaption class="p-2 max-w-full space-y-4">
        <h3 class="font-semibold text-xl text-blue-700 truncate">{{ $book->title }}</h3>
        <h4 class="font-medium truncate">{{ $book->author }}</h4>
    </figcaption>
    <a href="{{ $href }}" class="absolute inset-0"></a>
</figure>