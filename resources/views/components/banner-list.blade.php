  <section>
      <div class="row">
          <div class="col-12">
              @foreach (getBanners() as $banner)
                  <div class="banner mt-3">
                      @if ($banner->link)
                          <a href="{{ $banner->link }}">
                              <img src="{{ asset($banner->image) }}" alt="{{ $banner->title }}" />
                          </a>
                      @else
                          <img src="{{ asset($banner->image) }}" alt="{{ $banner->title }}" />
                      @endif
                  </div>
              @endforeach
          </div>
      </div>
  </section>
