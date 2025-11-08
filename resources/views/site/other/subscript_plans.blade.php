@extends('site.layout')

@section('title', 'خرید اشتراک')

@section('css')
    <style>
        span.price {
            background: #24c178;
            padding: 4px;
            border-top-left-radius: 4px;
            border-top-right-radius: 4px;
            margin: 10px 0 0;
            display: block;
            color: white;
        }

        span.duration {
            background: #7477f2;
            padding: 4px;
            border-bottom-left-radius: 4px;
            border-bottom-right-radius: 4px;
            display: block;
            color: white;
        }
    </style>
@endsection
@section('content')
    @session('error')
        <div class="alert alert-danger text-center p-2" role="alert" style="font-size: 14px">
            {{ $value }}
        </div>
    @endsession
    @if (auth()->user()->hasActiveSubscription() && !$status_payment)
        <div class="alert alert-success text-center p-2" style="font-size: 14px">
            شما یک اشتراک فعال دارید.
        </div>
    @else
        <div class="container py-5">
            <h2 class="text-center mb-5">انتخاب اشتراک عضویت</h2>
            <div class="row justify-content-center">
                @foreach ($subscriptions as $subscription)
                    <div class="col-6 col-md-4 mb-4">
                        <form action="{{ route('user.subscript.select', ['subscription_id' => $subscription->id]) }}"
                            method="POST" class="card shadow-sm h-100 border-0">
                            @csrf
                            <input type="hidden" name="subscription_id" value="{{ $subscription->id }}">

                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <div class="icon">
                                        {!! $subscription->icon !!}
                                    </div>
                                </div>
                                <h5 class="card-title">{{ $subscription->name }}</h5>
                                <p class="card-text text-muted">
                                    <span class="price">{{ number_format($subscription->price) }} ریال <br></span>
                                    <span class="duration"> مدت : {{ $subscription->duration_days }} روز</span>

                                    <span class="price">سقف خدمات : {{ number_format($subscription->service_limit) }}<br></span>

                                </p>
                            </div>
                            <div class="card-footer bg-transparent text-center border-0">
                                <button type="submit" class="btn btn-sm btn-light w-100">پرداخت</button>
                            </div>
                            <input type="hidden" name="status_payment" value="{{ $status_payment }}">
                        </form>
                    </div>
                @endforeach
            </div>

            @if ($subscriptions->isEmpty())
                <div class="text-center text-muted mt-5">
                    اشتراکی یافت نشد.
                </div>
            @endif
        </div>
    @endif
@endsection
