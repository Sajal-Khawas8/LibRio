@extends("layouts.master-layout")

@section("main")
<h1 class="text-4xl font-semibold pt-8 pl-16">My Books</h1>
@if ($currentReads->isEmpty() && $previousReads->isEmpty())
<section class="min-h-[calc(100vh-4rem-3.5rem)] flex items-center justify-center gap-8">
    <h2 class="font-bold text-5xl text-gray-500">You have not taken any books on rent...</h2>
</section>
@else
<section class="py-8">
    <h2 class="text-2xl font-semibold py-4 pl-16">Currently Reading</h2>
    @if ($currentReads->isEmpty())
    <p class="font-semibold text-4xl text-gray-500 text-center">You are not reading any book currently...</p>
    @else
    <ul class="grid grid-cols-5 items-center gap-x-16 gap-y-12 flex-wrap px-16">
        @foreach ($currentReads as $read)
        <li class="border rounded-lg divide-y relative hover:shadow-lg">
            <x-client.book-card :book="$read->book" href="{{ route('client.myBooks.return', $read->book->uuid) }}" />
        </li>
        @endforeach
    </ul>
    @endif
</section>
<section class="py-8">
    <h2 class="text-2xl font-semibold py-4 pl-16">Previous Reads</h2>
    @if ($previousReads->isEmpty())
    <p class="font-semibold text-4xl text-gray-500 text-center">You have not completed any book yet...</p>
    @else
    <ul class="grid grid-cols-5 items-center gap-x-20 gap-y-12 flex-wrap px-16">
        @foreach ($previousReads as $read)
        <li class="border rounded-lg divide-y relative hover:shadow-lg">
            <x-client.book-card :book="$read->book" href="{{ route('client.myBooks.history', $read->book->uuid) }}" />
        </li>
        @endforeach
    </ul>
    @endif
</section>
@endif
@endsection