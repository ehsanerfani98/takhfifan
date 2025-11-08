@extends('admin.layout')
@section('title', 'مدیریت صفحات')
@section('actions')
    @can('page-create')
        <a href="{{ route('pages.create') }}" class="btn btn-success btn-sm btn-icon-split">
            <span class="text-white-50"><i class="fas fa-plus"></i></span>
            <span class="text">افزودن صفحه جدید</span>
        </a>
    @endcan
@endsection

@section('content')
    @session('success')
        <div class="alert alert-success">{{ $value }}</div>
    @endsession

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">لیست صفحات</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>شناسه</th>
                        <th>عنوان</th>
                        {{-- <th>نویسنده</th> --}}
                        <th>تاریخ انتشار</th>
                        <th>وضعیت</th>
                        <th>لینک صفحه</th>
                        <th width="200px">اقدامات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pages as $page)
                        <tr>
                            <td>{{ $page->id }}</td>
                            <td>{{ $page->title }}</td>
                            {{-- <td>{{ $page->author->name }}</td> --}}
                            <td>{{ jdate($page->created_at)->format('Y/m/d H:i') }}</td>
                            <td>
                                <span class="badge badge-{{ $page->is_published ? 'success' : 'secondary' }}">
                                    {{ $page->is_published ? 'منتشر شده' : 'پیش نویس' }}
                                </span>
                            </td>
                            <td>
                                <input style="text-align: left" type="text" class="form-control" value="{{ route('page', ['slug'=>$page->slug]) }}">
                            </td>
                            <td>
                                @can('page-edit')
                                    <a href="{{ route('pages.edit', $page->slug) }}" class="btn btn-primary btn-sm btn-icon-split">
                                        <span class="text-white-50">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                        <span class="text">ویرایش</span>
                                    </a>
                                @endcan
                                @can('page-delete')
                                    <form action="{{ route('pages.destroy', $page->slug) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm btn-icon-split"
                                            onclick="return confirm('آیا مطمئن هستید؟')">
                                            <span class="text-white-50">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                            <span class="text">حذف</span>
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {!! $pages->links('pagination::bootstrap-5') !!}
@endsection