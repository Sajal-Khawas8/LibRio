<button
    {{ $attributes->merge(["class" => "px-4 py-1 text-lg font-medium rounded-md w-full text-white bg-indigo-600 hover:bg-indigo-800 cursor-pointer disabled:opacity-60 disabled:cursor-not-allowed"]) }}
    x-data="{ loading: false }"
    x-on:click.prevent="loading = true; $nextTick(() => $el.closest('form').requestSubmit())"
    x-bind:disabled="loading || {{ $disabled ? 'true' : 'false' }}"
    type="submit">
    <span x-show="!loading">{{ $slot }}</span>
    <span x-show="loading" x-cloak class="flex items-center justify-center gap-2">
        <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z" />
        </svg>
    </span>
</button>