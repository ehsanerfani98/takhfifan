@extends('admin.layout')
@section('title', 'ویرایش ماشین')

@push('style')
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor4/4.17.1/full-all/ckeditor.css">
    <style>
        .cke_combo_text,
        .cke_combo_inlinelabel,
        .cke_button_label,
        .cke_panel {
            font-family: 'Vazir-FD', sans-serif !important;
        }
    </style>
@endpush

@section('content')
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                notifier.alert('{{ $error }}', {
                    labels: {
                        alert: 'خطا'
                    }
                });
            </script>
        @endforeach
    @endif

    <form action="{{ route('cars.update', $car->id) }}" method="POST" id="car-form">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">ویرایش ماشین</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- عنوان -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>عنوان</label>
                                    <input type="text" name="title" class="form-control"
                                        value="{{ old('title', $car->title) }}">
                                </div>
                            </div>

                            <!-- نامک -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>نامک</label>
                                    <input type="text" name="slug" class="form-control"
                                        value="{{ old('slug', $car->slug) }}">
                                </div>
                            </div>

                            <!-- توضیحات -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label>توضیحات</label>
                                    <textarea name="description" class="form-control" id="editor">{{ old('description', $car->description) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" value="1" class="form-check-input" id="keyword"
                                            name="keyword" {{ old('keyword', $car->keyword) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="keyword">نمایش در باکس جستجو</label>
                                    </div>
                                </div>
                            </div>

                            <!-- کانتینر ویژگی‌ها -->
                            <div class="col-12">
                                <hr>
                                <div id="attributes-container" class="row"></div>
                            </div>
                        </div>

                        <button type="button" id="add-attribute" class="btn btn-success btn-sm mt-2">افزودن ویژگی</button>
                        <button type="submit" class="btn btn-success btn-sm mt-2">ذخیره تغییرات</button>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">

                <!-- حالت ویژه -->
                <div class="card shadow ">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">محصول ویژه</h6>
                    </div>
                    <div class="card-body">
                        <select class="form-control" name="vip" id="vip">
                            <option {{ optional($car)->vip == 0 ? 'selected' : '' }} value="0">خیر</option>
                            <option {{ optional($car)->vip == 1 ? 'selected' : '' }} value="1">بله</option>
                        </select>
                    </div>
                </div>

                <!-- وضعیت ماشین -->
                <div class="card shadow ">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">وضعیت ماشین</h6>
                    </div>
                    <div class="card-body">
                        <select class="form-control" name="status" id="status">
                            <option {{ optional($car)->status == 'inreview' ? 'selected' : '' }} value="inreview">در حال
                                کارشناسی</option>
                            <option {{ optional($car)->status == 'assessed' ? 'selected' : '' }} value="assessed">کارشناسی
                                شده</option>
                            <option {{ optional($car)->status == 'sold' ? 'selected' : '' }} value="sold">فروخته شده
                            </option>
                        </select>
                    </div>
                </div>

                <!-- مشاور -->
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">مشاور</h6>
                    </div>
                    <div class="card-body">
                        <select name="user_id" id="user_id" class="form-control" required>
                            <option value="">انتخاب مشاور</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ old('user_id') == $user->id || (isset($car) && $car->user_id == $user->id) ? 'selected' : '' }}>
                                    {{ optional($user->document)->first_name . ' ' . optional($user->document)->last_name }}
                                    |
                                    {{ $user->phone }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- برندها -->
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">برند</h6>
                    </div>
                    <div class="card-body">
                        <select name="brand_id" id="brand_id" class="form-control" required>
                            <option value="">انتخاب برند</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}"
                                    {{ old('brand_id') == $brand->id || (isset($car) && $car->brand_id == $brand->id) ? 'selected' : '' }}>
                                    {{ $brand->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- مدل ها -->
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">مدل</h6>
                    </div>
                    <div class="card-body">
                        <select name="car_model_id" id="car_model_id" class="form-control" required>
                            <option value="">ابتدا برند را انتخاب کنید</option>
                            @if (isset($models) && count($models) > 0)
                                @foreach ($models as $model)
                                    <option value="{{ $model->id }}"
                                        {{ old('car_model_id') == $model->id || (isset($car) && $car->car_model_id == $model->id) ? 'selected' : '' }}>
                                        {{ $model->title }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <!-- تصویر شاخص -->
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">تصویر شاخص</h6>
                    </div>
                    <div class="card-body" id="thumbnail_container">
                        <x-media-picker name="thumbnail" id="thumbnail" value="{{ old('thumbnail', $car->thumbnail) }}" />
                    </div>
                </div>

                <!-- گالری تصاویر -->
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">گالری تصاویر</h6>
                    </div>
                    <div class="card-body" id="gallery_container">
                        <x-media-picker name="gallery" id="gallery"
                            value="{{ old('gallery', json_encode($car->gallery ?: [])) }}" :multiple="true" />
                    </div>
                </div>

                <!-- گواهی فنی خودرو -->
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">گواهی فنی خودرو</h6>
                    </div>
                    <div class="card-body" id="certificate_container">
                        <x-media-picker name="certificate" id="certificate"
                            value="{{ old('certificate', $car->certificate) }}" />
                    </div>
                </div>

                <!-- پرونده‌های خودرو -->
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">پرونده‌های خودرو</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($carFiles as $file)
                                <div class="col-12 col-lg-6 col-lg-4 mb-2">
                                    <h6>{{ $file->title }}</h6>
                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                        data-target="#fileModal{{ $file->id }}">
                                        مشاهده پارامترها
                                    </button>
                                </div>

                                <!-- Modal -->
                                <div class="modal fade" id="fileModal{{ $file->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="modalLabel{{ $file->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalLabel{{ $file->id }}">
                                                    پارامترهای پرونده: {{ $file->title }}
                                                </h5>
                                                {{-- <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="بستن">
                                                    <span aria-hidden="true">&times;</span>
                                                </button> --}}

                                                <div class="form-group">
                                                    <select name="file_ratings[{{ $file->id }}]"
                                                        id="file_rating_{{ $file->id }}" class="form-control">
                                                        <option value="">-- انتخاب امتیاز --</option>
                                                        <option value="ضعیف"
                                                            {{ optional($car->fileRatings->where('car_file_id', $file->id)->first())->rating == 'ضعیف' ? 'selected' : '' }}>
                                                            ضعیف
                                                        </option>
                                                        <option value="متوسط"
                                                            {{ optional($car->fileRatings->where('car_file_id', $file->id)->first())->rating == 'متوسط' ? 'selected' : '' }}>
                                                            متوسط
                                                        </option>
                                                        <option value="خوب"
                                                            {{ optional($car->fileRatings->where('car_file_id', $file->id)->first())->rating == 'خوب' ? 'selected' : '' }}>
                                                            خوب
                                                        </option>
                                                        <option value="عالی"
                                                            {{ optional($car->fileRatings->where('car_file_id', $file->id)->first())->rating == 'عالی' ? 'selected' : '' }}>
                                                            عالی
                                                        </option>
                                                    </select>
                                                </div>


                                            </div>
                                            <div class="modal-body">
                                                <div id="accordion{{ $file->id }}" class="accordion">
                                                    <div class="row">
                                                        @foreach ($file->items as $item)
                                                            @php
                                                                $old = $car->fileItemValues
                                                                    ->where('car_file_item_id', $item->id)
                                                                    ->first();
                                                            @endphp
                                                            <div class="col-lg-4">
                                                                <div class="card" style="margin: 5px">
                                                                    <div class="card-header p-0"
                                                                        id="heading{{ $item->id }}">
                                                                        <h5 class="mb-0">
                                                                            <button class="btn btn-success w-100 collapsed"
                                                                                type="button" data-toggle="collapse"
                                                                                data-target="#collapse{{ $item->id }}"
                                                                                aria-expanded="false"
                                                                                aria-controls="collapse{{ $item->id }}">
                                                                                {{ $item->title }}
                                                                            </button>
                                                                        </h5>
                                                                    </div>

                                                                    <div id="collapse{{ $item->id }}"
                                                                        class="collapse"
                                                                        aria-labelledby="heading{{ $item->id }}"
                                                                        data-parent="#accordion{{ $file->id }}">
                                                                        <div class="card-body border mt-1 p-1">
                                                                            <div class="form-group">
                                                                                <label>وضعیت</label>
                                                                                <select
                                                                                    name="car_file_items[{{ $item->id }}][status]"
                                                                                    class="form-control">
                                                                                    <option value="">-- انتخاب وضعیت
                                                                                        --</option>
                                                                                    <option value="سالم"
                                                                                        {{ optional($old)->status == 'سالم' ? 'selected' : '' }}>
                                                                                        سالم</option>
                                                                                    <option value="نامشخص"
                                                                                        {{ optional($old)->status == 'نامشخص' ? 'selected' : '' }}>
                                                                                        نامشخص</option>
                                                                                    <option value="رنگ شده"
                                                                                        {{ optional($old)->status == 'رنگ شده' ? 'selected' : '' }}>
                                                                                        رنگ شده</option>
                                                                                    <option value="تعویض و مشکل‌دار"
                                                                                        {{ optional($old)->status == 'تعویض و مشکل‌دار' ? 'selected' : '' }}>
                                                                                        تعویض و مشکل‌دار</option>
                                                                                    <option value="صافکاری بدون رنگ"
                                                                                        {{ optional($old)->status == 'صافکاری بدون رنگ' ? 'selected' : '' }}>
                                                                                        صافکاری بدون رنگ</option>
                                                                                    <option value="تعمیر شده"
                                                                                        {{ optional($old)->status == 'تعمیر شده' ? 'selected' : '' }}>
                                                                                        تعمیر شده</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>توضیحات (اختیاری)</label>
                                                                                <textarea name="car_file_items[{{ $item->id }}][status_description]" class="form-control" rows="2">{{ optional($old)->status_description }}</textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">بستن</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>




            </div>
        </div>
    </form>
@endsection

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.17.1/ckeditor.js"
        integrity="sha512-VXEKi5eNc7ECuyIueuledlqeUWiJ7hcxBe9fnsCiVzeZ0XwJxAPemnq01/LBIBnp3i0szhvKNd9Us7fqNPsRmQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        /* ---------- standardizeSlug (بدون تبدیل حروف) ---------- */
        function standardizeSlug(str) {
            return str.trim()
                .replace(/[^\p{L}\p{N}\s-]+/gu, '')
                .replace(/[\s-]+/g, '-')
                .replace(/^-+|-+$/g, '');
        }
        $(document).on('input', 'input[name="title"]', function() {
            $('input[name="slug"]').val(standardizeSlug($(this).val()));
        });


        /* ---------- CKEditor ---------- */
        CKEDITOR.replace('editor', {
            filebrowserImageBrowseUrl: '{{ route('media.manager.ckeditor') }}',
            filebrowserImageUploadUrl: '{{ route('media.store') }}',
            filebrowserWindowWidth: 1000,
            filebrowserWindowHeight: 600,
            height: 200,
            language: 'fa',
            contentsLangDirection: 'rtl',
        });

        /* ---------- ویژگی‌ها (همان منطق create) ---------- */
        let attributes = @json($attributes);
        let carAttributes = @json($car->attributeValues);

        function findAttribute(id) {
            return attributes.find(a => String(a.id) === String(id));
        }

        function makeAttributeSelect(rowKey, selectedId = '') {
            let options = '<option value="">-- انتخاب ویژگی --</option>';
            attributes.forEach(a => {
                let sel = selectedId && String(selectedId) === String(a.id) ? 'selected' : '';
                options += `<option value="${a.id}" data-type="${a.type}" ${sel}>${a.label}</option>`;
            });
            return `<select name="car_attributes[${rowKey}][attribute_id]" class="form-control attribute-select">${options}</select>`;
        }

        function makeValueInput(rowKey, attr, selectedValue = null, selectedLabel = null) {
            if (!attr) return '';
            if (attr.type === 'select') {
                if (!attr.values) return '';
                let hasSelected = false;
                let optionsHtml = attr.values.map(v => {
                    let checked = selectedValue && String(selectedValue) === String(v.id) ? 'checked' : '';
                    if (checked) hasSelected = true;
                    return `<div class="form-check">
                        <input class="form-check-input" type="radio" name="car_attributes[${rowKey}][value]" value="${v.id}" ${checked}>
                        <label class="form-check-label">${v.value}</label>
                    </div>`;
                }).join('');
                if (!hasSelected && attr.values.length > 0) {
                    optionsHtml = optionsHtml.replace(
                        'value="' + attr.values[0].id + '"',
                        'value="' + attr.values[0].id + '" checked'
                    );
                }
                return optionsHtml;
            } else if (['string', 'number', 'range'].includes(attr.type)) {
                return `<input type="text" name="car_attributes[${rowKey}][value]" class="form-control" value="${selectedValue ?? ''}">`;
            } else if (attr.type === 'boolean') {
                let labels = (attr.value_boolean_label ?? 'بله,خیر').split(',');
                let trueLabel = selectedLabel?.split(',')[0] ?? labels[0] ?? 'بله';
                let falseLabel = selectedLabel?.split(',')[1] ?? labels[1] ?? 'خیر';
                let checkedTrue = 'checked',
                    checkedFalse = '';
                if (selectedValue !== null) {
                    checkedTrue = (selectedValue === true || selectedValue === '1' || selectedValue === 1) ? 'checked' : '';
                    checkedFalse = (selectedValue === false || selectedValue === '0' || selectedValue === 0) ? 'checked' :
                        '';
                }
                return `
                <div class="form-check d-inline me-2">
                    <input class="form-check-input" type="radio" name="car_attributes[${rowKey}][value]" value="1" ${checkedTrue}>
                    <label class="form-check-label boolean-label" data-row="${rowKey}" data-value="1">${trueLabel}</label>
                </div>
                <div class="form-check d-inline">
                    <input class="form-check-input" type="radio" name="car_attributes[${rowKey}][value]" value="0" ${checkedFalse}>
                    <label class="form-check-label boolean-label" data-row="${rowKey}" data-value="0">${falseLabel}</label>
                </div>
                <input type="hidden" name="car_attributes[${rowKey}][value_boolean_label]" class="boolean-label-input" value="${trueLabel},${falseLabel}">`;
            }
            return '';
        }

        function addAttributeRow(prefill = null) {
            let rowKey = Date.now() + Math.floor(Math.random() * 1000);
            let selectedAttrId = prefill ? prefill.attribute_id : '';
            let selectedValue = prefill ? prefill.value : null;
            let selectedLabel = prefill ? prefill.value_boolean_label : null;
            let row = $(`<div class="attribute-row mt-2 col-lg-6" data-row="${rowKey}">
                <div class="border rounded-lg p-1">
                    <div class="d-flex justify-content-between mb-2">
                        <strong>ویژگی</strong>
                        <button type="button" class="btn btn-sm btn-danger remove-attribute">حذف</button>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">${makeAttributeSelect(rowKey, selectedAttrId)}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group attribute-value" data-row="${rowKey}"></div>
                        </div>
                    </div>
                </div>
            </div>`);
            $("#attributes-container").append(row);
            if (selectedAttrId) {
                let attr = findAttribute(selectedAttrId);
                if (attr) {
                    let html = makeValueInput(rowKey, attr, selectedValue, selectedLabel);
                    row.find('.attribute-value').html(html);
                }
            }
        }

        $(document).ready(function() {
            /* بارگذاری ویژگی‌های قبلی خودرو */
            carAttributes.forEach(function(attr) {
                let value = attr.attribute_value_id ?? attr.value_string ?? attr.value_number ?? (attr
                    .value_boolean !== null ? (attr.value_boolean ? '1' : '0') : null);
                let label = attr.value_boolean_label;
                addAttributeRow({
                    attribute_id: attr.attribute_id,
                    value: value,
                    value_boolean_label: label
                });
            });

            $('#add-attribute').on('click', function(e) {
                e.preventDefault();
                addAttributeRow();
            });

            $(document).on('click', '.remove-attribute', function() {
                $(this).closest('.attribute-row').remove();
            });

            $(document).on('change', '.attribute-select', function() {
                let rowDiv = $(this).closest('.attribute-row');
                let rowKey = rowDiv.data('row');
                let attrId = $(this).val();

                let duplicate = false;
                $('.attribute-select').not(this).each(function() {
                    if ($(this).val() === attrId && attrId !== "") duplicate = true;
                });
                if (duplicate) {
                    alert('این ویژگی قبلاً انتخاب شده است');
                    $(this).val("");
                    rowDiv.find('.attribute-value').html('');
                    return;
                }

                let attr = findAttribute(attrId);
                let container = rowDiv.find('.attribute-value');
                container.html('');
                if (!attr) return;
                container.html(makeValueInput(rowKey, attr));
            });

            // مدیریت تغییر برند - بارگذاری ویژگی‌ها
            $('#brand_id').change(function() {
                var brandId = $(this).val();
                var $modelSelect = $('#car_model_id');

                if (brandId) {
                    // نمایش loading
                    $modelSelect.html('<option value="">در حال بارگذاری...</option>');

                    // درخواست AJAX برای دریافت مدل‌ها
                    $.ajax({
                        url: '{{ route('brands.models', ':brand') }}'.replace(':brand', brandId),
                        type: 'GET',
                        success: function(data) {
                            $modelSelect.html('<option value="">انتخاب مدل</option>');
                            $.each(data, function(key, model) {
                                $modelSelect.append(
                                    '<option value="' + model.id + '">' + model
                                    .title + '</option>'
                                );
                            });
                        },
                        error: function() {
                            $modelSelect.html('<option value="">خطا در بارگذاری</option>');
                        }
                    });

                    // درخواست AJAX برای دریافت ویژگی‌های برند
                    $.ajax({
                        url: '/api/brands/' + brandId + '/attributes',
                        type: 'GET',
                        success: function(data) {
                            // به‌روزرسانی متغیر global attributes
                            attributes = data;

                            // پاک کردن کانتینر ویژگی‌ها
                            $("#attributes-container").html('');

                            // اگر ویژگی‌هایی وجود داشت، یک ردیف خالی اضافه کن
                            if (attributes.length > 0) {
                                addAttributeRow();
                            } else {
                                $("#attributes-container").html('<p class="text-muted">هیچ ویژگی برای این برند تعریف نشده است.</p>');
                            }
                        },
                        error: function() {
                            console.error('خطا در بارگذاری ویژگی‌ها');
                            $("#attributes-container").html('<p class="text-danger">خطا در بارگذاری ویژگی‌ها</p>');
                        }
                    });
                } else {
                    $modelSelect.html('<option value="">ابتدا برند را انتخاب کنید</option>');
                    $("#attributes-container").html('');
                    attributes = [];
                }
            });

            // بارگذاری اولیه ویژگی‌ها بر اساس برند فعلی
            $(document).ready(function() {
                var currentBrandId = $('#brand_id').val();
                if (currentBrandId) {
                    // درخواست AJAX برای دریافت ویژگی‌های برند فعلی
                    $.ajax({
                        url: '/api/brands/' + currentBrandId + '/attributes',
                        type: 'GET',
                        success: function(data) {
                            // به‌روزرسانی متغیر global attributes
                            attributes = data;

                            // پاک کردن کانتینر ویژگی‌ها
                            $("#attributes-container").html('');

                            // بارگذاری ویژگی‌های قبلی خودرو
                            carAttributes.forEach(function(attr) {
                                let value = attr.attribute_value_id ?? attr.value_string ?? attr.value_number ?? (attr
                                    .value_boolean !== null ? (attr.value_boolean ? '1' : '0') : null);
                                let label = attr.value_boolean_label;
                                addAttributeRow({
                                    attribute_id: attr.attribute_id,
                                    value: value,
                                    value_boolean_label: label
                                });
                            });

                            // اگر هیچ ویژگی قبلی وجود نداشت و ویژگی‌هایی برای برند موجود است، یک ردیف خالی اضافه کن
                            if (carAttributes.length === 0 && attributes.length > 0) {
                                addAttributeRow();
                            }
                        },
                        error: function() {
                            console.error('خطا در بارگذاری ویژگی‌ها');
                            $("#attributes-container").html('<p class="text-danger">خطا در بارگذاری ویژگی‌ها</p>');
                        }
                    });
                }
            });

            $(document).on('click', '.boolean-label', function() {
                let label = $(this);
                let currentText = label.text();
                let input = $(
                    `<input type="text" class="form-control form-control-sm boolean-label-edit" value="${currentText}">`
                );
                label.hide().after(input);
                input.focus().on('blur', function() {
                    let newText = $(this).val() || currentText;
                    label.text(newText).show();
                    $(this).remove();
                    let rowKey = label.data('row');
                    let allLabels = [];
                    label.closest('.attribute-value').find('.boolean-label').each(function() {
                        allLabels.push($(this).text());
                    });
                    label.closest('.attribute-value').find('.boolean-label-input').val(allLabels
                        .join(','));
                });
            });

            $('#car-form').on('submit', function() {
                $('.attribute-value').each(function() {
                    let labels = [];
                    $(this).find('.boolean-label').each(function() {
                        labels.push($(this).text());
                    });
                    $(this).find('.boolean-label-input').val(labels.join(','));
                });
            });


        });
    </script>
@endpush
