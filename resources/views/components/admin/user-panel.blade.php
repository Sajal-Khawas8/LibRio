<li class="bg-white rounded-md p-2">
    <x-admin.user-card :$user />
    <div id="modal-{{ $user->uuid }}" class="absolute inset-0 bg-gray-200/90 justify-center px-6 py-4 hidden">
        <article class="space-y-4 flex flex-col">
            <h2 class="font-semibold text-2xl text-center">Books taken on Rent by {{ $user->name }}</h2>
            <div class="flex-1 overflow-auto flex justify-center items-center">
                @if ($user->orders->isEmpty())
                <h3 class="text-3xl font-medium text-gray-600"><?= $user['name']; ?> has not taken any book on
                    rent.
                </h3>
                @else
                <table class="text-center border border-b-2 border-gray-800 border-separate border-spacing-0">
                    <thead class="sticky top-0 bg-indigo-500 text-white">
                        <tr>
                            <th rowspan="2" class="border-2 border-r border-gray-800 px-1">S. No.</th>
                            <th rowspan="2" class="border-x border-y-2 border-gray-800 px-1 w-60">Books</th>
                            <th rowspan="2" class="border-x border-y-2 border-gray-800 px-2 w-40">Issue Date
                            </th>
                            <th rowspan="2" class="border-x border-y-2 border-gray-800 px-2 w-40">Due Date</th>
                            <th rowspan="2" class="border-x border-y-2 border-gray-800 px-2 w-28">Rent Period
                            </th>
                            <th rowspan="2" class="border-x border-y-2 border-gray-800 px-2 w-28">Overdue Days
                            </th>
                            <th colspan="3" class="border-2 border-l border-gray-800 px-1">Rent</th>
                        </tr>
                        <tr>
                            <th class="border-x border-b-2 border-gray-800 px-1 w-28">Rent</th>
                            <th class="border-x border-b-2 border-gray-800 px-1 w-28">Fine</th>
                            <th class="border-x border-b-2 border-r-2 border-gray-800 px-1 w-28">Total Rent</th>
                        </tr>
                    </thead>
                    @foreach ($user->orders as $order)
                    <tr class="odd:bg-indigo-200 even:bg-indigo-300">
                        <td class="border border-l-2 border-gray-800 p-2">{{ $loop->iteration }}</td>
                        <td class="text-left border border-gray-800 p-2">{{ $order->book->title }}</td>
                        <td class="border border-gray-800 p-2">{{ $order->issue_date->toFormattedDateString() }}</td>
                        <td class="border border-gray-800 p-2">{{ $order->due_date->toFormattedDateString() }}</td>
                        <td class="border border-gray-800 p-2">{{ $order->duration }}</td>
                        <td class="border border-gray-800 p-2">{{ $order->overdue_days }}</td>
                        <td class="border border-gray-800 p-2">
                            &#x20B9;{{ $order->rent }}
                        </td>
                        <td class="border border-gray-800 p-2">
                            &#x20B9;{{ $order->fine }}
                        </td>
                        <td class="border border-r-2 border-gray-800 p-2">
                            &#x20B9;{{ $order->rent + $order->fine }}
                        </td>
                    </tr>
                    @endforeach
                </table>
                @endif
            </div>
        </article>
        <button type="button" class="absolute top-5 right-8"
            onclick="document.getElementById('modal-{{ $user->uuid }}').style.display='none'">
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill="currentColor"
                    d="M3.21878052,2.15447998 L9.99678993,8.92744993 L16.7026814,2.22182541 C17.1598053,1.8145752 17.6339389,2.05757141 17.8218994,2.2625885 C18.0098599,2.46760559 18.1171875,2.95117187 17.7781746,3.29731856 L11.0707899,10.0014499 L17.7781746,16.7026814 C18.0764771,16.9529419 18.0764771,17.4433594 17.8370056,17.7165527 C17.5975342,17.9897461 17.1575623,18.148407 16.7415466,17.8244324 L9.99678993,11.0754499 L3.24360657,17.8271179 C2.948349,18.0919647 2.46049253,18.038208 2.21878052,17.7746429 C1.9770685,17.5110779 1.8853302,17.0549164 2.19441469,16.7330362 L8.92278993,10.0014499 L2.22182541,3.29731856 C1.97729492,3.02648926 1.89189987,2.53264694 2.22182541,2.22182541 C2.55175094,1.91100387 3.04367065,1.95437622 3.21878052,2.15447998 Z">
                </path>
            </svg>
        </button>
    </div>
</li>