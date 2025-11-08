@extends('admin.layout')
@section('title', 'ویرایش مدل خودرو')

@push('style')
    <link rel="stylesheet" href="{{ asset('admin/plugins/select2/dist/css/select2.min.css') }}">
@endpush

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

    <form method="POST" action="{{ route('models.update', $Model->id) }}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">اطلاعات مدل خودرو</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="title">عنوان مدل</label>
                                    <input type="text" name="title" id="title" placeholder="عنوان مدل"
                                        class="form-control" value="{{ $Model->title }}" required>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="slug">اسلاگ</label>
                                    <input type="text" name="slug" id="slug" placeholder="اسلاگ"
                                        class="form-control" value="{{ $Model->slug }}" required>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="brand_id">برند</label>
                                    <select name="brand_id" id="brand_id" class="form-control select2" required>
                                        <option value="">انتخاب برند</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}"
                                                {{ $Model->brand_id == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="years">سال‌ها</label>
                                    <select name="years[]" id="years" class="form-control select2-tags"
                                        multiple="multiple" data-tags="true">
                                        @php
                                            $existingYears = $Model->years ?? [];
                                            // سال‌های پیش‌فرض
                                            $defaultYears = [];
                                            for ($year = date('Y'); $year >= 2000; $year--) {
                                                $defaultYears[] = (string) $year;
                                            }
                                            // ترکیب سال‌های موجود و پیش‌فرض
                                            $allYears = array_unique(array_merge($defaultYears, $existingYears));
                                            rsort($allYears); // مرتب سازی نزولی
                                        @endphp
                                        @foreach ($allYears as $year)
                                            <option value="{{ $year }}"
                                                {{ in_array($year, $existingYears) ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">می‌توانید سال‌های جدید را تایپ کرده و Enter
                                        بزنید</small>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="types">تیپ ها</label>
                                    <select name="types[]" id="types" class="form-control select2-tags"
                                        multiple="multiple" data-tags="true">
                                        @php
                                            $existingTypes = $Model->types ?? [];
                                            // تیپ‌های پیش‌فرض
                                            $defaultTypes = [
                                                'صندوق دار',
                                                'سدان',
                                                'هاچ بک',
                                                'شاسی بلند',
                                                'کوپه',
                                                'ون',
                                                'پیکاپ',
                                                'کراس اوور',
                                                'مینی ون',
                                                'اسپورت',
                                            ];
                                            // ترکیب تیپ‌های موجود و پیش‌فرض
                                            $allTypes = array_unique(array_merge($defaultTypes, $existingTypes));
                                        @endphp
                                        @foreach ($allTypes as $type)
                                            <option value="{{ $type }}"
                                                {{ in_array($type, $existingTypes) ? 'selected' : '' }}>
                                                {{ $type }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">می‌توانید تیپ‌های جدید را تایپ کرده و Enter
                                        بزنید</small>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="colors">رنگ‌ها</label>
                                    <select name="colors[]" id="colors" class="form-control select2-tags"
                                        multiple="multiple" data-tags="true">
                                        @php
                                            $existingColors = $Model->colors ?? [];
                                            // رنگ‌های پیش‌فرض
                                            $defaultColors = [
                                                'مشکی',
                                                'سفید',
                                                'نقره‌ای',
                                                'خاکستری',
                                                'قرمز',
                                                'آبی',
                                                'سبز',
                                                'زرد',
                                                'نارنجی',
                                                'صورتی',
                                                'بنفش',
                                                'قهوه‌ای',
                                                'طلایی',
                                                'نوک مدادی',
                                                'بژ',
                                                'فیروزه‌ای',
                                                'یاسی',
                                                'زرشکی',
                                            ];
                                            // ترکیب رنگ‌های موجود و پیش‌فرض
                                            $allColors = array_unique(array_merge($defaultColors, $existingColors));
                                        @endphp
                                        @foreach ($allColors as $color)
                                            <option value="{{ $color }}"
                                                {{ in_array($color, $existingColors) ? 'selected' : '' }}>
                                                {{ $color }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">می‌توانید رنگ‌های جدید را تایپ کرده و Enter
                                        بزنید</small>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success btn-sm">
                            ذخیره
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('script')
    <script src="{{ asset('admin/plugins/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/select2/dist/js/i18n/fa.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Select2 معمولی برای برند
            $('#brand_id').select2({
                rtl: true,
                placeholder: "انتخاب برند"
            });

            // Select2 با قابلیت tags برای سال‌ها، تیپ‌ها و رنگ‌ها
            $('.select2-tags').select2({
                rtl: true,
                tags: true,
                tokenSeparators: [',', '،'],
                placeholder: "انتخاب کنید یا مقدار جدید وارد کنید",
                createTag: function(params) {
                    var term = $.trim(params.term);

                    if (term === '') {
                        return null;
                    }

                    return {
                        id: term,
                        text: term,
                        newTag: true
                    };
                }
            });

            // اعتبارسنجی برای سال‌ها - فقط اعداد مجاز
            $('#years').on('select2:select', function(e) {
                var data = e.params.data;
                if (data.newTag) {
                    if (!/^\d+$/.test(data.id)) {
                        notifier.alert('فقط اعداد مجاز هستند', {
                            labels: {
                                alert: 'خطا'
                            },
                        });
                        // حذف تگ نامعتبر
                        var $element = $(this);
                        var existingValues = $element.val();
                        existingValues = existingValues.filter(function(value) {
                            return value !== data.id;
                        });
                        $element.val(existingValues).trigger('change');
                    } else if (data.id.length !== 4) {
                        notifier.alert('سال باید 4 رقمی باشد', {
                            labels: {
                                alert: 'خطا'
                            },
                        });
                        // حذف تگ نامعتبر
                        var $element = $(this);
                        var existingValues = $element.val();
                        existingValues = existingValues.filter(function(value) {
                            return value !== data.id;
                        });
                        $element.val(existingValues).trigger('change');
                    }
                }
            });

            // جلوگیری از وارد کردن اعداد در فیلد تیپ‌ها
            $('#types').on('select2:select', function(e) {
                var data = e.params.data;
                if (data.newTag) {
                    if (/^\d+$/.test(data.id)) {
                        notifier.alert('اعداد در این فیلد مجاز نیستند', {
                            labels: {
                                alert: 'خطا'
                            },
                        });
                        // حذف تگ نامعتبر
                        var $element = $(this);
                        var existingValues = $element.val();
                        existingValues = existingValues.filter(function(value) {
                            return value !== data.id;
                        });
                        $element.val(existingValues).trigger('change');
                    }
                }
            });
        });

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
