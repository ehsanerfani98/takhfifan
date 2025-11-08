@extends('admin.layout')
@section('title', 'مدیریت ماشین‌ها')

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
                <h5 class="text-bold-700 my-2 text-white">لیست ماشین‌ها</h5>
                <a href="{{ route('cars.create') }}" class="btn btn-sm text-white border-btn">
                    <span class="text">ایجاد ماشین‌ جدید</span>
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
                                        <th>عنوان</th>
                                        <th>نامک</th>
                                        <th>ویژگی‌ها</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cars as $car)
                                        <tr>
                                            <td>{{ $car->id }}</td>
                                            <td>{{ $car->title }}</td>
                                            <td>{{ $car->slug }}</td>
                                            <td style="text-align:left;">
                                                @foreach ($car->attributeValues as $av)
                                                    <div>
                                                        <strong>{{ optional($av->attribute)->label }}:</strong>
                                                        @if ($av->attribute && $av->attribute->type === 'select')
                                                            {{ optional($av->attributeValue)->value }}
                                                        @elseif($av->attribute && in_array($av->attribute->type, ['number', 'range']))
                                                            {{ $av->value_number }}
                                                        @elseif($av->attribute && $av->attribute->type === 'boolean')
                                                            @php
                                                                $labels = explode(',', $av->value_boolean_label ?? 'بله,خیر');
                                                                $trueLabel = $labels[0] ?? 'بله';
                                                                $falseLabel = $labels[1] ?? 'خیر';
                                                            @endphp
                                                            {{ $av->value_boolean ? $trueLabel : $falseLabel }}
                                                        @else
                                                            {{ $av->value_string }}
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </td>
                                            <td>
                                                <a href="{{ route('cars.edit', $car->id) }}"
                                                    class="btn btn-sm btn-primary">ویرایش</a>
                                                <form action="{{ route('cars.destroy', $car->id) }}" method="POST"
                                                    class="d-inline" onsubmit="return confirm('حذف شود؟')">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-danger">حذف</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {!! $cars->links('pagination::bootstrap-5') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection