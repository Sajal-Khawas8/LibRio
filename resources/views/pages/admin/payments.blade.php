@extends("layouts.admin-panel-layout")

@section("admin")
<header class="py-2.5 px-6">
    <h1 class="my-2.5 text-2xl font-medium text-center xl:text-left">Payment Information</h1>
    <div class="flex items-center gap-2">
        <form action="{{ route('admin.payments') }}" method="GET" class="text-gray-800 divide-gray-500 relative w-[500px]">
            <x-shared.form.search name="search" placeholder="Search payments by payment id or user name or email" />
        </form>
        <x-shared.form.error name="search" />
    </div>
</header>

<div class="flex-1 overflow-auto pb-6 px-6">
    @if ($payments->isEmpty())
    <h2 class="text-5xl font-medium text-gray-500 flex justify-center items-center h-full">No Payment Data Available...
    </h2>
    @else
    <table class="border-separate border-spacing-0 text-center border border-b-2 border-gray-800 mx-auto">
        <thead class="sticky top-0 bg-indigo-500 text-white">
            <tr>
                <th rowspan="2" class="border-2 border-r border-gray-800 px-3 w-44">Payment ID</th>
                <th colspan="2" class="border-x border-y-2 border-gray-800 px-3">Reader</th>
                <th colspan="2" class="border-x border-y-2 border-gray-800 px-3">Book</th>
                <th rowspan="2" class="border-x border-y-2 border-gray-800 px-3">Method</th>
                <th rowspan="2" class="border-x border-y-2 border-gray-800 px-3">Amount</th>
                <th rowspan="2" class="border-x border-y-2 border-gray-800 px-3">Payment Type</th>
                <th rowspan="2" class="border-2 border-l border-gray-800 px-3">Transaction Date</th>
            </tr>
            <tr>
                <th class="border-x border-b-2 border-gray-800 px-3 w-44">Name</th>
                <th class="border-x border-b-2 border-gray-800 px-3 w-44">Email</th>
                <th class="border-x border-b-2 border-gray-800 px-3 w-44">Title</th>
                <th class="border-x border-b-2 border-gray-800 px-3 w-44">Author</th>
            </tr>
        </thead>
        <tbody class="max-h-48 overflow-auto">
            @foreach ($payments as $payment)
            <tr class="{{ $loop->odd ? 'bg-indigo-200' : 'bg-indigo-300' }}">
                <td rowspan="{{ $payment->paidItem->count() }}" class="border border-l-2 border-gray-800 p-2">
                    {{ $payment->transaction_id }}</td>
                <td rowspan="{{ $payment->paidItem->count() }}" class="border border-gray-800 p-2">
                    {{ $payment->user->name }}</td>
                <td rowspan="{{ $payment->paidItem->count() }}"
                    class="border border-gray-800 p-2 max-w-[11rem] truncate">
                    <a href="mailto:{{ $payment->user->email }}">{{ $payment->user->email }}</a>
                </td>
                <td class="border border-gray-800 p-2">{{ $payment->paidItem->first()->book->title }}
                </td>
                <td class="border border-gray-800 p-2">
                    {{ $payment->paidItem->first()->book->author }}</td>
                <td rowspan="{{ $payment->paidItem->count() }}" class="border border-gray-800 p-2 capitalize">{{ $payment->payload['method'] ?? 'NA' }}
                </td>
                <td rowspan="{{ $payment->paidItem->count() }}" class="border border-gray-800 p-2">
                    &#x20B9;{{ $payment->amount }}
                </td>
                <td rowspan="{{ $payment->paidItem->count() }}" class="border border-gray-800 p-2 capitalize">
                    {{ $payment->type }}
                </td>
                <td rowspan="{{ $payment->paidItem->count() }}" class="border border-r-2 border-gray-800 p-2">
                    {{ $payment->created_at }}</td>
            </tr>

            @if ($payment->paidItem->count()>1)
            @foreach ($payment->paidItem->skip(1) as $item)
            <tr class="{{ $loop->odd ? 'bg-indigo-200' : 'bg-indigo-300' }}">
                <td class="border border-gray-800 p-2">{{ $item->book->title }}</td>
                <td class="border border-gray-800 p-2">{{ $item->book->author }}</td>
            </tr>
            @endforeach

            @endif
            @endforeach

        </tbody>
    </table>
    <div class="py-4">
        {{ $payments->appends(['search' => request('search')])->links() }}
    </div>
    @endif
</div>
@endsection