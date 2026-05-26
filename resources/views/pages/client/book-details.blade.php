@extends("layouts.master-layout")

@section("main")
<div class="flex gap-0 ">
    <x-client.book-details-panel :$book />
    <div class="flex-1 space-y-6 px-6 py-8">
        <article class="space-y-4">
            <div class="flex justify-between">
                <h2 class="font-semibold text-3xl">Summary</h2>
                @if ($isRentable)
                <form action="{{ $showAddToCart ? route("client.cart.store") : route("client.cart.destroy") }}"
                    method="post">
                    @csrf
                    <input type="hidden" name="book" value="{{ $book->id }}">
                    @if ($showAddToCart)
                    <x-shared.form.submit-button>Add to Cart</x-shared.form.submit-button>
                    @else
                    @method("DELETE")
                    <x-shared.form.submit-button class="bg-red-500 hover:bg-red-600">Remove from Cart
                    </x-shared.form.submit-button>
                    @endif
                </form>
                @endif
            </div>
            <dl class="space-y-4 mx-8">
                <div class="grid grid-cols-3 text-lg">
                    <dt class="font-medium">Availability:</dt>
                    <dd
                        class="col-span-2 px-4 rounded-full font-medium w-fit {{ $book->quantity->available ? "bg-green-400 text-green-700" : "bg-red-400 text-red-700" }}">
                        {{ $book->quantity->available ? "In Stock" : "Out of Stock" }}</dd>
                </div>
                <div class="grid grid-cols-3 text-lg">
                    <dt class="font-medium">Rent:</dt>
                    <dd class="col-span-2 px-4">&#x20B9;{{ $book->rent }}/day</dd>
                </div>
                <div class="grid grid-cols-3 text-lg">
                    <dt class="font-medium">Fine charge:</dt>
                    <dd class="col-span-2 px-4">&#x20B9;{{ $book->fine }}/day</dd>
                </div>
            </dl>
        </article>
        @if ($isRentable && $book->quantity->available)
        <article class="space-y-8">
            <h2 class="font-semibold text-3xl">Payment</h2>
            <form action="{{ route("client.payment.initiate") }}" method="post"
                class="space-y-10 max-w-lg mx-auto">
                @csrf
                <div class="flex items-center gap-4">
                    <label for="returnDate" class="min-w-fit font-medium">Choose return date of book:</label>
                    <x-shared.form.input name="books[0][returnDate]" type="date" />
                    <input type="hidden" name="books[0][id]" value="{{ $book->id }}">
                </div>
                <x-shared.form.error name="books.0.id" />
                <x-shared.form.error name="books.0.returnDate" />
                <x-shared.form.submit-button> Get this Book </x-shared.form.submit-button>
            </form>
        </article>
        @endif
    </div>
</div>
@endsection