@extends('admin.layout')
@section('title', 'تاریخچه کیف پول')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">موجودی کیف پول</h6>
        </div>
        <div class="card-body">
            {{ number_format(walletBalance($user)) }} ریال
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">تراکنش‌های کیف پول</h6>
        </div>
        <div class="card-body">

            @if ($transactions->isEmpty())
                <div class="text-center alert alert-warning" role="alert">
                    هیچ تراکنشی یافت نشد
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>تاریخ</th>
                                <th>نوع تراکنش</th>
                                <th>مبلغ</th>
                                <th>توضیحات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $tx)
                                <tr>
                                    <td>{{ jdate($tx->created_at)->format('Y/m/d H:i') }}</td>
                                    <td>
                                        @if ($tx->type === 'credit')
                                            <span class="badge badge-success">واریز</span>
                                        @elseif ($tx->type === 'debit')
                                            <span class="badge badge-danger">برداشت</span>
                                        @else
                                            <span class="badge badge-secondary">{{ $tx->type }}</span>
                                        @endif
                                    </td>
                                    <td class="{{ $tx->type === 'credit' ? 'text-success' : 'text-danger' }}">
                                        {{ number_format($tx->amount) }} تومان
                                    </td>
                                    <td>{{ $tx->description ?? '---' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- صفحه‌بندی --}}
                <div class="d-flex justify-content-center mt-4">
                    {{ $transactions->links('vendor.pagination.bootstrap-5') }}
                </div>
            @endif

        </div>
    </div>
@endsection
