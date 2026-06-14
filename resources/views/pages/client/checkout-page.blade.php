@extends("layouts.master-layout")

@section("main")
<div class="grid grid-cols-1 md:grid-cols-2 gap-5 min-h-[calc(100vh-4rem-3.5rem)]">
    <div class="h-full max-h-72 md:max-h-none">
        <img src="{{ asset("banner.jpeg") }}" alt="librio banner" class="w-full h-full object-cover">
    </div>
    <article class="bg-white px-6 py-4 m-4 space-y-6 border rounded-md divide-y">
        <h2 class="text-xl font-medium text-gray-800">Order Summary</h2>
        <ul class="divide-y">
            @foreach ($books as $book)
            <li class="flex items-center gap-4 py-4">
                <div class="border border-gray-200 rounded-md w-20">
                    <img src="{{ $book->cover }}" alt="{{ $book->title }}"
                        class="h-24 w-full object-cover rounded-md">
                </div>
                <article class="flex-1 flex flex-col">
                    <h3 class="text-lg font-medium flex items-center justify-between gap-6">
                        <a href="{{ route("client.books.show", $book->uuid) }}">{{ $book->title }}</a>
                        <span>&#x20B9;{{ $book->rent_payable }}</span>
                    </h3>
                    <p class="text-gray-600">{{ $book->author }}</p>
                </article>
            </li>
            @endforeach
        </ul>
        <p class="flex items-center justify-between gap-3 text-lg font-medium pt-6">Total Payable
            <span>&#x20B9;{{ $total_amount }}</span>
        </p>
        <div class="py-8" id="rzp">
            <x-shared.form.submit-button type="button" id="pay">Checkout</x-shared.form.submit-button>
            <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
            <script>
                var options = {
                    "key": "{{ config('payment.RAZORPAY_KEY') }}",
                    "amount": "{{ $total_amount * 100 }}",
                    "currency": "INR",
                    "name": "LibRio",
                    "description": "Rent for {{ $book->title }}",
                    "image": "{{ asset('logo.png') }}",
                    "order_id": "{{ $orderId }}",
                    "handler": (response)=>{
                        // create form
                        form=document.createElement('form');
                        form.action="{{ route('client.payment.accept') }}";
                        form.method="POST";

                        // csrf token
                        csrf=document.createElement('input');
                        csrf.type="hidden";
                        csrf.name="_token";
                        csrf.value="{{ csrf_token() }}"
                        form.appendChild(csrf);

                        // Response
                        paymentResponse=document.createElement('input');
                        paymentResponse.type="hidden";
                        paymentResponse.name="paymentResponse";
                        paymentResponse.value=JSON.stringify(response);
                        form.appendChild(paymentResponse);
                        
                        // Append the form and submit it
                        document.getElementById('rzp').appendChild(form);
                        form.submit();
                    },
                    "prefill": { 
                        "name": "{{ auth()->user()->name }}", 
                        "email": "{{ auth()->user()->email }}",
                    },
                    "theme": {
                        "color": "#374151"
                    },
                    "modal": {
                        "backdropclose": true,
                        "ondismiss": () => {
                            location.reload();
                        }
                    },
                };
                var rzp1 = new Razorpay(options);
                document.getElementById('pay').onclick = function(e){
                    rzp1.open();
                    e.preventDefault();
                }
            </script>
        </div>
    </article>
</div>
@endsection