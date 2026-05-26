@extends("layouts.admin-panel-layout")

@section("admin")
<header class="py-2.5 px-6">
    <h1 class="my-2.5 text-2xl font-medium text-center xl:text-left">Admins</h1>
    <div class="flex items-center gap-2">
        <form action="{{ route('admin.team.index') }}" method="GET" class="text-gray-800 divide-gray-500 relative w-[500px]">
            <x-shared.form.search name="search" placeholder="Search admins" />
        </form>
        <x-shared.form.error name="search" />
        <x-shared.anchor-button href="{{ route('admin.team.create') }}" class="flex items-center gap-3 ml-auto max-w-fit py-1.5">
            <x-icons.add class="w-7 h-7" />
            <span class="text-lg">Add New Admin</span>
        </x-shared.anchor-button>
    </div>
</header>

@if ($admins->isEmpty())
<section class="flex-1 flex items-center justify-center">
    <h2 class="font-bold text-5xl text-gray-500">No Data Found...</h2>
</section>
@else
<div class="flex-1 px-6  overflow-y-auto">
    <ul class="grid grid-cols-2 gap-16">
        @foreach ($admins as $admin)
        <li class="px-5 py-3 bg-white rounded-md h-fit">
            <x-admin.admin-card :$admin />
        </li>
        @endforeach
    </ul>
    <div class="py-4">
        {{ $admins->appends(['search' => request('search')])->links() }}
    </div>
</div>
@endif
@endsection