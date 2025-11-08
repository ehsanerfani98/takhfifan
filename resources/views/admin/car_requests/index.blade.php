@extends('admin.layout')
@section('title', 'مدیریت درخواست‌های ماشین')

@section('content')

    @session('error')
        <script>
            notifier.alert('{{ session('error') }}', {
                labels: {
                    alert: 'خطا'
                },
            })
        </script>
    @endsession

    @session('success')
        <script>
            notifier.success('{{ session('success') }}', {
                labels: {
                    success: 'تبریک'
                },
            })
        </script>
    @endsession

    <div class="row">
        <div class="col-12">
            <div class="px-2 d-flex align-items-center justify-content-between">
                <h5 class="text-bold-700 my-2 text-white">لیست درخواست‌های ماشین</h5>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped compact dataTable" id="recent-project-table"
                            style="text-align: center;">
                            <thead>
                                <tr>
                                    <th>شناسه</th>
                                    <th>کاربر</th>
                                    <th>نوع درخواست</th>
                                    <th>ماشین</th>
                                    <th>وضعیت</th>
                                    <th>تاریخ ایجاد</th>
                                    <th>اقدامات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carRequests as $carRequest)
                                    <tr>
                                        <td>{{ $carRequest->id }}</td>
                                        <td>
                                            @if ($carRequest->user)
                                                {{ $carRequest->user->name ?? $carRequest->user->email }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($carRequest->type == 'sell')
                                                <span class="badge badge-success">فروش</span>
                                            @elseif ($carRequest->type == 'carinspection')
                                                <span class="badge badge-primary">کارشناسی خودرو</span>
                                            @else
                                                <span class="badge badge-info">خرید</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($carRequest->car)
                                                <a href="{{ route('car', $carRequest->car->slug)}}" target="_blank" rel="noopener noreferrer">{{ $carRequest->car->title ?? '' }}</a>
                                            @else
                                                -
                                            @endif
                                        </td>
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
                                        <td>{{ jdate($carRequest->created_at)->format('Y/m/d H:i') }}</td>
                                        <td>
                                            @can('car-request-view')
                                                <a href="{{ route('car-requests.show', $carRequest->id) }}" class="btn btn-info btn-sm">
                                                    جزئیات
                                                </a>
                                            @endcan
                                            @can('car-request-edit')
                                                <a href="{{ route('car-requests.edit', $carRequest->id) }}" class="btn btn-primary btn-sm">
                                                    ویرایش
                                                </a>
                                            @endcan
                                            @can('car-request-delete')
                                                <form method="POST" action="{{ route('car-requests.destroy', $carRequest->id) }}"
                                                    style="display:inline-block"
                                                    onsubmit="return confirm('آیا از حذف درخواست مطمئن هستید؟')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        حذف
                                                    </button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {!! $carRequests->links('pagination::bootstrap-5') !!}

@endsection