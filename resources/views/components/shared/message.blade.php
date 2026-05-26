<div
    class="fixed top-0 z-50 inset-x-0 text-white text-xl flex items-center justify-center h-12 {{ $type === 'error' ? 'bg-red-500' : 'bg-green-500' }} ">
    {{ session($type) }}
    <button type="button" onclick="this.parentNode.style.display='none'" class="absolute top-3 right-16 bg-gray-800 rounded-full">
        <x-icons.close-circle class="w-7 h-7" />
    </button>
</div>