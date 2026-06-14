<article class="flex items-center gap-7 h-32">
    <div class="h-full w-24">
        <img src="{{ $book->cover }}" alt="{{ $book->title }}" class="h-full w-full object-fill">
    </div>
    <div class="flex-1 flex flex-col justify-between h-full">
        <div class="flex justify-between">
            <h2 class="text-2xl font-semibold">{{ $book->title }}</h2>
            <form action="{{ route("client.cart.destroy") }}" method="post">
                @csrf
                @method("DELETE")
                <input type="hidden" name="book" value="{{ $book->id }}">
                <x-shared.form.submit-button class="!p-1 bg-red-500 text-white hover:bg-red-600">
                    <x-icons.delete class="w-6 h-6" />
                </x-shared.form.submit-button>
            </form>
        </div>
        <h3 class="text-lg font-semibold">{{ $book->author }}</h3>
        <dl class="grid grid-cols-2 gap-8">
            <div class="flex gap-2">
                <dt class="font-medium">Category:</dt>
                <dd>{{ $book->category->name }}</dd>
            </div>
            <div class="flex gap-2">
                <dt class="font-medium">Availability:</dt>
                @if ($book->quantity->available)
                    <dd class="px-4 rounded-full font-medium bg-green-400 text-green-700">In stock</dd>
                @else
                    <dd class="px-4 rounded-full font-medium bg-red-400 text-red-700">Out of stock</dd>
                @endif
            </div>
        </dl>
        <dl class="grid grid-cols-2 gap-8">
            <div class="flex gap-2">
                <dt class="font-medium">Rent:</dt>
                <dd>&#x20B9;{{ $book->rent }}/day</dd>
            </div>
        </dl>
    </div>
</article>