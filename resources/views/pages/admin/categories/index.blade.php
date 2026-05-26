@extends("layouts.admin-panel-layout")

@section("admin")
<header class="py-2.5 px-6">
    <h1 class="my-2.5 text-2xl font-medium text-center xl:text-left">Book Categories</h1>
    <div class="flex items-center gap-2">
        <form action="{{ route('admin.categories.index') }}" method="get" class="text-gray-800 divide-gray-500 relative w-[500px]">
            <x-shared.form.search name="search" placeholder="Search categories" />
        </form>
        <x-shared.form.error name="search" />
        <x-shared.anchor-button href="{{ route('admin.categories.create') }}"
            class="flex items-center gap-3 ml-auto max-w-fit py-1.5">
            <x-icons.add class="w-7 h-7" />
            <span class="text-lg">Add New Category</span>
        </x-shared.anchor-button>
    </div>
</header>

@if ($categories->isEmpty())
<section class="flex-1 flex items-center justify-center gap-8">
    <h2 class="font-bold text-5xl text-gray-500">There Are No Categories...</h2>
</section>
@else
<ul class="px-6 grid grid-cols-3 gap-8 overflow-y-auto">
    @foreach ($categories as $category)
    <li class="px-5 py-3 bg-white rounded-md relative">
        <x-admin.category-card :$category />
    </li>
    @endforeach
</ul>
<div class="py-4">
    {{ $categories->links() }}
</div>
@endif
@endsection