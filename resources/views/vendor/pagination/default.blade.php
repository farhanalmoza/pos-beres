@if ($paginator->hasPages())
  <nav aria-label="Page navigation">
    <ul class="pagination">
      {{-- Previous Page Link --}}
      @if ($paginator->onFirstPage())
        <li class="page-item first disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
          <a class="page-link" href="javascript:void(0);"><i class="tf-icon bx bx-chevrons-left"></i></a>
        </li>
      @else
        <li class="page-item prev">
          <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
            <i class="tf-icon bx bx-chevron-left"></i>
          </a>
        </li>
      @endif

      {{-- Pagination Elements --}}
      @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
          <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
          @foreach ($element as $page => $url)
            @if ($page == $paginator->currentPage())
              <li class="page-item active">
                <a class="page-link" href="javascript:void(0);">{{ $page }}</a>
              </li>
            @else
              <li class="page-item">
                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
              </li>
            @endif
          @endforeach
        @endif
      @endforeach

      {{-- Next Page Link --}}
      @if ($paginator->hasMorePages())
        <li class="page-item next">
          <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="@lang('pagination.next')"><i class="tf-icon bx bx-chevron-right"></i></a>
        </li>
      @else
        <li class="page-item last disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
          <a class="page-link" href="javascript:void(0);"><i class="tf-icon bx bx-chevrons-right"></i></a>
        </li>
      @endif
    </ul>
  </nav>
@endif
