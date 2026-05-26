<article class="flex justify-between gap-20">
    <div class="flex-1 flex gap-10">
        @empty ($admin->image)
        <div class="w-40 h-40 rounded-md bg-gray-600 flex items-center justify-center">
            <x-icons.user class="w-56 h-56 text-slate-100" />
        </div>
        @else
        <div class="h-40 w-40 rounded-md">
            <img src="{{ Storage::url($admin->image) }}" alt="{{ $admin->name }}"
                class="h-full w-full object-cover rounded-md">
        </div>
        @endif
        <div class="space-y-3">
            <h2 class="font-semibold text-2xl">{{ $admin->name }}</h2>
            <p class="font-medium text-lg"><a href="mailto:{{ $admin->email }}">{{ $admin->email }}</a>
            </p>
            <dl class="max-w-[15rem]">
                <dt class="font-medium">Address:</dt>
                <dd>
                    <address class="not-italic">{{ $admin->address }}</address>
                </dd>
            </dl>
        </div>
    </div>
    <div class="space-y-4">
        <form
            action="{{ $admin->hasRole('super-admin') ? route('admin.removeSuperAdmin', $admin->uuid): route('admin.makeSuperAdmin', $admin->uuid) }}"
            method="post">
            @csrf
            @method("PATCH")
            <x-shared.form.submit-button @class(['bg-orange-500 hover:bg-orange-600'=>$admin->hasRole('super-admin'),
                '!px-2 disabled:bg-indigo-300'])
                :disabled="!auth()->user()->hasRole('super-admin')">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24"
                    viewBox="0 0 24 24" fill="currentColor">
                    <g>
                        <rect fill="none" height="24" width="24"></rect>
                        <rect fill="none" height="24" width="24"></rect>
                    </g>
                    <g>
                        <g>
                            <path
                                d="M17,11c0.34,0,0.67,0.04,1,0.09V7.58c0-0.8-0.47-1.52-1.2-1.83l-5.5-2.4c-0.51-0.22-1.09-0.22-1.6,0l-5.5,2.4 C3.47,6.07,3,6.79,3,7.58v3.6c0,4.54,3.2,8.79,7.5,9.82c0.55-0.13,1.08-0.32,1.6-0.55C11.41,19.47,11,18.28,11,17 C11,13.69,13.69,11,17,11z">
                            </path>
                            <path
                                d="M17,13c-2.21,0-4,1.79-4,4c0,2.21,1.79,4,4,4s4-1.79,4-4C21,14.79,19.21,13,17,13z M17,14.38c0.62,0,1.12,0.51,1.12,1.12 s-0.51,1.12-1.12,1.12s-1.12-0.51-1.12-1.12S16.38,14.38,17,14.38z M17,19.75c-0.93,0-1.74-0.46-2.24-1.17 c0.05-0.72,1.51-1.08,2.24-1.08s2.19,0.36,2.24,1.08C18.74,19.29,17.93,19.75,17,19.75z">
                            </path>
                        </g>
                    </g>
                    <title>
                        {{ $admin->hasRole('super-admin') ? 'Remove as Super Admin' : 'Make Super Admin' }}
                    </title>
                </svg>
            </x-shared.form.submit-button>
        </form>
        <form action="{{ route('admin.removeAdmin', $admin->uuid) }}" method="post">
            @csrf
            @method("DELETE")
            <x-shared.form.submit-button class="bg-red-500 hover:bg-red-600 rounded-md !px-2" :disabled="!auth()->user()->hasRole('super-admin')">
                <x-icons.delete class="w-6 h-6" />
            </x-shared.form.submit-button>
        </form>
    </div>

</article>