<article class="flex items-center gap-10 h-32">
    <div class="h-full w-24">
        <img src="{{ Storage::url($book->cover) }}" alt="{{ $book->title }}" class="h-full w-full object-fill">
    </div>
    <div class="flex flex-col justify-between h-full">
        <h2 class="text-2xl font-semibold">{{ $book->title }}</h2>
        <h3 class="text-lg font-semibold">{{ $book->author }}</h3>
        <dl class="grid grid-cols-3 gap-8">
            <div class="flex gap-2">
                <dt class="font-medium">Category:</dt>
                <dd>{{ $book->category->name }}</dd>
            </div>
            <div class="flex gap-2">
                <dt class="font-medium">Total Quantity:</dt>
                <dd>{{ $book->quantity->copies }}</dd>
            </div>
            <div class="flex gap-2">
                <dt class="font-medium">Available:</dt>
                <dd>{{ $book->quantity->available }}</dd>
            </div>
        </dl>
        <dl class="grid grid-cols-3 gap-8">
            <div class="flex gap-2 font-medium">
                <dt>Rent:</dt>
                <dd>&#x20B9;{{ $book->rent }}/day</dd>
            </div>
            <div class="flex gap-2 font-medium">
                <dt>Fine:</dt>
                <dd>&#x20B9;{{ $book->fine }}/day</dd>
            </div>
        </dl>
    </div>
    <div class="flex flex-col justify-evenly h-full ml-auto">
        {{ $slot }}
    </div>
</article>