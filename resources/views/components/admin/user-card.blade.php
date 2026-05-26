<article class="flex flex-col justify-between h-full space-y-3">
    <div class="flex items-center justify-between">
        <h2 class="font-semibold text-2xl">{{ $user->name }}</h2>
        <form action="{{ route('admin.readers.block', $user->uuid) }}" method="post">
            @csrf
            @method("DELETE")
            <button name="blockUser">
                <svg class="w-6 h-6 text-red-600" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24"
                    viewBox="0 0 24 24" fill="currentColor">
                    <g>
                        <rect fill="none" height="24" width="24"></rect>
                    </g>
                    <g>
                        <g>
                            <path
                                d="M18,11c0.7,0,1.37,0.1,2,0.29V10c0-1.1-0.9-2-2-2h-1V6c0-2.76-2.24-5-5-5S7,3.24,7,6v2H6c-1.1,0-2,0.9-2,2v10 c0,1.1,0.9,2,2,2h6.26C11.47,20.87,11,19.49,11,18C11,14.13,14.13,11,18,11z M8.9,6c0-1.71,1.39-3.1,3.1-3.1s3.1,1.39,3.1,3.1v2 H8.9V6z">
                            </path>
                            <path
                                d="M18,13c-2.76,0-5,2.24-5,5s2.24,5,5,5s5-2.24,5-5S20.76,13,18,13z M18,15c0.83,0,1.5,0.67,1.5,1.5S18.83,18,18,18 s-1.5-0.67-1.5-1.5S17.17,15,18,15z M18,21c-1.03,0-1.94-0.52-2.48-1.32C16.25,19.26,17.09,19,18,19s1.75,0.26,2.48,0.68 C19.94,20.48,19.03,21,18,21z">
                            </path>
                        </g>
                    </g>
                    <title>Block this user</title>
                </svg>
            </button>
        </form>
    </div>
    <h3 class="font-medium text-lg"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></h3>
    <dl class="w-64">
        <dt class="font-medium">Address:</dt>
        <dd>
            <address class="not-italic">{{ $user->address }}</address>
        </dd>
    </dl>
    <div class="flex items-center justify-between gap-12">
        <dl class="flex gap-2">
            <dt class="font-medium">Total Books taken on Rent:</dt>
            <dd>{{ $user->orders->count() }}</dd>
        </dl>
        <x-shared.button class="!w-auto !px-2"
            onclick="document.getElementById('modal-{{ $user->uuid }}').style.display='flex'">
            View Books
        </x-shared.button>
    </div>
</article>