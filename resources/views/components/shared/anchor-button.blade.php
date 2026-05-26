<a href="{{ $href }}"
    {{ $attributes->merge(['class'=>'inline-block px-4 py-1 bg-indigo-600 text-white text-lg text-center font-medium rounded-md w-full hover:bg-indigo-800']) }}
    role="button">
    {{ $slot }} </a>