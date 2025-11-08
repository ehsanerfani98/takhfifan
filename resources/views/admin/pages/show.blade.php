@extends('admin.layout')
@section('title', 'نمایش صفحه')

@section('actions')
    <a href="{{ route('pages.index') }}" class="btn btn-primary btn-sm btn-icon-split">
        <span class="text-white-50">
            <i class="fas fa-arrow-right"></i>
        </span>
        <span class="text">برگشت</span>
    </a>
@endsection

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">جزئیات صفحه</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h2>{{ $page->title }}</h2>
                    <p class="text-muted">
                        {{-- نوشته شده توسط {{ $page->author->name }} در --}}
                        {{ jdate($page->created_at)->format('Y/m/d H:i') }}
                    </p>

                    @if($page->featured_image)
                        <img src="{{ asset($page->featured_image) }}" alt="Featured Image"
                             class="img-fluid mb-4" style="max-height: 400px;">
                    @endif

                    <div class="content">
                        {!! $page->description !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-primary">اطلاعات صفحه</h6>
                        </div>
                        <div class="card-body">

                            <p><strong>لینک صفحه:</strong>
                                <input style="width: 100%;text-align: left" type="text" class="form-control" value="{{ route('page', ['slug'=>$page->slug]) }}">
                            </p>
                            <p><strong>وضعیت:</strong>
                                <span class="badge badge-{{ $page->is_published ? 'success' : 'secondary' }}">
                                    {{ $page->is_published ? 'منتشر شده' : 'پیش نویس' }}
                                </span>
                            </p>
                            <p><strong>تاریخ ایجاد:</strong> {{ jdate($page->created_at)->format('Y/m/d H:i') }}</p>
                            <p><strong>آخرین ویرایش:</strong> {{ jdate($page->updated_at)->format('Y/m/d H:i') }}</p>

                            <div class="mt-4">
                                <a href="{{ route('pages.edit', $page->slug) }}" class="btn btn-primary btn-block">
                                    <i class="fas fa-edit"></i> ویرایش صفحه
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection