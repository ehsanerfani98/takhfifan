@extends('admin.layout')
@section('title', 'مدیریت اشتراک‌ها')

@section('actions')
    <a href="{{ route('subscriptions.create') }}" class="btn btn-success btn-sm">
        <span class="text-white-50">
            <i class="fas fa-plus"></i>
        </span>
        ایجاد اشتراک جدید
    </a>
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">لیست اشتراک ها</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>شناسه</th>
                        <th>نام</th>
                        <th>قیمت</th>
                        <th>مدت (روز)</th>
                        <th>اقدامات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subscriptions as $subscription)
                        <tr>
                            <td>{{ $subscription->id }}</td>
                            <td>{{ $subscription->name }}</td>
                            <td>{{ number_format($subscription->price) }} ریال</td>
                            <td>{{ $subscription->duration_days }}</td>
                            <td>
                                <span class="badge badge-{{ $subscription->is_active ? 'success' : 'secondary' }}">
                                    {{ $subscription->is_active ? 'فعال' : 'غیرفعال' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('subscriptions.edit', $subscription->id) }}"
                                    class="btn btn-primary btn-sm btn-icon-split">
                                    <span class="text-white-50">
                                        <i class="fas fa-edit"></i>
                                    </span>
                                    <span class="text">ویرایش</span>
                                </a>

                                <form action="{{ route('subscriptions.destroy', $subscription->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm btn-icon-split" onclick="return confirm('آیا مطمئن هستید؟')">
                                        <span class="text-white-50">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                        <span class="text">حذف</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {!! $subscriptions->links() !!}
@endsection
