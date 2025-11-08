<style>
    .custom-pagination {
        display: flex;
        justify-content: center;
        background: linear-gradient(to left, #ffe4e5, #f3efef);
        border-radius: 3rem;
        padding: 0.5rem 1rem;
        list-style: none;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        gap: 6px;
        direction: rtl;
        transition: all 0.3s ease-in-out;
    }

    .custom-pagination li {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        font-size: 15px;
        transition: all 0.2s ease;
    }

    .custom-pagination a,
    .custom-pagination span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        text-decoration: none;
        color: #fa626b;
        font-weight: 600;
        border-radius: 50%;
        transition: background 0.3s, color 0.3s, transform 0.2s;
    }

    .custom-pagination a:hover {
        color: #fa626b;
    }

    .custom-pagination a:hover {
        background: #df1a271a;
        transform: scale(1.1);
    }

    .custom-pagination li.active span {
        background: #fa626b;
        color: #fff;
        box-shadow: 0 0 0 4px rgb(215 30 41 / 20%);
    }

    .custom-pagination li.disabled span,
    .custom-pagination li.disabled a {
        pointer-events: none;
        color: #e1d1cb;
        background: transparent;
    }

    .custom-pagination i {
        font-size: 1rem;
    }
</style>


@if ($paginator->hasPages())
    <nav class="d-flex justify-content-center" dir="rtl">
        <ul class="custom-pagination">
            {{-- قبلی --}}
            <li class="{{ $paginator->onFirstPage() ? 'disabled' : '' }}">
                @if ($paginator->onFirstPage())
                    <span><i class="ft-chevron-right"></i></span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}"><i class="ft-chevron-right"></i></a>
                @endif
            </li>

            {{-- صفحات --}}
            @foreach ($elements as $element)
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <li class="{{ $page == $paginator->currentPage() ? 'active' : '' }}">
                            @if ($page == $paginator->currentPage())
                                <span>{{ $page }}</span>
                            @else
                                <a href="{{ $url }}">{{ $page }}</a>
                            @endif
                        </li>
                    @endforeach
                @endif
            @endforeach

            {{-- بعدی --}}
            <li class="{{ $paginator->hasMorePages() ? '' : 'disabled' }}">
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}"><i class="ft-chevron-left"></i></a>
                @else
                    <span><i class="ft-chevron-left"></i></span>
                @endif
            </li>
        </ul>
    </nav>
@endif
