@extends('admin.layout')
@section('title', 'مشاهده پروفایل کاربر')

@section('content')

    @session('error')
        <script>
            notifier.alert('{{ session('error') }}', {
                labels: {
                    alert: 'خطا'
                },
            })
        </script>
    @endsession

    @session('success')
        <script>
            notifier.success('{{ session('success') }}', {
                labels: {
                    success: 'تبریک'
                },
            })
        </script>
    @endsession

    <div class="row">
        <div class="col-12">
            <div class="px-2 d-flex align-items-center justify-content-between">
                <h5 class="text-bold-700 my-2 text-white">مشاهده پروفایل کاربر</h5>
                <div>
                    <a href="{{ route('documents.edit', $user->id) }}" class="btn btn-sm text-white border-btn">
                        <span class="text">ویرایش پروفایل</span>
                    </a>
                    <a href="{{ route('users.index') }}" class="btn btn-sm text-white border-btn">
                        <span class="text">برگشت به لیست کاربران</span>
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped compact" style="text-align: center;">
                                    <tbody>
                                        <tr>
                                            <th width="200">نوع کاربر</th>
                                            <td>{{ $document->type == 'individual' ? 'حقیقی' : 'حقوقی' }}</td>
                                        </tr>
                                        <tr>
                                            <th>نام</th>
                                            <td>{{ $document->first_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>نام خانوادگی</th>
                                            <td>{{ $document->last_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>شماره موبایل</th>
                                            <td>{{ $document->mobile }}</td>
                                        </tr>
                                        <tr>
                                            <th>کد ملی</th>
                                            <td>{{ $document->national_id }}</td>
                                        </tr>
                                        <tr>
                                            <th>نام شرکت</th>
                                            <td>{{ $document->company_name ?: '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>آدرس شرکت</th>
                                            <td>{{ $document->company_address ?: '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>وضعیت تایید</th>
                                            <td>
                                                @if ($document->is_verified)
                                                    <span class="badge badge-success">تأیید شده</span>
                                                @elseif($document->needs_correction)
                                                    <span class="badge badge-warning">نیاز به اصلاح</span>
                                                @else
                                                    <span class="badge badge-warning">در انتظار بررسی</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>توضیحات اصلاحیه</th>
                                            <td>{{ $document->description ?: 'ندارد' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="text-center mb-4">
                                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center"
                                     style="width: 120px; height: 120px;">
                                    <i class="fas fa-user fa-3x text-secondary"></i>
                                </div>
                                <h6 class="mt-3 mb-1">{{ $document->first_name . ' ' . $document->last_name }}</h6>
                                <p class="text-muted small">{{ $document->mobile }}</p>

                                <div class="d-flex justify-content-center gap-2 mt-3">
                                    <a href="{{ route('transactions.show', $user->id) }}"
                                       class="btn btn-info btn-sm">
                                        تراکنش‌ها
                                    </a>
                                    <a href="{{ route('wallets.show', $user->id) }}"
                                       class="btn btn-warning btn-sm">
                                        کیف پول
                                    </a>
                                </div>
                            </div>

                            <div class="border-top pt-3">
                                <h6 class="text-center mb-3">وضعیت حساب</h6>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>تأیید هویت:</span>
                                    <span class="badge badge-{{ $document->is_verified ? 'success' : 'secondary' }}">
                                        {{ $document->is_verified ? 'تأیید شده' : 'تأیید نشده' }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>نوع حساب:</span>
                                    <span class="badge badge-primary">
                                        {{ $document->type == 'individual' ? 'حقیقی' : 'حقوقی' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row">
                        <div class="col-12">
                            <h6 class="mb-3">فایل‌های پیوست</h6>
                            @if ($document->files->count())
                                <div class="row">
                                    @foreach ($document->files as $file)
                                        <div class="col-md-3 col-sm-6 text-center mb-4">
                                            <div class="border p-2 rounded h-100 d-flex flex-column">
                                                @if (Str::endsWith($file->path, ['.jpg', '.jpeg', '.png', '.webp']))
                                                    <img src="{{ asset($file->path) }}"
                                                         class="img-fluid rounded mb-2 flex-grow-1"
                                                         style="max-height: 120px; object-fit: cover;">
                                                @else
                                                    <div class="d-flex align-items-center justify-content-center mb-2 flex-grow-1">
                                                        <i class="fas fa-file fa-3x text-secondary"></i>
                                                    </div>
                                                    <small class="text-muted">فایل غیر تصویری</small>
                                                @endif
                                                <a download href="{{ asset($file->path) }}" target="_blank"
                                                    class="btn btn-sm btn-info mt-2">
                                                    <i class="fas fa-download ml-1"></i>
                                                    دانلود
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">هیچ فایلی آپلود نشده است.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection