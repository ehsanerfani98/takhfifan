@extends('admin.layout')
@section('title', 'مدیریت مدل‌های خودرو')

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
                <h5 class="text-bold-700 my-2 text-white">لیست مدل‌های خودرو</h5>
                <div>
                    @can('car-model-create')
                        <a href="{{ route('models.create') }}" class="btn btn-sm text-white border-btn">
                            <span class="text">ایجاد مدل جدید</span>
                        </a>
                    @endcan
                        <a href="{{ url()->previous() }}" class="btn btn-sm text-white border-btn">
                            <span class="text">بازگشت</span>
                        </a>
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
                                    <th>برند</th>
                                    <th>سال‌ها</th>
                                    <th>تیپ ها</th>
                                    <th>رنگ‌ها</th>
                                    <th>اقدامات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carModels as $carModel)
                                    <tr>
                                        <td>{{ $carModel->id }}</td>
                                        <td>{{ $carModel->title }}</td>
                                        <td>
                                            <span class="badge badge-primary">{{ $carModel->brand->title }}</span>
                                        </td>
                                        <td>
                                            @if ($carModel->years && count($carModel->years) > 0)
                                                {{ implode(', ', $carModel->years) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($carModel->types && count($carModel->types) > 0)
                                                {{ implode(', ', $carModel->types) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($carModel->colors && count($carModel->colors) > 0)
                                                @foreach ($carModel->colors as $color)
                                                    <span class="badge badge-success">{{ $color }}</span>
                                                @endforeach
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @can('car-model-edit')
                                                <a href="{{ route('models.edit', $carModel->id) }}"
                                                    class="btn btn-primary btn-sm mb-1">
                                                    ویرایش
                                                </a>
                                            @endcan
                                            @can('car-model-delete')
                                                <form method="POST"
                                                    action="{{ route('models.destroy', $carModel->id) }}" style="display:inline-block"
                                                    onsubmit="return confirm('آیا از حذف مدل خودرو مطمئن هستید؟')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-danger btn-sm mb-1 w-100">
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

    {!! $carModels->links('pagination::bootstrap-5') !!}

@endsection
