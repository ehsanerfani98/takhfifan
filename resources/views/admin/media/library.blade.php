@extends('admin.layout')
@section('title', 'مدیریت کتابخانه')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="px-2 d-flex align-items-center justify-content-between">
                <h5 class="text-bold-700 my-2 text-white">کتابخانه رسانه</h5>
                <h5 class="text-bold-700 my-2 text-white">{{ count($media) }} فایل</h5>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <input type="file" id="media-file" accept="image/*">
                        <button id="upload-btn" class="btn btn-primary">آپلود</button>
                    </div>

                    <div id="media-grid" class="row">
                        @include('admin.media.partials.grid', ['media' => $media])
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 text-center">
            {!! $media->links('pagination::bootstrap-5') !!}
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.getElementById('upload-btn').addEventListener('click', function() {
            const input = document.getElementById('media-file');
            if (!input.files.length) return alert('یک فایل انتخاب کنید.');
            const fd = new FormData();
            fd.append('file', input.files[0]);

            fetch("{{ route('media.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: fd
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        // prepend new item to grid
                        const grid = document.getElementById('media-grid');
                        const html = `
<div class="col-md-2 mb-3">
  <div class="card border">
    <img src="${data.media.thumbnail}" class="card-img-top" style="height:120px;object-fit:cover;">
    <div class="card-body p-2">
      <small>${data.media.original_name}</small>
      <div class="mt-1">
        <button class="btn btn-sm btn-danger" onclick="deleteMedia('${data.media.id}', this)">حذف</button>
      </div>
    </div>
  </div>
</div>`;
                        // simple prepend
                        grid.insertAdjacentHTML('afterbegin', html);
                        input.value = '';
                    } else {
                        alert('خطا در آپلود');
                    }
                })
                .catch(e => {
                    console.error(e);
                    alert('خطا در آپلود')
                });
        });

        window.deleteMedia = function(id, btn) {
            if (!confirm('آیا مطمئن هستید؟')) return;
            fetch('/media/' + id, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(r => r.json()).then(j => {
                if (j.success) {
                    btn.closest('.col-md-2').remove();
                }
            });
        };
    </script>
@endpush
