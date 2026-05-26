@extends("layouts.master-layout")

@section("main")

<article class="py-6 space-y-8 min-h-[calc(100vh-4rem-3.5rem)] flex flex-col justify-center">
    <h1 class="text-center text-4xl font-semibold"> Login to LibRio </h1>
    <form action="/login" method="post" class="space-y-8 w-full max-w-md mx-auto">
        @csrf
        <div>
            <x-shared.form.input type="email" name="email" placeholder="Email Address" />
            <x-shared.form.error name="email" />
        </div>
        <div>
            <x-shared.form.input type="password" name="password" placeholder="Password" />
            <x-shared.form.error name="password" />
        </div>
        <a href="{{ route('forgot-password') }}" class="text-indigo-600 font-medium inline-block">Forgot Password?</a>
        <x-shared.form.submit-button> Login </x-shared.form.submit-button>
    </form>
    <footer>
        <p class="text-center text-lg">Don't have an account? <a href="/register"
                class="text-indigo-600 font-medium">Create here</a></p>
    </footer>
</article>

@endsection