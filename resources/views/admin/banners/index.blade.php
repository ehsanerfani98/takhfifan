@extends('admin.layout')
@section('title', 'مدیریت بنر')
@push('style')
<style>
    .banner-title :is(h1, h2, h3, h4, h5, h6) {
        font-size: 12px;
    }
</style>

@endpush
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
                <h5 class="text-bold-700 my-2 text-white">لیست بنرها</h5>

                <div>
                    @can('banner-create')
                        <a href="{{ route('banners.create') }}" class="btn btn-sm text-white border-btn">
                            <span class="text">ایجاد بنر جدید</span>
                        </a>
                    @endcan
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped compact dataTable" id="banners-table"
                            style="text-align: center;">
                            <thead>
                                <tr>
                                    <th>شناسه</th>
                                    <th>تصویر اصلی</th>
                                    <th>تصویر پوشاننده</th>
                                    <th>عنوان</th>
                                    <th>وضعیت</th>
                                    <th>ترتیب</th>
                                    <th>اقدامات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($banners as $banner)
                                    <tr>
                                        <td>{{ $banner->id }}</td>
                                        <td>
                                            @if ($banner->thumbnail)
                                                <img height="35" src="{{ asset($banner->thumbnail) }}">
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($banner->cover)
                                                <img height="35" src="{{ asset($banner->cover) }}">
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="banner-title">{!! $banner->title !!}</td>
                                        <td>
                                            <span class="badge badge-{{ $banner->is_active ? 'success' : 'secondary' }}">
                                                {{ $banner->is_active ? 'فعال' : 'غیرفعال' }}
                                            </span>
                                        </td>
                                        <td>{{ $banner->order }}</td>
                                        <td>
                                            @can('banner-edit')
                                                <a href="{{ route('banners.edit', $banner->id) }}"
                                                    class="btn btn-primary btn-sm">
                                                    ویرایش
                                                </a>
                                            @endcan
                                            @can('banner-delete')
                                                <form method="POST" action="{{ route('banners.destroy', $banner->id) }}"
                                                    style="display:inline-block"
                                                    onsubmit="return confirm('آیا از حذف بنر مطمئن هستید؟')">
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

    {!! $banners->links('pagination::bootstrap-5') !!}

@endsection
