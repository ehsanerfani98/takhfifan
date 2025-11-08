@extends('admin.layout')
@section('title', 'محدودیت‌های روزانه کاربر')
@section('actions')
    <a href="{{ route('users.index') }}" class="btn btn-primary btn-sm btn-icon-split">
        <span class="text-white-50">
            <i class="fas fa-arrow-right"></i>
        </span>
        <span class="text">برگشت</span>
    </a>
@endsection
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">محدودیت‌های روزانه - {{ $user->phone }}</h6>
        </div>
        <div class="card-body">
            @if ($limits->count())
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>تاریخ</th>
                            <th>تعداد جستجوها</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($limits as $limit)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($limit->date)->format('Y/m/d') }}</td>
                                <td>{{ $limit->searches_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-info">هیچ محدودیتی برای این کاربر ثبت نشده است.</div>
            @endif
        </div>
    </div>
@endsection