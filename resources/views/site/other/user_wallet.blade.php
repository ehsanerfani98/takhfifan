@extends('site.layout')
@section('title', 'شارژ کیف پول')

@section('css')
    <style>
        .card-profile {
            transition: all 0.3s ease;
            border-radius: 12px;
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            margin-bottom: 24px;
        }

        .card-profile:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .confirm-mobile {
            padding: 5px 10px;
            background: #f0fff7;
            width: fit-content;
            border-radius: 6px;
            gap: 8px;
        }

        .confirm-document {
            padding: 5px 10px;
            background: #ffffff;
            width: fit-content;
            border-radius: 6px;
            gap: 8px;
        }

        .confirm-mobile .title {
            color: #10b96c;
        }

        .doc-status {
            font-size: 12px;
            padding: 3px 10px;
            border-radius: 6px;
            font-weight: 500;
        }

        .verified {
            background-color: #e6f7ee;
            color: #10b759;
        }

        .not-verified {
            background-color: #fde8e8;
            color: #f04438;
        }

        .correction {
            background-color: #fff4e5;
            color: #ff9900;
        }

        .wallet-balance {
            font-size: 24px;
            font-weight: bold;
            color: #10b759;
        }

        .wallet-card {
            border-radius: 12px;
            padding: 16px;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            margin-bottom: 16px;
            transition: all 0.3s ease;
        }

        .wallet-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .wallet-card .amount {
            font-weight: bold;
            font-size: 16px;
        }

        .wallet-card .type-credit {
            color: #10b759;
        }

        .wallet-card .type-debit {
            color: #f04438;
        }

        .wallet-card .description {
            font-size: 14px;
            color: #555;
        }

        .wallet-card .date {
            font-size: 13px;
            color: #999;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-profile">
                <div class="card-body">
                    <h6 class="mb-3">شارژ کیف پول</h6>

                    <form action="{{ route('user.wallet.payment') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="amount" class="form-label">مبلغ (ریال)</label>
                            <input type="number" name="amount" id="amount" class="form-control"
                                placeholder="مثلاً 50000" required min="1000">
                        </div>

                        <button type="submit" class="btn btn-sm btn-primary">ادامه و پرداخت</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12">
            <h6 class="mb-4">تاریخچه تراکنش‌های کیف پول</h6>

            @if ($transactions->isEmpty())
                <div class="alert alert-warning text-center">
                    هیچ تراکنشی یافت نشد.
                </div>
            @else
                <div class="row">
                    @foreach ($transactions as $transaction)
                        <div class="col-md-6 col-lg-4">
                            <div class="wallet-card">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span
                                        class="amount {{ $transaction->type === 'credit' ? 'type-credit' : 'type-debit' }}">
                                        {{ number_format($transaction->amount) }} ریال
                                    </span>
                                    <span class="badge {{ $transaction->type === 'credit' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $transaction->type === 'credit' ? 'واریز' : 'برداشت' }}
                                    </span>
                                </div>
                                <div class="description mb-1">
                                    {{ $transaction->description ?? '—' }}
                                </div>
                                <div class="date">
                                    {{ jdate($transaction->created_at)->format('Y/m/d H:i') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4 d-flex justify-content-center">
                    {{ $transactions->links('vendor.pagination.bootstrap-5') }}
                </div>

            @endif
        </div>
    </div>
@endsection
