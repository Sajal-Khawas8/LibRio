@extends("layouts.admin-panel-layout")

@section("admin")

<header class="py-2.5 px-6">
    <h1 class="my-2.5 text-2xl font-medium text-center xl:text-left">Library Books</h1>
    <div class="flex items-center gap-2">
        <form action="{{ route("admin.books.index") }}" method="GET" class="text-gray-800 divide-gray-500 relative w-[600px]">
            <div class="absolute left-0 inset-y-0 px-2 divide-x divide-gray-500 rounded-l-md">
                <select name="category" id="category" class="px-2 py-2 outline-none border-r border-gray-500 text-lg"
                    aria-label="Select category">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->name }}" @selected($category->name === request('category'))>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <x-shared.form.search class="pl-44" name="search" placeholder="Search Books by Title or Author" />
        </form>
        <x-shared.form.error name="search" />
        <x-shared.anchor-button href="{{ route('admin.books.create') }}" class="!flex items-center gap-3 ml-auto max-w-fit py-1.5">
            <x-icons.add class="w-7 h-7" />
            <span class="text-lg">Add New Book</span>
        </x-shared.anchor-button>
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
        <li class="px-5 py-3 bg-white rounded-md relative">
            <x-admin.book-panel :book="$book">
                <x-shared.anchor-button href="{{ route('admin.books.edit', $book->uuid) }}"> Update Book Info </x-shared.anchor-button>
                <form action="{{ route('admin.books.destroy', $book->uuid) }}" method="post">
                    @csrf
                    @method("DELETE")
                    <x-shared.button type="danger"
                        onclick="document.getElementById('deleteModal-{{ $book->uuid }}').style.display='flex'">
                        Delete Book</x-shared.button>
                    <div id="deleteModal-{{ $book->uuid }}"
                        class="absolute inset-0 bg-gray-500/60 hidden flex-col justify-center items-center space-y-8">
                        <div class="flex gap-16 items-center">
                            <p class="font-semibold text-3xl">Are you sure?</p>
                            <x-shared.button class="!w-fit bg-transparent hover:bg-transparent !text-black"
                                onclick="document.getElementById('deleteModal-{{ $book->uuid }}').style.display='none'">
                                <x-icons.close class="w-7 h-7" />
                            </x-shared.button>
                        </div>
                        <div class="flex gap-16 items-center w-72">
                            <x-shared.form.submit-button
                                class="bg-white !text-red-600 hover:bg-red-600 hover:!text-white">
                                Yes
                            </x-shared.form.submit-button>
                            <x-shared.button class="bg-white hover:bg-white !text-black !w-fit"
                                onclick="document.getElementById('deleteModal-{{ $book->uuid }}').style.display='none'">
                                Cancel
                            </x-shared.button>
                        </div>
                    </div>
                </form>
            </x-admin.book-panel>
        </li>
        @endforeach
    </ul>
    <div class="py-4 px-6">{{ $books->appends(['category' => request('category'), 'search' => request('search')])->links() }}</div>
</div>
@endif
@endsection