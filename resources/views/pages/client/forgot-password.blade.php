@extends("layouts.master-layout")

@section("main")

<article class="py-6 space-y-8 min-h-[calc(100vh-4rem-3.5rem)] flex flex-col justify-center">
    <h1 class="text-center text-4xl font-semibold"> Forgot Password </h1>
    <form action="{{ route('forgot-password') }}" method="post" class="space-y-8 w-full max-w-md mx-auto">
        @csrf
        <div>
            <x-shared.form.input type="email" name="email" placeholder="Email Address" />
            <x-shared.form.error name="email" />
        </div>
        <x-shared.form.submit-button> Send Reset Link </x-shared.form.submit-button>
    </form>
    <footer>
        <p class="text-center text-lg"><a href="{{ route('login') }}"
                class="text-indigo-600 font-medium">Go back to Login page</a></p>
    </footer>
</article>

@endsection