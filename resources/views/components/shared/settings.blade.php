<article class="mx-auto bg-slate-200 rounded-md px-4 py-6 w-4/5 max-w-md space-y-4 relative">
    @empty($user->image)
    <div class="w-60 h-60 rounded-md mx-auto bg-gray-600 flex items-center justify-center">
        <x-icons.user class="w-56 h-56 text-white" />
    </div>
    @else
    <div class="w-60 h-60 rounded-md mx-auto border border-gray-400">
        <img src="{{ Storage::url($user->image) }}" alt="{{ $user->name }}" class="w-full h-full object-cover rounded-md">
    </div>
    @endempty
    <div class="space-y-3">
        <h2 class="font-semibold text-2xl text-center">{{ $user->name }}</h2>
        <dl class="px-6 overflow-hidden">
            <div class="grid grid-cols-3 gap-2">
                <dt class="font-medium">Email:</dt>
                <dd class="col-span-2"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></dd>
            </div>
            <div class="grid grid-cols-3 gap-2">
                <dt class="font-medium">Address:</dt>
                <dd class="col-span-2 line-clamp-3">{{ $user->address }}</dd>
            </div>
        </dl>
    </div>
    <div class="space-y-6">
        <div class="flex gap-10">
            <div class="flex-1">
                <x-shared.anchor-button href="{{ $update }}"> Update Info </x-shared.anchor-button>
            </div>
            <form action="/logout" method="post" class="flex-1">
                @csrf
                <x-shared.form.submit-button> Log Out </x-shared.form.submit-button>
            </form>
        </div>
        <x-shared.button type="danger" onclick="document.getElementById('deleteModal').style.display='flex'"> Delete
            Account </x-shared.button>
    </div>
    <div id="deleteModal"
        class="absolute inset-0 bg-gray-500/60 !mt-0 hidden flex-col justify-center items-center space-y-20">
        <div class="text-center">
            <p class="font-semibold text-3xl text-white">Are you sure?</p>
            <x-shared.button class="absolute top-4 right-4 !w-fit bg-transparent hover:bg-transparent"
                onclick="document.getElementById('deleteModal').style.display='none'">
                <x-icons.close class="w-7 h-7" />
            </x-shared.button>
        </div>
        <div class="flex gap-20 items-center">
            <form action="{{ $delete }}" method="post" class="flex-1 font-medium text-lg rounded-md">
                @csrf
                @method("DELETE")
                <x-shared.form.submit-button class="bg-white !text-red-600 hover:bg-red-600 hover:!text-white"> Delete
                    Account </x-shared.form.submit-button>
            </form>
            <x-shared.button class="bg-white hover:bg-white !text-black !w-fit"
                onclick="document.getElementById('deleteModal').style.display='none'"> Cancel </x-shared.button>
        </div>
    </div>
</article>