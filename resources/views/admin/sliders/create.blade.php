@extends('admin.layout')
@section('title', 'ایجاد اسلاید جدید')

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

    <form method="POST" action="{{ route('sliders.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">اطلاعات اسلاید</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="title">عنوان اسلاید</label>
                                    <input type="text" name="title" id="title" placeholder="عنوان اسلاید"
                                        class="form-control" value="{{ old('title') }}" required>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="link">لینک</label>
                                    <input type="url" name="link" id="link" placeholder="لینک"
                                        class="form-control" value="{{ old('link') }}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="order">ترتیب نمایش</label>
                                    <input type="number" name="order" id="order" placeholder="ترتیب"
                                        class="form-control" value="{{ old('order', 0) }}" required>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="image">تصویر اسلاید</label>
                                    <x-media-picker name="image" id="image" value="{{ old('image') }}" required />
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" value="1" class="form-check-input" id="is_active" name="is_active"
                                            {{ old('is_active') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">اسلاید فعال باشد</label>
                                    </div>
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