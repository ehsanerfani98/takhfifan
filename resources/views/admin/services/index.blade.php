@extends('admin.layout')
@section('name', 'مدیریت خدمات')
@section('actions')
    @can('service-create')
        <a href="{{ route('services.create') }}" class="btn btn-success btn-sm btn-icon-split">
            <span class="text-white-50"><i class="fas fa-plus"></i></span>
            <span class="text">افزودن خدمت جدید</span>
        </a>
    @endcan
@endsection

@section('content')

    @session('success')
        <div class="alert alert-success">{{ $value }}</div>
    @endsession

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">لیست خدمات</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>شناسه</th>
                        <th>عنوان</th>
                        <th>سرویس والد</th>
                        <th>توضیح</th>
                        <th>وضعیت</th>
                        <th width="200px">اقدامات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($services as $service)
                        <tr>
                            <td>{{ $service->id }}</td>
                            <td>{{ $service->name }}</td>
                            <td>
                                {{ $service->parent ? $service->parent->name : '—' }}
                            </td>
                            <td>{!! Str::limit($service->description, 50) !!}</td>
                            <td>
                                <span class="badge badge-{{ $service->is_active ? 'success' : 'secondary' }}">
                                    {{ $service->is_active ? 'فعال' : 'غیرفعال' }}
                                </span>
                            </td>
                            <td>
                                @can('service-edit')
                                    <a href="{{ route('services.edit', $service->id) }}"
                                        class="btn btn-primary btn-sm btn-icon-split">
                                        <span class="text-white-50">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                        <span class="text">ویرایش</span>
                                    </a>
                                @endcan
                                @can('service-delete')
                                    <form action="{{ route('services.destroy', $service->id) }}" method="POST"
                                        style="display:inline;">
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

    {!! $services->links('pagination::bootstrap-5') !!}

@endsection
