@extends("layouts.admin-panel-layout")

@section("admin")
<article class="py-6 space-y-8">
    <h1 class="text-center text-4xl font-semibold">Add New Category</h1>
    <form action="{{ route('admin.categories.store') }}" method="post" class="space-y-8 max-w-md mx-auto">
        @csrf
        <x-shared.form.input name="category" placeholder="Category Name" />
        <x-shared.form.error name="category" />
        <x-shared.form.submit-button> Add Category </x-shared.form.submit-button>
    </form>
</article>

@endsection