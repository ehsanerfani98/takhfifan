@extends('admin.layout')
@section('title', 'مدیریت درخواست‌ خدمات')

@section('actions')
    <div class="btn-group">
        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            فیلتر وضعیت‌ها
        </button>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{ route('service-requests.index') }}">همه درخواست‌ها</a>
            @foreach (\App\Enums\ServiceRequestStatusEnum::cases() as $status)
                <a class="dropdown-item" href="{{ route('service-requests.index', ['status' => $status->value]) }}">
                    {{ $status->label() }}
                </a>
            @endforeach
        </div>
    </div>
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">لیست درخواست‌ خدمات</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>کاربر</th>
                            <th>خدمات</th>
                            <th>توضیحات</th>
                            <th>وضعیت</th>
                            <th>تاریخ درخواست</th>
                            <th>اقدامات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($serviceRequests as $request)
                            <tr>
                                <td>
                                    <a target="_blank" href="{{ route('documents.show', $request->user_id) }}">
                                        {{ optional($request->user->document)->first_name . ' ' . optional($request->user->document)->last_name }}
                                    </a>
                                </td>
                                <td>{{ $request->service->name }}</td>
                                <td>{{ Str::limit($request->description, 50) }}</td>
                                <td>
                                    <span class="badge badge-{{ $request->status->badgeClass() }}">
                                        {{ $request->status_label }}
                                    </span>
                                </td>
                                <td>{{ jdate($request->created_at)->format('Y/m/d H:i') }}</td>
                                <td>
                                    <a href="{{ route('service-requests.edit', $request->id) }}"
                                        class="btn btn-primary btn-sm btn-icon-split">
                                        <span class="text-white-50">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                        <span class="text">ویرایش</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">هیچ درخواست خدماتی یافت نشد</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {!! $serviceRequests->appends(request()->query())->links() !!}
@endsection
