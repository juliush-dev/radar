<nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between px-4 sm:px-0 py-3">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
        <span
            class="relative inline-flex items-center px-4 py-2 text-xs sm:text-sm font-medium text-fuchsia-500  bg-white  cursor-default leading-5 ">
            {!! __('pagination.previous') !!}
        </span>
    @else
        <a @click.exact.prevent="table.navigate(@js($paginationUrl = $paginator->previousPageUrl()), true)" dusk="pagination-simple-previous"
            href="{{ $paginationUrl }}" rel="prev"
            class="relative inline-flex items-center px-4 py-2 text-xs sm:text-sm font-medium text-slate-500  bg-white leading-5 hover:text-slate-800 focus:outline-none focus:ring ring-slate-300  active:bg-fuchsia-100 active:text-sky-500 transition ease-in-out duration-150">
            {!! __('pagination.previous') !!}
        </a>
    @endif

    @includeWhen($hasPerPageOptions ?? true, 'splade::table.per-page-selector')

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <a @click.exact.prevent="table.navigate(@js($paginationUrl = $paginator->nextPageUrl()), true)" dusk="pagination-simple-next"
            href="{{ $paginationUrl }}" rel="next"
            class="relative inline-flex items-center px-4 py-2 text-xs sm:text-sm font-medium text-fuchsia-700 bg-white  leading-5  hover:text-fuchsia-500 focus:outline-none active:bg-fuchsia-100 active:text-fuchsia-700 transition ease-in-out duration-150">
            {!! __('pagination.next') !!}
        </a>
    @else
        <span
            class="relative inline-flex items-center px-4 py-2 text-xs sm:text-sm font-medium text-fuchsia-500 bg-white  cursor-default leading-5 ">
            {!! __('pagination.next') !!}
        </span>
    @endif
</nav>
