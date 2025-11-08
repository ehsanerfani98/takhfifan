@extends('admin.layout')
@section('title', 'ویرایش ویژگی')

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



    <form action="{{ route('attributes.update', $attribute->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">اطلاعات ویژگی</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>نام</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ $attribute->name }}">
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>نامک</label>
                                    <input type="text" name="slug" class="form-control"
                                        value="{{ $attribute->slug }}">
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>لیبل</label>
                                    <input type="text" name="label" class="form-control"
                                        value="{{ $attribute->label }}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>آیکن</label>
                                    <input type="text" placeholder="fas fa-tachometer-alt" name="icon"
                                        class="form-control" value="{{ $attribute->icon }}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>نوع</label>
                                    <select name="type" class="form-control">
                                        <option value="string" {{ $attribute->type == 'string' ? 'selected' : '' }}>String
                                        </option>
                                        <option value="number" {{ $attribute->type == 'number' ? 'selected' : '' }}>Number
                                        </option>
                                        <option value="boolean" {{ $attribute->type == 'boolean' ? 'selected' : '' }}>
                                            Boolean</option>
                                        <option value="select" {{ $attribute->type == 'select' ? 'selected' : '' }}>Select
                                        </option>
                                        <option value="range" {{ $attribute->type == 'range' ? 'selected' : '' }}>Range
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>ترتیب</label>
                                    <input type="number" name="sort_order" class="form-control"
                                        value="{{ $attribute->sort_order }}">
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" name="is_active" class="form-check-input" id="is_active"
                                            value="1" {{ $attribute->is_active ? 'checked' : '' }}>
                                        <label for="is_active" class="form-check-label">فعال</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" name="format_thousands" id="format_thousands" class="form-check-input"
                                            value="1" {{ $attribute->format_thousands ? 'checked' : '' }}>
                                        <label for="format_thousands" class="form-check-label">جدا کننده ارقام (برای مقادیری مانند قیمت)</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" name="show_in_card" id="show_in_card" class="form-check-input" value="1"
                                            {{ $attribute->show_in_card ? 'checked' : '' }}>
                                        <label for="show_in_card" class="form-check-label">نمایش در کارت ماشین</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" name="is_filter" id="is_filter" class="form-check-input" value="1"
                                            {{ $attribute->is_filter ? 'checked' : '' }}>
                                        <label for="is_filter" class="form-check-label">استفاده به عنوان فیلتر</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" name="is_multiple" class="form-check-input" id="is_multiple"
                                            value="1" {{ $attribute->is_multiple ? 'checked' : '' }}>
                                        <label for="is_multiple" class="form-check-label">چند مقداری</label>
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
