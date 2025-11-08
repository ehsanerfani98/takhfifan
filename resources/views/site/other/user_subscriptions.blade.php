@extends('site.layout')
@section('title', 'اشتراک‌های من')

@section('css')
    <style>
        .card-subscription {
            transition: all 0.3s ease;
            border-radius: 12px;
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 16px;
        }

        .card-subscription:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .status-badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .active {
            background-color: #e6f7ee;
            color: #10b759;
        }

        .expired {
            background-color: #fde8e8;
            color: #f04438;
        }

        .cancelled {
            background-color: #fff4e5;
            color: #ff9900;
        }

        @media (max-width: 411px) {
            .fs-r {
                font-size: 11px !important;
            }
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            {{-- <h6 class="mb-4">اشتراک‌های فعال و گذشته</h6> --}}
            <a href="{{ route('user.subscript.plans') }}?status_payment=upgrade" class="btn btn-sm btn-primary mb-3"><i class="fa fa-rocket" style="transform: rotate(-45deg);"></i> ارتقا اشتراک</a>

            @if ($subscriptions->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-person-bounding-box text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-3">هیچ اشتراکی برای شما ثبت نشده است.</p>
                </div>
            @else
                @foreach ($subscriptions as $subscription)
                    @php
                        $statusClass = match ($subscription->status) {
                            'active' => 'active',
                            'expired' => 'expired',
                            default => 'expired',
                        };
                    @endphp

                    <div class="card card-subscription {{ $subscription->status == 'expired' ? 'disable' : ''}}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1" style="font-size: 14px">{{ $subscription->plan_title }}</h6>
                                    <p class="text-muted small mb-0 mt-2 fs-r" style="font-size: 12px">
                                        تاریخ شروع: {{ jdate($subscription->start_date)->format('Y/m/d') }}
                                        |
                                        تاریخ پایان: {{ jdate($subscription->end_date)->format('Y/m/d') }}
                                    </p>
                                </div>
                                <span class="status-badge {{ $statusClass }} fs-r">
                                    @switch($subscription->status)
                                        @case('active')
                                            اشتراک فعال
                                        @break

                                        @case('expired')
                                            منقضی شده
                                        @break

                                        @default
                                            نامشخص
                                    @endswitch
                                </span>
                            </div>

                            <div class="mt-3 pt-2 border-top">
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <div>
                                        <p class="mb-1 text-muted small fs-r">
                                            <i class="bi bi-calendar-check text-primary"></i> تاریخ ثبت اشتراک
                                        </p>
                                        <p class="mb-0 fw-bold fs-r" style="font-size: 13px">
                                            {{ jdate($subscription->created_at)->format('Y/m/d H:i') }}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="mb-1 text-muted small fs-r">
                                            <i class="bi bi-clock-history text-info"></i> مدت اشتراک
                                        </p>
                                        <p class="mb-0 fw-bold fs-r" style="font-size: 12px">
                                            {{ $subscription->duration_days ?? '---' }}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="mb-1 text-muted small fs-r">
                                            <i class="bi bi-hourglass-split text-warning"></i> زمان باقی‌مانده
                                        </p>
                                        <p class="mb-0 fw-bold fs-r" style="font-size: 12px">
                                            {{ $subscription->remaining_time }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
                {{-- صفحه‌بندی --}}
                <div class="mt-4 d-flex justify-content-center">
                    {{ $subscriptions->links('vendor.pagination.bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
@endsection
