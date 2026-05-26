@extends("layouts.admin-panel-layout")

@section("admin")

<article class="py-6 space-y-8 overflow-y-auto">
    <h1 class="text-center text-4xl font-semibold"> Update Book Data </h1>
    <form action="{{ route('admin.books.update', $book->uuid) }}" method="post" enctype="multipart/form-data"
        class="space-y-8 max-w-md mx-auto">
        @csrf
        @method("PUT")
        <div>
            <x-shared.form.input name="title" placeholder="Title" value="{{ old('title') ?? $book->title }}" />
            <x-shared.form.error name="title" />
        </div>
        <div class="grid grid-cols-2 gap-6">
            <div>
                <x-shared.form.input name="author" placeholder="Author" value="{{ old('author') ?? $book->author }}" />
                <x-shared.form.error name="author" />
            </div>
            <div>
                <select name="category" id="category"
                    class="w-full px-4 py-2 border border-gray-600 rounded outline-indigo-600 placeholder:text-gray-500">
                    <option class="text-gray-500">Select Category</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category') ? old('category')==$category->id :
                        $book->category_id == $category->id) >{{ $category->name }}</option>
                    @endforeach
                </select>
                <x-shared.form.error name="category" />
            </div>
        </div>
        <div class="grid grid-cols-3 gap-6">
            <div>
                <x-shared.form.input name="copies" placeholder="Copies"
                    value="{{ old('copies') ?? $book->quantity->copies }}" />
                <x-shared.form.error name="copies" />
            </div>
            <div>
                <x-shared.form.input name="rent" placeholder="Rent" value="{{ old('rent') ?? $book->rent }}" />
                <x-shared.form.error name="rent" />
            </div>
            <div>
                <x-shared.form.input name="fine" placeholder="Fine" value="{{ old('fine') ?? $book->fine }}" />
                <x-shared.form.error name="fine" />
            </div>
        </div>
        <div>
            <div class="flex items-center gap-2">
                <label for="profilePicture">Choose Cover Picture: </label>
                <x-shared.form.file-input name="cover" accept=".jpg,.jpeg,.png" />
                <x-shared.button class="!w-fit px-0 bg-transparent hover:bg-transparent"
                    title="View Uploaded Cover Picture"
                    onclick="document.getElementById('coverModal').classList.add('!flex')">
                    <x-icons.eye class="w-7 h-7 text-violet-700" />
                </x-shared.button>
                <section id="coverModal" class="hidden absolute inset-0 bg-gray-300/70 items-center justify-center">
                    <div class="relative w-96 bg-white py-4 space-y-2">
                        <h3 class="text-xl font-semibold text-center">Uploaded Cover Picture</h3>
                        <x-shared.button class="absolute top-0.5 right-2 !w-fit bg-transparent hover:bg-transparent"
                            onclick="document.getElementById('coverModal').classList.remove('!flex')">
                            <x-icons.close-circle class="w-6 h-6 text-black" />
                        </x-shared.button>
                        <div class="py-4">
                            <img src="{{ Storage::url($book->cover) }}" alt="{{ $book->title }}"
                                class="w-48 h-56 mx-auto">
                        </div>
                    </div>
                </section>
            </div>
            <x-shared.form.error name="cover" />
        </div>
        <div>
            <x-shared.form.text-area name="description" placeholder="Book Description">
                {{ old('description') ?? $book->description }}</x-shared.form.text-area>
            <x-shared.form.error name="description" />
        </div>
        <x-shared.form.submit-button> Update Book Data </x-shared.form.submit-button>
    </form>
</article>

@endsection