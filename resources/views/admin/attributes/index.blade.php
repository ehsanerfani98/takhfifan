@extends('admin.layout')
@section('title', 'مدیریت ویژگی‌ها')

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
                <h5 class="text-bold-700 my-2 text-white">لیست ویژگی‌ها</h5>
                <div>
                    @can('attribute-values-list')
                        <a href="{{ route('attribute-values.index') }}">
                            <span class="btn btn-sm text-white border-btn">مدیریت مقدار ویژگی ها</span>
                        </a>
                    @endcan
                    @can('user-create')
                        <a href="{{ route('attributes.create') }}" class="btn btn-sm text-white border-btn">
                            <span class="text">ایجاد ویژگی‌ جدید</span>
                        </a>
                    @endcan
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div id="recent-projects" class="media-list position-relative">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped compact dataTable" id="recent-project-table"
                                style="text-align: center;">
                                <thead>
                                    <tr>
                                        <th>شناسه</th>
                                        <th>ترتیب</th>
                                        <th>نام</th>
                                        <th>لیبل</th>
                                        <th>نوع</th>
                                        <th>نمایش در کارت</th>
                                        <th>به عنوان فیلتر</th>
                                        <th>فعال</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($attributes as $attr)
                                        <tr>
                                            <td>{{ $attr->id }}</td>
                                            <td>{{ $attr->sort_order }}</td>
                                            <td>{{ $attr->name }}</td>
                                            <td>{{ $attr->label }}</td>
                                            <td>{{ $attr->type }}</td>
                                            <td>
                                                @if ($attr->show_in_card)
                                                    <label class="badge badge-success">بله</label>
                                                @else
                                                    <label class="badge badge-danger">خیر</label>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($attr->is_filter)
                                                    <label class="badge badge-success">بله</label>
                                                @else
                                                    <label class="badge badge-danger">خیر</label>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($attr->is_active)
                                                    <label class="badge badge-success">بله</label>
                                                @else
                                                    <label class="badge badge-danger">خیر</label>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('attributes.edit', $attr->id) }}"
                                                    class="btn btn-sm btn-primary">ویرایش</a>
                                                <form action="{{ route('attributes.destroy', $attr->id) }}" method="POST"
                                                    class="d-inline" onsubmit="return confirm('حذف شود؟')">
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
    {!! $attributes->links('pagination::bootstrap-5') !!}
@endsection
