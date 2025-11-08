@extends('admin.layout')
@section('title', 'مدیریت مقادیر ویژگی‌ها')

@section('content')

    @session('error')
        <script>
            notifier.alert('{{ session('error') }}', { labels: { alert: 'خطا' } })
        </script>
    @endsession

    @session('success')
        <script>
            notifier.success('{{ session('success') }}', { labels: { success: 'تبریک' } })
        </script>
    @endsession

    <div class="row">
        <div class="col-12">
            <div class="px-2 d-flex align-items-center justify-content-between">
                <h5 class="text-bold-700 my-2 text-white">لیست مقادیر ویژگی‌ها</h5>
                <a href="{{ route('attribute-values.create') }}" class="btn btn-sm text-white border-btn">
                    <span class="text">ایجاد مقدار جدید</span>
                </a>
            </div>

            <div class="card">
                <div class="card-body">
                    <div id="recent-projects" class="media-list position-relative">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped compact dataTable" style="text-align:center;">
                                <thead>
                                    <tr>
                                        <th>شناسه</th>
                                        <th>ویژگی</th>
                                        <th>مقدار</th>
                                        <th>نامک</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($values as $val)
                                        <tr>
                                            <td>{{ $val->id }}</td>
                                            <td>{{ $val->attribute->name }}</td>
                                            <td>{{ $val->value }}</td>
                                            <td>{{ $val->slug }}</td>
                                            <td>
                                                <a href="{{ route('attribute-values.edit', $val->id) }}" class="btn btn-sm btn-primary">ویرایش</a>
                                                <form action="{{ route('attribute-values.destroy', $val->id) }}" method="POST" class="d-inline" onsubmit="return confirm('حذف شود؟')">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-danger">حذف</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! $values->links('pagination::bootstrap-5') !!}
@endsection
