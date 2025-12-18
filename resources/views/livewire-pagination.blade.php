@if ($paginator->hasPages())
    <nav>
        <ul class="pagination pagination-rounded justify-content-center">

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">&laquo; Prev</span>
                </li>
            @else
                <li class="page-item">
                    <button wire:click="previousPage" class="page-link">&laquo; Prev</button>
                </li>
            @endif


            {{-- Page Numbers --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled">
                        <span class="page-link">{{ $element }}</span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <button wire:click="gotoPage({{ $page }})" class="page-link">
                                    {{ $page }}
                                </button>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach


            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <button wire:click="nextPage" class="page-link">Next &raquo;</button>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">Next &raquo;</span>
                </li>
            @endif

        </ul>
    </nav>
@endif
