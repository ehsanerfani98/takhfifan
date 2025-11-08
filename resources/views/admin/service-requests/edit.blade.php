@extends('admin.layout')
@section('name', 'ویرایش درخواست خدمات')
@section('actions')
    <a href="{{ route('service-requests.index') }}" class="btn btn-primary btn-sm btn-icon-split">
        <span class="text-white-50">
            <i class="fas fa-arrow-right"></i>
        </span>
        <span class="text">برگشت</span>
    </a>
@endsection

@section('content')
@section('title', 'ویرایش درخواست خدمات')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('service-requests.update', $serviceRequest->id) }}">
    @csrf
    @method('PUT')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">جزئیات درخواست خدمات</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="user_id" class="form-label">کاربر</label>
                        <input type="text" class="form-control" id="user_id" name="user_id" value="{{ optional($serviceRequest->user->document)->first_name . ' ' . optional($serviceRequest->user->document)->last_name }} ({{ !empty($serviceRequest->user->phone) ? $serviceRequest->user->phone : $serviceRequest->user->email }})" required disabled>
                        <input type="hidden" name="user_id" value="{{ $serviceRequest->user_id }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="service_id" class="form-label">خدمات</label>
                        <select class="form-control" id="service_id" name="service_id" required>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}"
                                    {{ old('service_id', $serviceRequest->service_id) == $service->id ? 'selected' : '' }}>
                                    {{ $service->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">توضیحات درخواست</label>
                <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description', $serviceRequest->description) }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="status" class="form-label">وضعیت</label>
                        <select class="form-control" id="status" name="status">
                            @foreach (\App\Enums\ServiceRequestStatusEnum::cases() as $status)
                                <option value="{{ $status->value }}"
                                    {{ old('status', $serviceRequest->status->value) == $status->value ? 'selected' : '' }}>
                                    {{ $status->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>

            <div class="mb-3">
                <label for="admin_notes" class="form-label">یادداشت مدیریت</label>
                <textarea class="form-control" id="admin_notes" name="admin_notes" rows="3">{{ old('admin_notes', $serviceRequest->admin_notes) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="rejection_reason" class="form-label">دلیل رد (در صورت رد شدن)</label>
                <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3">{{ old('rejection_reason', $serviceRequest->rejection_reason) }}</textarea>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 text-right px-0">
                <button type="submit" class="btn btn-success btn-sm">
                    ذخیره تغییرات
                </button>
            </div>
        </div>
    </div>
</form>

@endsection
