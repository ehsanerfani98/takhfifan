@extends('admin.layout')
@section('title', 'ویرایش بنر')

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

    <form method="POST" action="{{ route('banners.update', $banner->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">اطلاعات بنر</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="title">عنوان بنر</label>
                                    <textarea name="title" class="form-control" id="editor">{{ old('title', $banner->title) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" value="1" class="form-check-input" id="is_active"
                                            name="is_active" {{ old('is_active', $banner->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">بنر فعال باشد</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="link">لینک</label>
                                            <input type="url" name="link" id="link" placeholder="لینک"
                                                class="form-control" value="{{ old('link', $banner->link) }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="order">ترتیب نمایش</label>
                                            <input type="number" name="order" id="order" placeholder="ترتیب"
                                                class="form-control" value="{{ old('order', $banner->order) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="thumbnail">تصویر اصلی</label>
                                            <x-media-picker name="thumbnail" id="thumbnail"
                                                value="{{ old('thumbnail', $banner->thumbnail) }}" />
                                            @if ($banner->thumbnail)
                                                <small class="form-text text-muted">
                                                    تصویر فعلی:
                                                    <a href="{{ asset($banner->thumbnail) }}" target="_blank"
                                                        class="mr-2">مشاهده
                                                        تصویر</a>
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="cover">تصویر پوشاننده</label>
                                            <x-media-picker name="cover" id="cover"
                                                value="{{ old('cover', $banner->cover) }}" />
                                            @if ($banner->cover)
                                                <small class="form-text text-muted">
                                                    تصویر فعلی:
                                                    <a href="{{ asset($banner->cover) }}" target="_blank"
                                                        class="mr-2">مشاهده
                                                        تصویر</a>
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-xs-12 col-sm-12 col-md-12 text-left">
                                <button type="submit" class="btn btn-success btn-sm">
                                    ذخیره
                                </button>
                            </div>
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
        CKEDITOR.replace('editor', {
            height: 200,
            language: 'fa',
            contentsLangDirection: 'rtl',
            toolbar: 'Full',
            extraPlugins: 'colorbutton',
            colorButton_enableMore: true
        });
    </script>
@endpush
