@extends('admin.layout')
@section('title', 'تراکنش‌های کاربر')

@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">لیست تراکنش‌ها</h6>
        </div>
        <div class="card-body">
            @if ($payments->isEmpty())
                <div class="alert alert-warning text-center">
                    هیچ تراکنشی یافت نشد.
                </div>
            @else
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>تاریخ</th>
                            <th>مبلغ</th>
                            <th>توضیحات</th>
                            <th>وضعیت</th>
                            <th>نوع</th>
                            <th>کد رهگیری</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $index => $payment)
                            @php
                                $statusClass = match ($payment->status) {
                                    'paid' => 'success',
                                    'failed' => 'danger',
                                    'pending' => 'warning',
                                    default => 'secondary',
                                };
                                $typeLabel = match ($payment->type) {
                                    'subscription_wallet' => 'پرداخت از کیف پول',
                                    'subscription_direct' => 'پرداخت از درگاه بانک',
                                    'wallet_topup' => 'شارژ کیف پول',
                                    default => 'نامشخص',
                                };
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ jdate($payment->created_at)->format('Y/m/d H:i') }}</td>
                                <td>{{ number_format($payment->amount) }} ریال</td>
                                <td>{{ $payment->description ?? '---' }}</td>
                                <td><span class="badge badge-{{ $statusClass }}">
                                    @switch($payment->status)
                                        @case('paid') موفق @break
                                        @case('failed') ناموفق @break
                                        @case('pending') در انتظار @break
                                        @default ناشناس
                                    @endswitch
                                </span></td>
                                <td>{{ $typeLabel }}</td>
                                <td>{{ $payment->transaction_id ?? '---' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4 d-flex justify-content-center">
                    {{ $payments->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>

@endsection
