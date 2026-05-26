@extends("layouts.admin-panel-layout")

@section("admin")

<header class="py-2.5 px-6">
    <h1 class="my-2.5 text-2xl font-medium text-center xl:text-left">Rented Books</h1>
    <div class="flex items-center gap-2">
        <form action="{{ route("admin.books.rented") }}" method="GET"
            class="text-gray-800 divide-gray-500 relative w-[600px]">
            <div class="absolute left-0 inset-y-0 px-2 divide-x divide-gray-500 rounded-l-md">
                <select name="category" id="category" class="px-2 py-2 outline-none border-r border-gray-500 text-lg"
                    aria-label="Select category">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->name }}" @selected($category->name ===
                        request('category'))>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <x-shared.form.search class="pl-44" name="search" placeholder="Search Books by Title or Author" />
        </form>
        <x-shared.form.error name="search" />
    </div>
</header>

@if (!count($books))
<section class="flex-1 flex items-center justify-center">
    <h1 class="font-bold text-5xl text-gray-500">There Are No Books In LibRio...</h1>
</section>

@else
<div class="flex-1 overflow-y-auto">
    <ul class="px-6 space-y-4">
        @foreach ($books as $book)
        <li class="px-5 py-3 bg-white rounded-md">
            <x-admin.book-panel :book="$book">
                <x-shared.button onclick="document.getElementById('modal-{{ $book->uuid }}').style.display='flex'"> View
                    Readers </x-shared.button>
                <div id="modal-{{ $book->uuid }}"
                    class="absolute inset-0 z-50 bg-gray-200/90 justify-center px-6 py-4 items-center hidden">
                    <article class="space-y-4 flex flex-col">
                        <h2 class="font-semibold text-2xl text-center">Readers of {{ $book->title }}</h2>
                        <div class="flex-1 flex items-center justify-center overflow-auto">
                            <table
                                class="text-center border border-b-2 border-gray-800 border-separate border-spacing-0">
                                <thead class="sticky top-0 bg-indigo-500 text-white">
                                    <tr>
                                        <th rowspan="2" class="border-2 border-r border-gray-800 px-1">S. No.</th>
                                        <th rowspan="2" class="border-x border-y-2 border-gray-800 px-1 w-40">Name</th>
                                        <th rowspan="2" class="border-x border-y-2 border-gray-800 px-1 w-40">Email</th>
                                        <th rowspan="2" class="border-x border-y-2 border-gray-800 px-1 w-52">Address
                                        </th>
                                        <th rowspan="2" class="border-x border-y-2 border-gray-800 px-2">Issue Date</th>
                                        <th rowspan="2" class="border-x border-y-2 border-gray-800 px-2">Due Date</th>
                                        <th colspan="4" class="border-2 border-l border-gray-800 px-1">Rent</th>
                                    </tr>
                                    <tr>
                                        <th class="border-x border-b-2 border-gray-800 px-1 w-28">Rent</th>
                                        <th class="border-x border-b-2 border-gray-800 px-1 w-28">Fine</th>
                                        <th class="border-x border-b-2 border-r-2 border-gray-800 px-1 w-28">Total Rent
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($book->orders as $orders)
                                    <tr class="odd:bg-indigo-200 even:bg-indigo-300">
                                        <td class="border border-l-2 border-gray-800 p-2">{{ $loop->iteration }}</td>
                                        <td class="border border-gray-800 p-2">{{ $orders->user->name }}</td>
                                        <td class="border border-gray-800 p-2 max-w-[10rem] truncate">
                                            <a href="mailto: {{ $orders->user->email }}">{{ $orders->user->email }}</a>
                                        </td>
                                        <td class="border border-gray-800 p-2">
                                            <address class="not-italic">{{ $orders->user->address }}</address>
                                        </td>
                                        <td class="border border-gray-800 p-2">{{ $orders->issue_date->toFormattedDateString() }}</td>
                                        <td class="border border-gray-800 p-2">{{ $orders->due_date->toFormattedDateString() }}</td>
                                        <td class="border border-gray-800 p-2">
                                            &#x20B9;{{ $orders->rent }}
                                        </td>
                                        <td class="border border-gray-800 p-2">
                                            &#x20B9;{{ $orders->fine }}
                                        </td>
                                        <td class="border border-r-2 border-gray-800 p-2">
                                            &#x20B9;{{ $orders->rent + $orders->fine }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </article>
                    <button type="button" class="absolute top-5 right-8"
                        onclick="document.getElementById('modal-{{ $book->uuid }}').style.display='none'">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill="currentColor"
                                d="M3.21878052,2.15447998 L9.99678993,8.92744993 L16.7026814,2.22182541 C17.1598053,1.8145752 17.6339389,2.05757141 17.8218994,2.2625885 C18.0098599,2.46760559 18.1171875,2.95117187 17.7781746,3.29731856 L11.0707899,10.0014499 L17.7781746,16.7026814 C18.0764771,16.9529419 18.0764771,17.4433594 17.8370056,17.7165527 C17.5975342,17.9897461 17.1575623,18.148407 16.7415466,17.8244324 L9.99678993,11.0754499 L3.24360657,17.8271179 C2.948349,18.0919647 2.46049253,18.038208 2.21878052,17.7746429 C1.9770685,17.5110779 1.8853302,17.0549164 2.19441469,16.7330362 L8.92278993,10.0014499 L2.22182541,3.29731856 C1.97729492,3.02648926 1.89189987,2.53264694 2.22182541,2.22182541 C2.55175094,1.91100387 3.04367065,1.95437622 3.21878052,2.15447998 Z">
                            </path>
                        </svg>
                    </button>
                </div>
            </x-admin.book-panel>
        </li>
        @endforeach
    </ul>
    <div class="py-4 px-6">{{ $books->links() }}</div>
</div>
@endif
@endsection