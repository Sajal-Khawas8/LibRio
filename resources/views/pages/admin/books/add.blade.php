@extends("layouts.admin-panel-layout")

@section("admin")

<article class="py-6 space-y-8 overflow-y-auto">
    <h1 class="text-center text-4xl font-semibold"> Add New Book </h1>
    <form action="{{ route('admin.books.store') }}" method="post" enctype="multipart/form-data" class="space-y-8 max-w-md mx-auto">
        @csrf
        <div>
            <x-shared.form.input name="title" placeholder="Title" />
            <x-shared.form.error name="title" />
        </div>
        <div class="grid grid-cols-2 gap-6">
            <div>
                <x-shared.form.input name="author" placeholder="Author" />
                <x-shared.form.error name="author" />
            </div>
            <div>
                <select name="category" id="category"
                    class="w-full px-4 py-2 border border-gray-600 rounded outline-indigo-600 placeholder:text-gray-500">
                    <option class="text-gray-500">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category') == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
                <x-shared.form.error name="category" />
            </div>
        </div>
        <div class="grid grid-cols-3 gap-6">
            <div>
                <x-shared.form.input name="copies" placeholder="Copies" />
                <x-shared.form.error name="copies" />
            </div>
            <div>
                <x-shared.form.input name="rent" placeholder="Rent" />
                <x-shared.form.error name="rent" />
            </div>
            <div>
                <x-shared.form.input name="fine" placeholder="Fine" />
                <x-shared.form.error name="fine" />
            </div>
        </div>
        <div>
            <div class="flex items-center gap-3">
                <label for="profilePicture">Choose Cover Picture: </label>
                <x-shared.form.file-input name="cover" accept=".jpg,.jpeg,.png" />
            </div>
            <x-shared.form.error name="cover" />
        </div>
        <div>
            <x-shared.form.text-area name="description" placeholder="Book Description" />
            <x-shared.form.error name="description" />
        </div>
        <x-shared.form.submit-button> Add Book </x-shared.form.submit-button>
    </form>
</article>

@endsection