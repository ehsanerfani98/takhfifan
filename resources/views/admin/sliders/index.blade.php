@extends('admin.layout')
@section('title', 'مدیریت اسلایدر')

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
                <h5 class="text-bold-700 my-2 text-white">لیست اسلایدها</h5>

                <div>
                    @can('slider-create')
                    <a href="{{ route('sliders.create') }}" class="btn btn-sm text-white border-btn">
                        <span class="text">ایجاد اسلاید جدید</span>
                    </a>
                    @endcan
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped compact dataTable" id="sliders-table" style="text-align: center;">
                            <thead>
                                <tr>
                                    <th>شناسه</th>
                                    <th>تصویر</th>
                                    <th>عنوان</th>
                                    <th>وضعیت</th>
                                    <th>ترتیب</th>
                                    <th>اقدامات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sliders as $slider)
                                    <tr>
                                        <td>{{ $slider->id }}</td>
                                        <td>
                                            @if ($slider->image)
                                                <img height="35" src="{{ asset($slider->image) }}" alt="{{ $slider->title }}">
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $slider->title }}</td>
                                        <td>
                                            <span class="badge badge-{{ $slider->is_active ? 'success' : 'secondary' }}">
                                                {{ $slider->is_active ? 'فعال' : 'غیرفعال' }}
                                            </span>
                                        </td>
                                        <td>{{ $slider->order }}</td>
                                        <td>
                                            @can('slider-edit')
                                                <a href="{{ route('sliders.edit', $slider->id) }}" class="btn btn-primary btn-sm">
                                                    ویرایش
                                                </a>
                                            @endcan
                                            @can('slider-delete')
                                                <form method="POST" action="{{ route('sliders.destroy', $slider->id) }}"
                                                      style="display:inline-block"
                                                      onsubmit="return confirm('آیا از حذف اسلاید مطمئن هستید؟')">
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

    {!! $sliders->links('pagination::bootstrap-5') !!}

@endsection