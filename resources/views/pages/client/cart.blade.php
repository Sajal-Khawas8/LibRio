@extends("layouts.master-layout")

@section("main")
@if($cartItems->isEmpty())
<section class="min-h-[calc(100vh-4rem-3.5rem)] flex items-center justify-center">
    <h1 class="font-bold text-5xl text-gray-500">Your cart is empty...</h1>
</section>
@else
<div class="min-h-[calc(100vh-4rem-3.5rem)] flex gap-0">
    <section class="flex-1 space-y-8 px-6 py-4 bg-slate-100">
        <h1 class="font-semibold text-3xl">Books in Cart</h1>
        <ul class="mx-auto space-y-6">
            @foreach ($cartItems as $item)
                <li class="px-3 py-3 rounded-md {{ $item->book->quantity->available ? 'bg-white' : 'bg-slate-300/80' }}">
                    <x-client.cart-item :book="$item->book" />
                </li>
            @endforeach
        </ul>
    </section>
    <section class="flex-1 space-y-8 px-6 py-4">
        <h2 class="font-semibold text-3xl">Payment</h2>
        <form action="{{ route("client.payment.initiate") }}" method="post" class="space-y-10 max-w-lg mx-auto">
            @csrf
            @foreach ($cartItems as $item)
                @if ($item->book->quantity->available)
                    <div class="flex items-center gap-7">
                        <label for="returnDate-{{ $item->book->title }}" class="font-medium cursor-pointer w-1/2">Enter
                            Return Date of {{ $item->book->title }}:</label>
                        <div class="flex-1">
                            <input type="hidden" name="books[{{ $loop->index }}][id]" value="{{ $item->book->id }}">
                            <x-shared.form.input type="date" name="books[{{ $loop->index }}][returnDate]" />
                            <x-shared.form.error name="books.{{ $loop->index }}.id" />
                            <x-shared.form.error name="books.{{ $loop->index }}.returnDate" />
                        </div>
                    </div>
                @endif
            @endforeach
            <div>
                <x-shared.form.error name="error" />
            </div>
            <x-shared.form.submit-button>Get All Books</x-shared.form.submit-button>
        </form>
    </section>
</div>
@endempty
@endsection