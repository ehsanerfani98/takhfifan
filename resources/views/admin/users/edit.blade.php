@extends('admin.layout')
@section('title', 'ویرایش نقش')

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


    <form method="POST" action="{{ route('users.update', $user->id) }}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">اطلاعات کاربری</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            {{-- <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <strong>نام و نام خانوادگی</strong>
                                    <input type="text" name="name" placeholder="نام و نام خانوادگی" class="form-control"
                                        value="{{ $user->name }}">
                                </div>
                            </div>
                           --}}


                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="email">ایمیل</label>
                                    <input type="email" name="email" id="email" placeholder="ایمیل"
                                        class="form-control" value="{{ $user->email }}">
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="phone">شماره موبایل</label>
                                    <input type="phone" name="phone" id="phone" placeholder="شماره موبایل"
                                        class="form-control" value="{{ $user->phone }}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="password">رمز عبور</label>
                                    <input type="password" name="password" id="password" placeholder="رمز عبور"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="confirm-password">تایید رمز عبور</label>
                                    <input type="password" name="confirm-password" id="confirm-password"
                                        placeholder="تایید رمز عبور" class="form-control">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="roles">نقش</label>
                                    <select name="roles[]" id="roles" class="form-control select2" multiple="multiple">
                                        @foreach ($roles as $value => $label)
                                            <option value="{{ $value }}"
                                                {{ isset($userRole[$value]) ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
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
        $(".select2").select2({
            rtl: true,
            placeholder:"یک نقش کاربری انتخاب کنید",
        });
    </script>
@endpush
