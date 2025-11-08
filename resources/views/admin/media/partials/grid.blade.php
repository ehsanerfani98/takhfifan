    @foreach ($media as $m)
        <div class="col-md-2" style="margin-bottom: 30px">
            <div class="card m-0" style="box-shadow: rgba(0, 0, 0, 0.08) 0px 4px 12px !important;min-height: 245px">
                <img src="{{ $m->thumbnail_url }}" class="card-img-top" style="height:120px;object-fit:cover;">
                <div class="card-body p-2">
                    <small>{{ $m->original_name }}</small>
                    <div class="mt-1">
                        <button class="btn btn-sm btn-danger"
                            onclick="deleteMedia({{ $m->id }}, this)">حذف</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
