@extends('admin.layout')
@section('title', 'اشتراک‌های من')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">لیست اشتراک‌ها</h6>
        </div>
        <div class="card-body">

            @if ($subscriptions->isEmpty())
                <div class="text-center alert alert-warning" role="alert">
                    هیچ اشتراکی یافت نشد
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>عنوان پلن</th>
                                <th>مدت</th>
                                <th>تاریخ شروع</th>
                                <th>تاریخ پایان</th>
                                <th>زمان باقی‌مانده</th>
                                <th>وضعیت</th>
                                <th>تاریخ ثبت</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subscriptions as $sub)
                                <tr>
                                    <td>{{ $sub->plan_title }}</td>
                                    <td>{{ $sub->duration_days }}</td>
                                    <td>{{ jdate($sub->start_date)->format('Y/m/d') }}</td>
                                    <td>{{ jdate($sub->end_date)->format('Y/m/d') }}</td>
                                    <td>{{ $sub->remaining_time }}</td>
                                    <td>
                                        @if ($sub->status === 'active')
                                            <span class="badge badge-success">فعال</span>
                                        @else
                                            <span class="badge badge-secondary">منقضی شده</span>
                                        @endif
                                    </td>
                                    <td>{{ jdate($sub->created_at)->format('Y/m/d H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- صفحه‌بندی --}}
                <div class="d-flex justify-content-center mt-4">
                    {{ $subscriptions->links('vendor.pagination.bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
@endsection
