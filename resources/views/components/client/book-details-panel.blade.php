<section class="flex-1 space-y-3 px-6 py-4 bg-slate-100">
    <div class="h-80 w-60 mx-auto border">
        <img src="{{ Storage::url($book->cover) }}" alt="{{ $book->title }}"
            class="h-full w-full object-fill">
    </div>
    <h1 class="font-semibold text-3xl">{{ $book->title }}</h1>
    <h2 class="font-medium text-xl">{{ $book->author }}</h2>
    <dl class="flex gap-2 text-lg">
        <dt class="font-medium">Category:</dt>
        <dd>{{ $book->category->name }}</dd>
    </dl>
    <p>{{ $book->description }}</p>
</section>