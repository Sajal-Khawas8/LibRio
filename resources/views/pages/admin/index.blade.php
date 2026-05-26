@extends("layouts.admin-panel-layout")

@section("admin")
<header class="py-2.5 px-6">
    <h1 class="my-2.5 text-3xl font-medium text-center xl:text-left">LibRio Dashboard</h1>
</header>
<div class="grid grid-cols-2 gap-8 px-8 text-white overflow-y-auto">
    <article class="text-center ">
        <div class="bg-sky-800 h-80 flex flex-col items-center justify-evenly">
            <h2 class="text-4xl">Titles</h2>
            <p
                class="text-8xl border-8 border-white rounded-full h-40 w-40 flex items-center justify-center text-white">
                <span>{{ $data->books }}</span>
            </p>
        </div>
        <dl class="bg-gray-700 grid grid-cols-3 h-52 divide-x divide-white">
            <div class="flex flex-col items-center justify-evenly">
                <dt class="text-2xl">Categories</dt>
                <dd
                    class="text-5xl border-4 border-slate-200 rounded-full h-28 w-28 flex items-center justify-center text-slate-200">
                    <span>{{ $data->categories }}</span>
                </dd>
            </div>
            <div class="flex flex-col items-center justify-evenly">
                <dt class="text-2xl">Books</dt>
                <dd
                    class="text-5xl border-4 border-slate-200 rounded-full h-28 w-28 flex items-center justify-center text-slate-200">
                    <span>{{ $data->quantity }}</span>
                </dd>
            </div>
            <div class="flex flex-col items-center justify-evenly">
                <dt class="text-2xl">Orders</dt>
                <dd
                    class="text-5xl border-4 border-slate-200 rounded-full h-28 w-28 flex items-center justify-center text-slate-200">
                    <span>{{ $data->orders }}</span>
                </dd>
            </div>
        </dl>
    </article>
    <div class="space-y-8">
        <dl class="flex justify-center h-52 divide-x divide-white">
            <div class="flex-1 flex flex-col items-center justify-evenly bg-sky-800">
                <dt class="text-3xl">Readers</dt>
                <dd
                    class="text-6xl border-4 border-white rounded-full h-28 w-28 flex items-center justify-center text-white">
                    <span>{{ $data->users->reader ?? 0 }}</span>
                </dd>
            </div>
            <div class="flex-1 flex flex-col items-center justify-evenly bg-gray-700">
                <dt class="text-3xl">Team</dt>
                <dd
                    class="text-6xl border-4 border-white rounded-full h-28 w-28 flex items-center justify-center text-white">
                    <span>{{ ($data->users->admin ?? 0) + ($data->users->{'super-admin'} ?? 0) }}</span>
                </dd>
            </div>
        </dl>
        <article class="h-72 flex items-center">
            <div class="flex-1 bg-sky-800 h-full flex flex-col items-center justify-evenly">
                <h2 class="text-4xl">Income</h2>
                <p class="text-6xl text-white"><span
                        class="text-3xl">&#x20B9;</span>{{ number_format($data->income->total ?? 0, 2) }}
                </p>
            </div>
            <dl class="flex-1 h-full flex flex-col justify-center bg-gray-700 divide-y divide-white">
                <div class="flex-1 grid grid-cols-3 items-center px-4">
                    <dt class="text-xl col-span-2">Transactions</dt>
                    <dd class="text-2xl text-right text-slate-200">
                        <span>{{ $data->transactions }}</span>
                    </dd>
                </div>
                <div class="flex-1 grid grid-cols-3 items-center px-4">
                    <dt class="text-xl col-span-2">Rent Collected</dt>
                    <dd class="text-2xl text-right text-slate-200">
                        <span
                            class="text-xl font-medium">&#x20B9;</span>{{ number_format($data->income->rent ?? 0, 2) }}
                    </dd>
                </div>
                <div class="flex-1 grid grid-cols-3 items-center px-4">
                    <dt class="text-xl col-span-2">Fine Collected</dt>
                    <dd class="text-2xl text-right text-slate-200">
                        <span class="text-xl font-medium">&#x20B9;</span>{{ number_format($data->income->fine ?? 0, 2) }}
                    </dd>
                </div>
            </dl>
        </article>
    </div>
</div>
@endsection