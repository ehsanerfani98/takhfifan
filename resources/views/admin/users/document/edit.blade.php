@extends('admin.layout')
@section('name', 'ویرایش پروفایل کاربر: ' . $user->name)
@section('actions')
    <a href="{{ route('documents.show', $user->id) }}" class="btn btn-primary btn-sm btn-icon-split">
        <span class="text-white-50">
            <i class="fas fa-arrow-right"></i>
        </span>
        <span class="text">برگشت</span>
    </a>
@endsection

@section('content')

    @session('success')
        <div class="alert alert-success">{{ $value }}</div>
    @endsession

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('documents.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">اطلاعات پروفایل {{ $user->name }}</h6>
            </div>
            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">نوع کاربر</label>
                    <select name="type" class="form-control" required>
                        <option value="real" {{ old('type', $document?->type) == 'real' ? 'selected' : '' }}>حقیقی
                        </option>
                        <option value="legal" {{ old('type', $document?->type) == 'legal' ? 'selected' : '' }}>حقوقی
                        </option>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>نام</label>
                        <input type="text" name="first_name" class="form-control"
                            value="{{ old('first_name', $document?->first_name) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>نام خانوادگی</label>
                        <input type="text" name="last_name" class="form-control"
                            value="{{ old('last_name', $document?->last_name) }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label>شماره موبایل</label>
                    <input type="text" name="mobile" class="form-control"
                        value="{{ old('mobile', $document?->mobile) }}">
                </div>

                <div class="mb-3">
                    <label>کد ملی</label>
                    <input type="text" name="national_id" class="form-control"
                        value="{{ old('national_id', $document?->national_id) }}">
                </div>

                <div class="mb-3">
                    <label>نام شرکت</label>
                    <input type="text" name="company_name" class="form-control"
                        value="{{ old('company_name', $document?->company_name) }}">
                </div>

                <div class="mb-3">
                    <label>آدرس شرکت</label>
                    <textarea name="company_address" class="form-control" rows="3">{{ old('company_address', $document?->company_address) }}</textarea>
                </div>

                <div class="form-check mb-3">
                    <input value="1" type="checkbox" class="form-check-input" name="is_verified" id="is_verified"
                        {{ old('is_verified', $document?->is_verified) ? 'checked' : '' }}>
                    <label class="form-check-label mr-4" for="is_verified">تایید شده</label>
                </div>

                <div class="form-check mb-3">
                    <input value="1" type="checkbox" class="form-check-input" name="needs_correction"
                        id="needs_correction" {{ old('needs_correction', $document?->needs_correction) ? 'checked' : '' }}>
                    <label class="form-check-label mr-4" for="needs_correction">نیاز به اصلاح دارد</label>
                </div>

                <div class="mb-3">
                    <label>توضیحات</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $document?->description) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label">بارگذاری فایل‌ها</label>
                    <div class="custom-file-upload-area border border-2 rounded p-4 text-center position-relative bg-light">
                        <input type="file" id="fileInput" name="files[]" multiple hidden>
                        <div onclick="document.getElementById('fileInput').click()" style="cursor: pointer;">
                            <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
                            <p class="text-muted mb-0">برای انتخاب فایل کلیک کنید</p>
                            <small class="d-block mt-2">فرمت‌های مجاز: JPG, PNG</small>
                        </div>
                        <div id="previewArea" class="d-flex flex-wrap justify-content-center mt-3 gap-3"></div>
                    </div>
                </div>

                @if ($document && $document->files->count())
                    <div class="mb-4">
                        <label>فایل‌های موجود:</label>
                        <div class="row">
                            @foreach ($document->files as $file)
                                <div class="col-md-2 mb-3 text-center" id="file-{{ $file->id }}">
                                    <div class="border p-2 rounded">
                                        @if (Str::endsWith($file->path, ['.jpg', '.jpeg', '.png', '.webp']))
                                            <img src="{{ asset($file->path) }}" class="img-fluid rounded mb-2"
                                                style="max-height: 100px;">
                                        @else
                                            <a href="{{ asset($file->path) }}" target="_blank" class="d-block mb-2">نمایش
                                                فایل</a>
                                        @endif
                                        <button type="button" class="btn btn-sm btn-danger"
                                            onclick="deleteFile({{ $file->id }})">حذف</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <button type="submit" class="btn btn-success">ذخیره پروفایل</button>
            </div>
        </div>
    </form>

@endsection

@section('js')
    <script>
        function deleteFile(id) {
            if (confirm('آیا از حذف این فایل مطمئن هستید؟')) {
                fetch('{{ url('/documents/files') }}/' + id, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('file-' + id).remove();
                        }
                    });
            }
        }
        const fileInput = document.getElementById('fileInput');
        const previewArea = document.getElementById('previewArea');

        fileInput.addEventListener('change', function() {
            previewArea.innerHTML = '';
            [...this.files].forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    let preview;
                    if (file.type.startsWith('image/')) {
                        preview =
                            `<img src="${e.target.result}" class="rounded border" style="width:100px;height:auto;">`;
                    } else {
                        preview = `<div class="border rounded p-2 text-center" style="width:100px">
                        <i class="fas fa-file-alt fa-2x text-secondary"></i><br><small>${file.name}</small>
                    </div>`;
                    }
                    previewArea.innerHTML += `<div class="mx-2 mb-2">${preview}</div>`;
                };
                reader.readAsDataURL(file);
            });
        });

        document.getElementById('is_verified').addEventListener('change', function() {
            if (this.checked) {
                document.getElementById('needs_correction').checked = false;
            }
        });

        document.getElementById('needs_correction').addEventListener('change', function() {
            if (this.checked) {
                document.getElementById('is_verified').checked = false;
            }
        });
    </script>
@endsection
