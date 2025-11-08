@extends('admin.layout')
@section('title', 'مدیریت نقش ها')

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
                <h5 class="text-bold-700 my-2 text-white">لیست نقش ها</h5>
                @can('user-create')
                    <a href="{{ route('roles.create') }}" class="btn btn-sm text-white border-btn">
                        <span class="text">ایجاد نقش جدید</span>
                    </a>
                @endcan
            </div>

            <div class="card">
                <div class="card-body">
                    <div id="recent-projects" class="media-list position-relative">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped compact dataTable" id="recent-project-table"
                                style="text-align: center;">
                                <thead>
                                    <tr>
                                        <th class="border-top-0">شناسه</th>
                                        <th class="border-top-0">نقش</th>
                                        <th class="border-top-0" width="300px">اقدامات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($roles as $role)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $role->title }}</td>
                                            <td>
                                                <a href="{{ route('roles.show', $role->id) }}"
                                                    class="btn btn-info btn-sm btn-icon-split">
                                                    نمایش
                                                </a>

                                                @can('role-edit')
                                                    <a href="{{ route('roles.edit', $role->id) }}"
                                                        class="btn btn-primary btn-sm btn-icon-split">
                                                        ویرایش
                                                    </a>
                                                @endcan

                                                @can('role-delete')
                                                    @if ($role->name != 'Admin' && $role->name != 'User')
                                                        <form method="POST" action="{{ route('roles.destroy', $role->id) }}"
                                                            style="display:inline">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button ype="submit" class="btn btn-danger btn-sm btn-icon-split">
                                                                حذف
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" style="text-align: center;padding: 10px">هنوز اطلاعاتی ثبت
                                                نشده است</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {!! $roles->links('pagination::bootstrap-5') !!}


@endsection
