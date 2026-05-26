@extends("layouts.master-layout")

@section("main")
<div class="flex gap-0 ">
    <x-client.book-details-panel :$book />

    <div class="flex-1 space-y-6 px-6 py-8">
        <article class="space-y-4">
            <div class="flex justify-between">
                <h2 class="font-semibold text-3xl">Summary</h2>
            </div>
            <div class="space-y-2 divide-y px-8">
                <dl class="flex justify-between py-4">
                    <div class="flex gap-2 text-lg">
                        <dt class="font-medium">Issue Date:</dt>
                        <dd>{{ $rentData->issue_date->toFormattedDateString() }}</dd>
                    </div>
                    <div class="flex gap-2 text-lg">
                        <dt class="font-medium">Due Date:</dt>
                        <dd>{{ $rentData->due_date->toFormattedDateString() }}</dd>
                    </div>
                </dl>
                <dl class="space-y-4 py-4">
                    <div class="flex justify-between text-lg">
                        <dt class="font-medium">Rent Period</dt>
                        <dd>{{ $rentData->duration }} days</dd>
                    </div>
                    <div class="flex justify-between text-lg">
                        <dt class="font-medium">Rent (&#x20B9;{{ $book->rent }}/day)</dt>
                        <dd>&#x20B9;{{ $rentData->rent }}</dd>
                    </div>
                    <div class="flex justify-between text-lg">
                        <dt class="font-medium">Overdue Days</dt>
                        <dd>{{ $rentData->overdueDays }} days</dd>
                    </div>
                    <div class="flex justify-between text-lg">
                        <dt class="font-medium">Fine (&#x20B9;{{ $book->fine }}/day)</dt>
                        <dd>&#x20B9;{{ $rentData->fine }}</dd>
                    </div>
                </dl>
                <dl class="space-y-4 py-4">
                    <div class="flex justify-between text-lg">
                        <dt class="font-medium">Total Rent</dt>
                        <dd>&#x20B9;{{ $rentData->rent + $rentData->fine }}</dd>
                    </div>
                    <div class="flex justify-between text-lg">
                        <dt class="font-medium">Amount Paid</dt>
                        <dd>&#x20B9;{{ $rentData->rent }}</dd>
                    </div>
                </dl>
                <dl class="flex justify-between text-xl font-medium py-4">
                    <dt>Total Payable</dt>
                    <dd>&#x20B9;{{ $rentData->fine }}</dd>
                </dl>
            </div>
        </article>
        <article class="space-y-8">
            @if ($rentData->fine)
            <div class="py-8" id="rzp">
                <x-shared.form.submit-button type="button" id="pay">Return</x-shared.form.submit-button>
                <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
                <script>
                    var options = {
                    "key": "{{ config('payment.RAZORPAY_KEY') }}",
                    "amount": "{{ $rentData->fine * 100 }}",
                    "currency": "INR",
                    "name": "LibRio",
                    "description": "Fine for {{ $book->title }}",
                    "image": "{{ asset('logo.png') }}",
                    "order_id": "{{ $orderId }}",
                    "handler": (response)=>{
                        // create form
                        form=document.createElement('form');
                        form.action="{{ route('client.myBooks.fine') }}";
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
            @else
            <form action="{{ route('client.myBooks.return', $book->uuid) }}" method="post"
                class="space-y-10 max-w-lg mx-auto">
                @csrf
                <x-shared.form.submit-button>Return</x-shared.form.submit-button>
            </form>
            @endif
        </article>
    </div>
</div>
@endsection