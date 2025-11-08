@extends('site.layout')
@section('title', 'تراکنش‌های من')

@section('css')
    <style>
        .card-transaction {
            transition: all 0.3s ease;
            border-radius: 12px;
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 16px;
        }

        .card-transaction:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .status-badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .paid {
            background-color: #e6f7ee;
            color: #10b759;
        }

        .failed {
            background-color: #fde8e8;
            color: #f04438;
        }

        .pending {
            background-color: #fff4e5;
            color: #ff9900;
        }

        .transaction-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 1.2rem;
        }

        .paid-icon {
            background-color: #d1fae5;
            color: #10b759;
        }

        .failed-icon {
            background-color: #fee2e2;
            color: #f04438;
        }

        .pending-icon {
            background-color: #fff4e5;
            color: #ff9900;
        }
    </style>
@endsection

@section('content')

    @session('error')
        <div class="alert alert-danger text-center p-2" role="alert" style="font-size: 14px">
            {{ $value }}
        </div>
    @endsession

    <div class="row">
        <div class="col-12">
            {{-- <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        فیلتر
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                        <li><a class="dropdown-item" href="#">همه تراکنش‌ها</a></li>
                        <li><a class="dropdown-item" href="#">موفق</a></li>
                        <li><a class="dropdown-item" href="#">ناموفق</a></li>
                        <li><a class="dropdown-item" href="#">در انتظار</a></li>
                    </ul>
                </div>
            </div> --}}

            @if ($payments->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-receipt text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-3">هیچ تراکنشی یافت نشد.</p>
                </div>
            @else
                <div class="row">
                    @foreach ($payments as $payment)
                        @php
                            $statusClass = match ($payment->status) {
                                'paid' => 'paid',
                                'failed' => 'failed',
                                'pending' => 'pending',
                                default => 'pending',
                            };
                            $iconClass = match ($payment->status) {
                                'paid' => 'bi-check-circle-fill',
                                'failed' => 'bi-x-circle-fill',
                                'pending' => 'bi-clock-fill',
                                default => 'bi-clock-fill',
                            };
                        @endphp
                        <div class="col-12">
                            <div class="card card-transaction">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="transaction-icon {{ $statusClass }}-icon">
                                                <i class="bi {{ $iconClass }} d-inline-flex"></i>
                                            </div>
                                            <div>
                                                <p class="text-muted small mb-0">
                                                    {{ jdate($payment->created_at)->format('Y/m/d H:i') }}
                                                </p>
                                            </div>
                                            @if ($payment->status == 'paid')
                                                <div>
                                                    <a href="{{ route('user.factor', ['tid' => $payment->id]) }}"
                                                        class="btn btn-sm btn-light">دریافت فاکتور</a>
                                                </div>
                                            @endif

                                        </div>
                                        <span class="status-badge {{ $statusClass }}">
                                            @switch($payment->status)
                                                @case('paid')
                                                    موفق
                                                @break

                                                @case('failed')
                                                    ناموفق
                                                @break

                                                @case('pending')
                                                    در انتظار
                                                @break

                                                @default
                                                    ناشناس
                                            @endswitch
                                        </span>
                                    </div>
                                    <div class="mt-3 pt-2 border-top">
                                        <div class="d-flex justify-content-between align-items-center my-2">
                                            {{-- مبلغ --}}
                                            <div>
                                                <p class="mb-1 text-muted small">
                                                    <i class="bi bi-cash-coin text-success me-1"></i> مبلغ
                                                </p>
                                                <p class="fw-bold mb-0" style="font-size: 14px">
                                                    {{ number_format($payment->amount) }} ریال
                                                </p>
                                            </div>

                                            {{-- تخفیف --}}
                                            @if ($payment->discount_amount > 0)
                                                <div>
                                                    <p class="mb-1 text-muted small">
                                                        <i class="bi bi-percent me-1" style="color:#10b759"></i> تخفیف
                                                    </p>
                                                    <p class="fw-bold mb-0" style="font-size: 14px;color:#10b759">
                                                        {{ number_format($payment->discount_amount) }} ریال
                                                    </p>
                                                </div>
                                            @endif

                                            {{-- توضیحات --}}
                                            <div>
                                                <p class="mb-1 text-muted small">
                                                    <i class="bi bi-chat-left-text text-primary me-1"></i> توضیحات
                                                </p>
                                                <p class="mb-0" style="font-size: 12px">
                                                    {{ $payment->description ?? '---' }}
                                                </p>
                                            </div>
                                        </div>

                                        <div
                                            class="d-flex justify-content-between align-items-center text-muted small mt-3">
                                            <div>
                                                <i class="bi bi-hash text-secondary me-1"></i>
                                                <span>کد رهگیری:
                                                    <span class="text-dark fw-semibold" style="font-size: 12px">
                                                        {{ $payment->transaction_id ?? '---' }}
                                                    </span>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="text-dark fw-semibold" style="font-size: 12px">
                                                    {{ match ($payment->type) {
                                                        'subscription_wallet' => 'پرداخت از کیف پول',
                                                        'subscription_direct' => 'پرداخت از درگاه بانک',
                                                        'wallet_topup' => 'شارژ کیف پول',
                                                        default => 'نامشخص',
                                                    } }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- صفحه‌بندی --}}
                <div class="mt-4 d-flex justify-content-center">
                    {{ $payments->links('vendor.pagination.bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
@endsection
