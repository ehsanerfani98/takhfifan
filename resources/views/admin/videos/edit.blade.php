@extends('admin.layout')
@section('name', 'ویرایش ویدیو')
@section('actions')
    <a href="{{ route('videos.index') }}" class="btn btn-primary btn-sm btn-icon-split">
        <span class="text-white-50">
            <i class="fas fa-arrow-right"></i>
        </span>
        <span class="text">برگشت</span>
    </a>
@endsection

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ route('videos.update', $video->id) }}">
        @csrf
        @method('PUT')
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">ویرایش ویدیو</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="title" class="form-label">عنوان</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $video->title) }}" required>
                </div>

                <div class="mb-3">
                    <label for="video" class="form-label">آدرس ویدیو</label>
                    <input type="text" class="form-control" id="video" name="video" value="{{ old('video', $video->video) }}" required>
                </div>

                <div class="mb-3">
                    <label for="subtitle" class="form-label">آدرس زیرنویس</label>
                    <input type="text" class="form-control" id="subtitle" name="subtitle" value="{{ old('subtitle', $video->subtitle) }}" required>
                </div>

                <button type="submit" class="btn btn-success">ذخیره تغییرات</button>
            </div>
        </div>
    </form>
@endsection
