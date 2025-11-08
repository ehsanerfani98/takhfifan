<section class="mt-4">
    <main>
        <div class="row mx-0">
            @forelse (get_table_list('Service', true) as $service)
                <div class="col-4 mb-1 p-1">
                    <a href="{{ route('user.child.service', ['id' => $service->id]) }}" class="card-service">
                        <div class="icon">
                            {!! $service->icon !!}
                        </div>

                        <span class="title">
                            {{ Str::limit($service->name,40) }}
                        </span>
                    </a>
                </div>
            @empty
            <p>در حال حاضر خدماتی وجود ندارد</p>
            @endforelse
        </div>
    </main>
</section>