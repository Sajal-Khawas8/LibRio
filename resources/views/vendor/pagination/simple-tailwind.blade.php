@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="relative inline-flex items-center px-4 py-2 font-medium text-slate-300 bg-indigo-600 border border-gray-300 cursor-default leading-5 rounded-md">
                {!! __('pagination.previous') !!}
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-4 py-2 font-medium text-white bg-indigo-700 border border-gray-300 leading-5 rounded-md hover:bg-indigo-900 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-indigo-800 transition ease-in-out duration-150">
                {!! __('pagination.previous') !!}
            </a>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-4 py-2 font-medium text-white bg-indigo-700 border border-gray-300 leading-5 rounded-md hover:bg-indigo-900 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-indigo-800 transition ease-in-out duration-150">
                {!! __('pagination.next') !!}
            </a>
        @else
            <span class="relative inline-flex items-center px-4 py-2 font-medium text-slate-300 bg-indigo-600 border border-gray-300 cursor-default leading-5 rounded-md">
                {!! __('pagination.next') !!}
            </span>
        @endif
    </nav>
@endif
