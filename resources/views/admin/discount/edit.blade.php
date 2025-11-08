@extends('admin.layout')
@section('title', 'ویرایش کد تخفیف')
@section('actions')
    <a href="{{ route('discounts.index') }}" class="btn btn-primary btn-sm btn-icon-split">
        <span class="text-white-50">
            <i class="fas fa-arrow-right"></i>
        </span>
        <span class="text">برگشت</span>
    </a>
@endsection

@push('style')
    <link type="text/css" rel="stylesheet" href="{{ asset('admin/plugins/JalaliDatePicker/jalalidatepicker.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/plugins/select2/dist/css/select2.min.css') }}">
@endpush

@section('content')

    @session('success')
        <script>
            notifier.success('{{ session('success') }}', {
                labels: {
                    success: 'تبریک'
                },
            })
        </script>
    @endsession

    <form action="{{ route('discounts.update', $discount->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">ویرایش کد تخفیف</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            {{-- دسترسی --}}
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="access">نوع دسترسی</label>
                                    <select name="access" id="access"
                                        class="form-control @error('access') is-invalid @enderror">
                                        <option value="public" {{ $discount->access === 'public' ? 'selected' : '' }}>عمومی
                                        </option>
                                        <option value="private" {{ $discount->access === 'private' ? 'selected' : '' }}>
                                            خصوصی
                                        </option>
                                    </select>
                                    @error('access')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- کاربران --}}
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="user_ids">شامل کاربران</label>
                                    <select name="user_ids[]" id="user_ids"
                                        class="form-control select2 @error('user_ids') is-invalid @enderror" multiple>
                                        @foreach ($users as $user)
                                            @if (optional($user->document)->first_name)
                                                <option value="{{ $user->id }}"
                                                    {{ !empty($discount->user_ids) && in_array($user->id, $discount->user_ids) ? 'selected' : '' }}>
                                                    {{ optional($user->document)->first_name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('user_ids')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- محدودیت استفاده --}}
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="limitdiscount">تعداد دفعات مجاز استفاده</label>
                                    <select name="limitdiscount" id="limitdiscount"
                                        class="form-control @error('limitdiscount') is-invalid @enderror">
                                        <option value="0" {{ $discount->limitdiscount == 0 ? 'selected' : '' }}>
                                            نامحدود
                                        </option>
                                        @for ($i = 1; $i <= 10; $i++)
                                            <option value="{{ $i }}"
                                                {{ $discount->limitdiscount == $i ? 'selected' : '' }}>
                                                {{ $i }}</option>
                                        @endfor
                                    </select>
                                    @error('limitdiscount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- عنوان --}}
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="title">عنوان</label>
                                    <input type="text" name="title" id="title"
                                        value="{{ old('title', $discount->title) }}" placeholder="عنوان"
                                        class="form-control @error('title') is-invalid @enderror">
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- کد تخفیف --}}
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="code">کد تخفیف</label>
                                    <input type="text" name="code" id="code"
                                        value="{{ old('code', $discount->code) }}" placeholder="کد تخفیف"
                                        class="form-control @error('code') is-invalid @enderror">
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- نوع تخفیف --}}
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="type">نوع تخفیف</label>
                                    <select name="type" id="type"
                                        class="form-control @error('type') is-invalid @enderror">
                                        <option value="amount"
                                            {{ $discount->getRawOriginal('type') === 'amount' ? 'selected' : '' }}>
                                            مبلغی</option>
                                        <option value="percent"
                                            {{ $discount->getRawOriginal('type') === 'percent' ? 'selected' : '' }}>درصدی
                                        </option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- مقدار عددی --}}
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="amount">مبلغ</label>
                                    <input type="number" name="amount" id="amount"
                                        value="{{ old('amount', $discount->amount) }}" placeholder="مبلغ"
                                        class="form-control @error('amount') is-invalid @enderror">
                                    @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- درصد --}}
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="percent">درصد</label>
                                    <input type="number" name="percent" id="percent"
                                        value="{{ old('percent', $discount->percent) }}" placeholder="درصد"
                                        class="form-control @error('percent') is-invalid @enderror">
                                    @error('percent')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- تاریخ انقضا --}}
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="expiration">تاریخ انقضا</label>
                                    <input data-jdp name="expiration" id="expiration"
                                        value="{{ old('expiration', \Morilog\Jalali\Jalalian::fromDateTime($discount->expiration)->format('Y/m/d')) }}"
                                        class="form-control text-right @error('expiration') is-invalid @enderror"
                                        placeholder="تاریخ انقضا">
                                    @error('expiration')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- وضعیت --}}
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="status">وضعیت</label>
                                    <select name="status" id="status"
                                        class="form-control @error('status') is-invalid @enderror">
                                        <option value="disable"
                                            {{ $discount->getRawOriginal('status') === 'disable' ? 'selected' : '' }}>
                                            غیرفعال
                                        </option>
                                        <option value="enable"
                                            {{ $discount->getRawOriginal('status') === 'enable' ? 'selected' : '' }}>فعال
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success btn-sm btn-icon-split">
                            ذخیره
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('script')
    <script src="{{ asset('admin/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('admin/select2/dist/js/i18n/fa.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/plugins/JalaliDatePicker/jalalidatepicker.min.js') }}"></script>
    <script>
        jalaliDatepicker.startWatch({
            minDate: "today",
            persianDigits: true
        });
        $(".select2").select2({
            rtl: true
        });
    </script>
@endpush
