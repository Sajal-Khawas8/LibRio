@extends("layouts.master-layout")

@section("main")
<div class="flex gap-0 ">
    <x-client.book-details-panel :$book />

    <div class="flex-1 space-y-6 px-6 py-8">
        <article class="space-y-4">
            <div class="flex justify-between">
                <h2 class="font-semibold text-3xl">Rent History</h2>
            </div>
            <div class="space-y-2 divide-y px-8">
                <dl class="space-y-4 py-4">
                    <div class="flex justify-between text-lg">
                        <dt class="font-medium">Issue Date</dt>
                        <dd>{{ $rentData->issue_date->toFormattedDateString() }}</dd>
                    </div>
                    <div class="flex justify-between text-lg">
                        <dt class="font-medium">Due Date</dt>
                        <dd>{{ $rentData->due_date->toFormattedDateString() }}</dd>
                    </div>
                    <div class="flex justify-between text-lg">
                        <dt class="font-medium">Return Date</dt>
                        <dd>{{ $rentData->return_date->toFormattedDateString() }}</dd>
                    </div>
                </dl>
                <dl class="space-y-4 py-4">
                    <div class="flex justify-between text-lg">
                        <dt class="font-medium">Rent Period</dt>
                        <dd>{{ $rentData->duration }} days</dd>
                    </div>
                    <div class="flex justify-between text-lg">
                        <dt class="font-medium">Overdue Days</dt>
                        <dd>{{ $rentData->overdueDays }} days</dd>
                    </div>
                </dl>
                <dl class="space-y-4 py-4">
                    <div class="flex justify-between text-lg">
                        <dt class="font-medium">Rent Paid</dt>
                        <dd>&#x20B9;{{ $rentData->rent_paid }}</dd>
                    </div>
                    <div class="flex justify-between text-lg">
                        <dt class="font-medium">Fine Paid</dt>
                        <dd>&#x20B9;{{ $rentData->fine_paid }}</dd>
                    </div>

                </dl>
                <dl class="flex justify-between text-xl font-medium py-4">
                    <dt class="font-medium">Total Rent Paid</dt>
                    <dd>&#x20B9;{{ $rentData->rent_paid + $rentData->fine_paid }}</dd>
                </dl>
            </div>
        </article>
    </div>
</div>
@endsection