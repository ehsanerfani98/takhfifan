<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>مدیریت رسانه</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .thumb { height:120px; object-fit:cover; width:100%; cursor:pointer; }
  </style>
</head>
<body>
<div class="container-fluid p-3">
  <div class="d-flex justify-content-between align-items-center mb-2">
    <h5>کتابخانه</h5>
    <div>
      <input type="file" id="file" accept="image/*">
      <button id="upload" class="btn btn-sm btn-primary">آپلود</button>
    </div>
  </div>

  <div id="grid" class="row">
    @foreach($media as $m)
      <div class="col-3 mb-3">
        <img src="{{ $m->thumbnail_url }}" data-url="{{ $m->url }}" class="thumb img-thumbnail" title="{{ $m->original_name }}">
      </div>
    @endforeach
  </div>

  <div>
    {{ $media->links() }}
  </div>
</div>

<script>
const funcNum = "{{ $funcNum ?? '' }}";

document.querySelectorAll('.thumb').forEach(img=>{
    img.addEventListener('click', function(){
        const url = this.dataset.url;
        // اگر CKEditor باز کننده داشتیم، تابع callFunction رو صدا بزن
        if (window.opener && funcNum) {
            window.opener.CKEDITOR.tools.callFunction(funcNum, url);
            window.close();
        } else {
            // اگر مستقیم باز شده (مثلاً از مدیریت) — می‌توان لینک رو در کلیپ‌بورد کپی کرد
            navigator.clipboard.writeText(url).then(()=> alert('URL در کلیپ‌بورد کپی شد:\n' + url));
        }
    });
});

document.getElementById('upload').addEventListener('click', function(){
    const input = document.getElementById('file');
    if (!input.files.length) return alert('یک فایل انتخاب کنید');
    const fd = new FormData();
    fd.append('file', input.files[0]);

    fetch("{{ route('media.store') }}", {
        method: 'POST',
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
        body: fd
    }).then(r=>r.json()).then(data=>{
        if (data.success) {
            // اضافه کردن تصویر جدید به گرید
            const grid = document.getElementById('grid');
            const col = document.createElement('div');
            col.className = 'col-3 mb-3';
            col.innerHTML = `<img src="${data.media.thumbnail}" data-url="${data.media.url}" class="thumb img-thumbnail" title="${data.media.original_name}">`;
            grid.insertBefore(col, grid.firstChild);
            col.querySelector('.thumb').addEventListener('click', function(){
                if (window.opener && funcNum) {
                    window.opener.CKEDITOR.tools.callFunction(funcNum, this.dataset.url);
                    window.close();
                }
            });
        } else {
            alert('خطا در آپلود');
        }
    }).catch(e=>{ console.error(e); alert('خطا'); });
});
</script>
</body>
</html>
