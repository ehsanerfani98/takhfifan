@extends('admin.layout')
@section('title', 'مدیریت منوها')

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
                <h5 class="text-bold-700 my-2 text-white">لیست منوها</h5>

                <div>
                    @can('menu-create')
                    <a href="{{ route('menus.create') }}" class="btn btn-sm text-white border-btn">
                        <span class="text">ایجاد منوی جدید</span>
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
                                    <th>عنوان</th>
                                    <th>لینک</th>
                                    <th>والد</th>
                                    <th>ترتیب</th>
                                    <th>وضعیت</th>
                                    <th>اقدامات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($menus as $menu)
                                    <tr>
                                        <td>{{ $menu->id }}</td>
                                        <td class="text-right">
                                            <strong>{{ $menu->title }}</strong>
                                            @if($menu->children->count() > 0)
                                                <br>
                                                <small class="text-gray-600">
                                                    @foreach($menu->children as $child)
                                                        <span class="badge bg-light text-dark mx-1">{{ $child->title }}</span>
                                                    @endforeach
                                                </small>
                                            @endif
                                        </td>
                                        <td>{{ $menu->link ?? '-' }}</td>
                                        <td>{{ $menu->parent ? $menu->parent->title : '-' }}</td>
                                        <td>{{ $menu->order }}</td>
                                        <td>
                                            <span class="badge badge-{{ $menu->is_active ? 'success' : 'secondary' }}">
                                                {{ $menu->is_active ? 'فعال' : 'غیرفعال' }}
                                            </span>
                                        </td>
                                        <td>
                                            @can('menu-edit')
                                                <a href="{{ route('menus.edit', $menu->id) }}" class="btn btn-primary btn-sm">
                                                    ویرایش
                                                </a>
                                            @endcan
                                            @can('menu-delete')
                                                <form method="POST" action="{{ route('menus.destroy', $menu->id) }}"
                                                      style="display:inline-block"
                                                      onsubmit="return confirm('آیا از حذف این منو مطمئن هستید؟')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        حذف
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
            </div>
        </div>
    </div>

    {!! $menus->links('pagination::bootstrap-5') !!}

@endsection