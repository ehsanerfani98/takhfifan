@extends('admin.layout')
@section('title', 'ایجاد برند')

@section('content')

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                notifier.alert('{{ $error }}', {
                    labels: {
                        alert: 'خطا'
                    },
                })
            </script>
        @endforeach
    @endif

    <form method="POST" action="{{ route('brands.store') }}">
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">اطلاعات برند</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="title">عنوان برند</label>
                                    <input type="text" name="title" id="title" placeholder="عنوان برند"
                                        class="form-control" value="{{ old('title') }}" required>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="slug">نامک</label>
                                    <input type="text" name="slug" id="slug" placeholder="نامک"
                                        class="form-control" value="{{ old('slug') }}" required>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="icon">آیکن</label>
                                    <x-media-picker name="icon" id="icon" value="{{ old('icon') }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attributes Section -->
            <div class="col-xs-12 col-sm-12 col-md-12 mt-4">
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">ویژگی‌های مرتبط با برند</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if($attributes->count() > 0)
                                @foreach($attributes as $attribute)
                                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                   name="attributes[]"
                                                   value="{{ $attribute->id }}"
                                                   id="attribute_{{ $attribute->id }}"
                                                   {{ in_array($attribute->id, old('attributes', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="attribute_{{ $attribute->id }}">
                                                {{ $attribute->label ?? $attribute->name }}
                                               
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-12">
                                    <p class="text-muted">هیچ ویژگی فعالی یافت نشد.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <button type="submit" class="btn btn-success btn-sm">
                    ذخیره
                </button>
                <a href="{{ route('brands.index') }}" class="btn btn-secondary btn-sm">انصراف</a>
            </div>
        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('script')
    <script>
        /* ---------- استاندارد‌سازی اسلاگ (بدون تبدیل حروف) ---------- */
        function standardizeSlug(str) {
            return str
                .trim()
                // هرچه غیر از حروف، اعداد، فضا و - است را حذف کن
                .replace(/[^\p{L}\p{N}\s-]+/gu, '')
                // فضا و خط‌تیره‌های پیاپی را به یک - تبدیل کن
                .replace(/[\s-]+/g, '-')
                // - اضافی ابتدا/انتها را بردار
                .replace(/^-+|-+$/g, '');
        }

        /* ---------- اتصال به فیلد عنوان ---------- */
        $(document).on('input', 'input[name="title"]', function() {
            const slug = standardizeSlug($(this).val());
            $('input[name="slug"]').val(slug);
        });
    </script>
@endpush
