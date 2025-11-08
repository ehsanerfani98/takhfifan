@extends('admin.layout')
@section('title', 'مدیریت پرونده‌ها')

@section('content')

    @session('success')
        <script>
            notifier.success('{{ session('success') }}', {
                labels: {
                    success: 'تبریک'
                }
            })
        </script>
    @endsession

    @session('error')
        <script>
            notifier.alert('{{ session('error') }}', {
                labels: {
                    alert: 'خطا'
                }
            })
        </script>
    @endsession

    <div class="row">
        <div class="col-12">
            <div class="px-2 d-flex align-items-center justify-content-between">
                <h5 class="text-bold-700 my-2 text-white">لیست پرونده‌ها</h5>
                <div>
                    @can('car-files-create')
                        <a href="{{ route('car-files.create') }}" class="btn btn-sm text-white border-btn">
                            <span class="menu-title">ایجاد پرونده جدید</span>
                        </a>
                    @endcan
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped compact dataTable" id="recent-project-table"
                            style="text-align: center;">
                            <thead>
                                <tr>
                                    <th>شناسه</th>
                                    <th>عنوان پرونده</th>
                                    <th>اقدامات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carFiles as $file)
                                    <tr>
                                        <td>{{ $file->id }}</td>
                                        <td>{{ $file->title }}</td>
                                        <td>
                                            @can('car-file-items-create')
                                                <a href="{{ route('car-file-items.create', ['carfile_id' => $file->id]) }}"
                                                    class="btn btn-sm btn-success">ایجاد آیتم</a>
                                            @endcan
                                            @can('car-files-edit')
                                                <a href="{{ route('car-files.edit', $file->id) }}"
                                                    class="btn btn-sm btn-primary">ویرایش</a>
                                            @endcan
                                            @can('car-files-delete')
                                                <form method="POST" action="{{ route('car-files.destroy', $file->id) }}"
                                                    style="display:inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-success"
                                                        onclick="return confirm('آیا حذف شود؟')">حذف</button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {!! $carFiles->links('pagination::bootstrap-5') !!}
                </div>
            </div>
        </div>
    </div>

@endsection
