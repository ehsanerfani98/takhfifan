@extends('admin.layout')
@section('title', 'ایجاد نقش جدید')


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

    <form method="POST" action="{{ route('roles.store') }}">
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">اطلاعات نقش</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="">نام</label>
                                <input type="text" name="name" placeholder="نام" class="form-control" value="">
                            </div>
                            <div class="col-lg-6">
                                <label for="">عنوان</label>
                                <input type="text" name="title" placeholder="عنوان" class="form-control"
                                    value="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">مجوزها</h6>
                    </div>
                    <div class="card-body">
                            <div class="row">
                                @foreach ($permission as $value)
                                    <div class="col-lg-3 mb-2">
                                        <label><input type="checkbox" name="permission[{{ $value->id }}]"
                                                value="{{ $value->id }}" class="name">
                                            {{ $value->title }}</label>
                                    </div>
                                @endforeach
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
