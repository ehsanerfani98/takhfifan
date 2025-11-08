@extends('admin.layout')
@section('title', 'ویرایش درخواست ماشین')

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

    <form method="POST" action="{{ route('car-requests.update', $carRequest->id) }}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">اطلاعات درخواست</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="user_id">کاربر</label>
                                    <p>{{$carRequest->user->phone}}</p>
                                    <input type="hidden" name="user_id" value="{{$carRequest->user->id}}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="type">نوع درخواست</label>
                                    <p>{{ $carRequest->type == 'sell' ? 'فروش' : 'خرید' }}</p>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="car_id">ماشین</label>
                                    <p>{{$carRequest->car->title ?? '-'}}</p>
                                    <input type="hidden" name="car_id" value="{{$carRequest->car->id ?? null}}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="status">وضعیت</label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="در حال بررسی" {{ $carRequest->status == 'در حال بررسی' ? 'selected' : '' }}>در حال بررسی</option>
                                        <option value="تایید شد" {{ $carRequest->status == 'تایید شد' ? 'selected' : '' }}>تایید شد</option>
                                        <option value="رد شد" {{ $carRequest->status == 'رد شد' ? 'selected' : '' }}>رد شد</option>
                                        <option value="انجام شد" {{ $carRequest->status == 'انجام شد' ? 'selected' : '' }}>انجام شد</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                                                    @if ($carRequest->data && !empty($carRequest->data))
                            <h6>اطلاعات ثبت شده در درخواست:</h6>
                                    <table class="table table-bordered table-striped table-sm">
                                        <tbody>
                                            <tr>
                                                <th width="30%">برند</th>
                                                <td>{{ $carRequest->data['brand'] ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>مدل</th>
                                                <td>{{ $carRequest->data['model'] ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>سال ساخت</th>
                                                <td>{{ $carRequest->data['year'] ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>تیپ</th>
                                                <td>{{ $carRequest->data['type'] ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>رنگ</th>
                                                <td>{{ $carRequest->data['color'] ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>کارکرد</th>
                                                <td>
                                                    {{-- برای خوانایی بهتر، عدد کارکرد را با جداکننده نمایش می‌دهیم --}}
                                                    {{ number_format($carRequest->data['kilometer'] ?? 0) }} کیلومتر
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                    @endif

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

@endpush