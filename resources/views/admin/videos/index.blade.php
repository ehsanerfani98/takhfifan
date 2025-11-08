@extends('admin.layout')
@section('name', 'مدیریت ویدیوها')
@section('actions')
    <a href="{{ route('videos.create') }}" class="btn btn-success btn-sm btn-icon-split">
        <span class="text-white-50"><i class="fas fa-plus"></i></span>
        <span class="text">افزودن ویدیو جدید</span>
    </a>
@endsection

@section('content')

    @session('success')
        <div class="alert alert-success">{{ $value }}</div>
    @endsession

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">لیست ویدیوها</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>شناسه</th>
                        <th>عنوان</th>
                        <th>ویدیو</th>
                        <th>زیرنویس</th>
                        <th>تاریخ ثبت</th>
                        <th width="200px">اقدامات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($videos as $video)
                        <tr>
                            <td>{{ $video->id }}</td>
                            <td>{{ $video->title }}</td>
                            <td>{{ Str::limit($video->video, 40) }}</td>
                            <td>{{ Str::limit($video->subtitle, 40) }}</td>
                            <td>{{ jdate($video->created_at)->format('Y/m/d') }}</td>
                            <td>
                                <a href="{{ route('videos.edit', $video->id) }}" class="btn btn-primary btn-sm">ویرایش</a>
                                <form action="{{ route('videos.destroy', $video->id) }}" method="POST" class="d-inline" onsubmit="return confirm('آیا مطمئن هستید؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {!! $videos->links('pagination::bootstrap-5') !!}

@endsection
