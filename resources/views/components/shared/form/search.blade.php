<input type="text" name="{{ $name }}" id="{{ $name }}" value="{{ old($name, request($name)) }}"
    {{ $attributes->merge(['class'=> 'px-4 py-2 outline-none w-full rounded-md text-lg']) }}>
<button class="absolute inset-y-0 right-0 px-3 rounded-r-md bg-slate-200 hover:bg-indigo-600 hover:text-white"
    aria-label="Search">
    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
        <path d="M21 21l-6 -6"></path>
    </svg>
</button>