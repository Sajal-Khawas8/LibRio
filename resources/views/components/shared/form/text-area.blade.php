<textarea name="{{ $name }}" {{ $attributes }}
    class="w-full px-4 py-2 border border-gray-600 rounded outline-indigo-600 placeholder:text-gray-500 resize-none h-28">{{  $slot->isEmpty() ? old($name) : $slot }}
</textarea>