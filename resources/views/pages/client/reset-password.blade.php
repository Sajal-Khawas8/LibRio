@extends("layouts.master-layout")

@section("main")

<article class="py-6 space-y-8 min-h-[calc(100vh-4rem-3.5rem)] flex flex-col justify-center">
    <h1 class="text-center text-4xl font-semibold"> Reset Password </h1>
    <form action="{{ route('password.update') }}" method="post" class="space-y-8 w-full max-w-md mx-auto">
        @csrf
        <div>
            <x-shared.form.input type="hidden" name="token" value="{{ $token }}" />
            <x-shared.form.input type="hidden" name="email" value="{{ request()->email }}" />
            <x-shared.form.input type="password" name="password" placeholder="Password" />
            <x-shared.form.error name="password" />
        </div>
        <div>
            <x-shared.form.input type="password" name="password_confirmation" placeholder="Confirm Password" />
            <x-shared.form.error name="password_confirmation" />
        </div>
        <x-shared.form.submit-button> Reset Password </x-shared.form.submit-button>
    </form>
    <footer>
        <p class="text-center text-lg"><a href="{{ route('login') }}" class="text-indigo-600 font-medium">Go back to
                Login page</a></p>
    </footer>
</article>

@endsection