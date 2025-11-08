@extends('admin.layout')
@section('title', 'ایجاد اشتراک جدید')
@section('actions')
    <a href="{{ route('subscriptions.index') }}" class="btn btn-primary btn-sm btn-icon-split">
        <span class="text-white-50">
            <i class="fas fa-arrow-right"></i>
        </span>
        <span class="text">برگشت</span>
    </a>
@endsection
@section('content')
    <form action="{{ route('subscriptions.store') }}" method="POST">
        @csrf
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">جزئیات اشتراک</h6>
            </div>
            <div class="card-body">
                
                <div class="mb-3">
                    <label for="icon" class="form-label">آیکن (svg)</label>
                    <textarea class="form-control" id="icon" name="icon" rows="3">{{ old('icon') }}</textarea>
                </div>

                <div class="mb-3">
                    <label>نام اشتراک</label>
                    <input type="text" name="name" class="form-control" required maxlength="100"
                        value="{{ old('name') }}">
                </div>

                <div class="mb-3">
                    <label>قیمت (ریال)</label>
                    <input type="number" name="price" class="form-control" required value="{{ old('price') }}">
                </div>

                <div class="mb-3">
                    <label>مدت زمان (روز)</label>
                    <input type="number" name="duration_days" class="form-control" required
                        value="{{ old('duration_days') }}">
                </div>

                <div class="mb-3">
                    <label>سقف خدمات</label>
                    <input type="number" name="service_limit" class="form-control" required
                        value="{{ old('service_limit') }}">
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" value="1" class="form-check-input" id="is_active" name="is_active"
                        {{ old('is_active') ? 'checked' : '' }}>
                    <label class="form-check-label mr-4" for="is_active">فعال باشد</label>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 text-right px-0">
                    <button ype="submit" class="btn btn-success btn-sm btn-icon-split">
                        <span class="text-white-50">
                            <svg fill="#ffffff" height="16px" width="16px" version="1.1" id="Layer_1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve" stroke="#ffffff">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <g id="Floppy-disk">
                                        <path
                                            d="M35.2673988,6.0411h-7.9999981v10h7.9999981V6.0411z M33.3697014,14.1434002h-4.2046013V7.9387999h4.2046013V14.1434002z">
                                        </path>
                                        <path
                                            d="M41,47.0410995H21c-0.5527992,0-1,0.4472008-1,1c0,0.5527,0.4472008,1,1,1h20c0.5527,0,1-0.4473,1-1 C42,47.4883003,41.5527,47.0410995,41,47.0410995z">
                                        </path>
                                        <path
                                            d="M41,39.0410995H21c-0.5527992,0-1,0.4472008-1,1c0,0.5527,0.4472008,1,1,1h20c0.5527,0,1-0.4473,1-1 C42,39.4883003,41.5527,39.0410995,41,39.0410995z">
                                        </path>
                                        <path d="M12,56.0410995h38v-26H12V56.0410995z M14,32.0410995h34v22H14V32.0410995z">
                                        </path>
                                        <path
                                            d="M49.3811989,0.0411L49.3610992,0H7C4.7908001,0,3,1.7909,3,4v56c0,2.2092018,1.7908001,4,4,4h50 c2.2090988,0,4-1.7907982,4-4V11.6962996L49.3811989,0.0411z M39.9604988,2.0804999v17.9211006H14.0394001V2.0804999H39.9604988z M59,60c0,1.1027985-0.8972015,2-2,2H7c-1.1027999,0-2-0.8972015-2-2V4c0-1.1027999,0.8972001-2,2-2h5v20.0410995h30V2h6.5099983 L59,12.5228996V60z">
                                        </path>
                                    </g>
                                </g>
                            </svg>
                        </span>
                        <span class="text">ذخیره</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection
