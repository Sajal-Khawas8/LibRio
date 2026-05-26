@extends("layouts.admin-panel-layout")

@section("admin")
<article class="py-6 space-y-8">
    <h1 class="text-center text-4xl font-semibold">Update Category</h1>
    <form action="{{ route('admin.categories.update', $category->name) }}" method="post" class="space-y-8 max-w-md mx-auto">
        @csrf
        @method("PATCH")
        <x-shared.form.input name="category" placeholder="Category Name" :value="old('category', $category->name)" />
        <x-shared.form.error name="category" />
        <x-shared.form.submit-button> Update Category </x-shared.form.submit-button>
    </form>
</article>

@endsection