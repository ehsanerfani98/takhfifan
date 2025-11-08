@extends('admin.layout')
@section('title', 'ایجاد ویژگی')

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

    <form action="{{ route('attributes.store') }}" method="POST">
        @csrf
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
                                    <label>نام (انگلیسی)</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>نامک</label>
                                    <input type="text" name="slug" class="form-control" value="{{ old('slug') }}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>لیبل (نمایشی)</label>
                                    <input type="text" name="label" class="form-control" value="{{ old('label') }}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>آیکن</label>
                                    <input type="text" placeholder="fas fa-tachometer-alt" name="icon" class="form-control" value="{{ old('icon') }}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>نوع</label>
                                    <select name="type" class="form-control">
                                        <option value="string">String</option>
                                        <option value="number">Number</option>
                                        <option value="boolean">Boolean</option>
                                        <option value="select">Select</option>
                                        <option value="range">Range</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>ترتیب</label>
                                    <input type="number" name="sort_order" class="form-control"
                                        value="">
                                </div>
                            </div>



                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" name="is_active" class="form-check-input" value="1"
                                            checked>
                                        <label class="form-check-label">فعال</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" name="format_thousands" id="format_thousands" class="form-check-input" value="1">
                                        <label for="format_thousands" class="form-check-label">جدا کننده ارقام (برای مقادیری مانند قیمت)</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" name="show_in_card" id="show_in_card" class="form-check-input" value="1">
                                        <label for="show_in_card" class="form-check-label">نمایش در کارت ماشین</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" name="is_filter" id="is_filter" class="form-check-input" value="1">
                                        <label for="is_filter" class="form-check-label">استفاده به عنوان فیلتر</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" name="is_multiple" class="form-check-input" value="1">
                                        <label class="form-check-label">چند مقداری</label>
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
