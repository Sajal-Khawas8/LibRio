<article class="flex justify-between">
    <div class="space-y-4">
        <h2 class="text-2xl font-semibold">{{ $category->name }}</h2>
        <dl class="flex gap-2">
            <dt class="font-medium">Total Books:</dt>
            <dd>{{ $category->books->count() }}</dd>
        </dl>
    </div>
    <div class="space-y-4">
        <x-shared.anchor-button href="{{ route('admin.categories.edit', $category->name) }}">
            <x-icons.edit class="w-6 h-6" />
        </x-shared.anchor-button>
        <form action="{{ route('admin.categories.destroy', $category->name) }}" method="post">
            @csrf
            @method("DELETE")
            <input type="hidden" name="id" value="{{ $category->name }}">
            <x-shared.form.submit-button class="bg-red-500 hover:bg-red-600 text-white rounded-md">
                <x-icons.delete class="w-6 h-6" />
            </x-shared.form.submit-button>
        </form>
    </div>
</article>