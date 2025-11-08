@extends('admin.layout')
@section('title', 'جزئیات درخواست ماشین')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">جزئیات درخواست ماشین</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">شناسه</th>
                                    <td>{{ $carRequest->id }}</td>
                                </tr>
                                <tr>
                                    <th>کاربر</th>
                                    <td>
                                        @if ($carRequest->user)
                                            {{ $carRequest->user->name ?? $carRequest->user->email }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>نوع درخواست</th>
                                    <td>
                                        @if ($carRequest->type == 'sell')
                                            <span class="badge badge-success">فروش</span>
                                        @elseif ($carRequest->type == 'carinspection')
                                            <span class="badge badge-primary">کارشناسی خودرو</span>
                                        @else
                                            <span class="badge badge-info">خرید</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>ماشین</th>
                                    <td>
                                        @if ($carRequest->car)
                                            <a href="{{ route('car', $carRequest->car->slug) }}" target="_blank"
                                                rel="noopener noreferrer">{{ $carRequest->car->title ?? '' }}</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">وضعیت</th>
                                    <td>
                                        @switch($carRequest->status)
                                            @case('در حال بررسی')
                                                <span class="badge badge-warning">{{ $carRequest->status }}</span>
                                            @break

                                            @case('تایید شد')
                                                <span class="badge badge-success">{{ $carRequest->status }}</span>
                                            @break

                                            @case('رد شد')
                                                <span class="badge badge-danger">{{ $carRequest->status }}</span>
                                            @break

                                            @case('انجام شد')
                                                <span class="badge badge-primary">{{ $carRequest->status }}</span>
                                            @break

                                            @default
                                                <span class="badge badge-secondary">{{ $carRequest->status }}</span>
                                        @endswitch
                                    </td>
                                </tr>
                                <tr>
                                    <th>تاریخ ایجاد</th>
                                    <td>{{ jdate($carRequest->created_at)->format('Y/m/d H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>تاریخ به‌روزرسانی</th>
                                    <td>{{ jdate($carRequest->updated_at)->format('Y/m/d H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if ($carRequest->data && !empty($carRequest->data))
                        <div class="mt-4">
                            <h6>اطلاعات ثبت شده در درخواست:</h6>
                            <div class="card">
                                <div class="card-body">
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
                                            <tr>
                                                <th>تاریخ مراجعه</th>
                                                <td>{{ isset($carRequest->data['visit_date']) ? jdate($carRequest->data['visit_date'])->format('Y/m/d') : '-' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>زمان مراجعه</th>
                                                <td>{{ $carRequest->data['visit_time'] ?? '-' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="mt-4">
                        @can('car-request-edit')
                            <a href="{{ route('car-requests.edit', $carRequest->id) }}" class="btn btn-primary btn-sm">
                                ویرایش
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
