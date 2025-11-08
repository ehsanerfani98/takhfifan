<div class="row">
    <div class="col-12">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                @foreach (getSliders() as $slide)
                    <div class="swiper-slide">
                        @if ($slide->link)
                            <a href="{{ $slide->link }}">
                                <img src="{{ asset($slide->image) }}" alt="{{ $slide->title }}" class="img-fluid w-100" />
                            </a>
                        @else
                            <img src="{{ asset($slide->image) }}" alt="{{ $slide->title }}" class="img-fluid w-100" />
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</div>
