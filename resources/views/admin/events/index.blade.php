@extends('admin.layout')
@section('title', 'رویدادهای مخاطب')

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
                <h5 class="text-bold-700 my-2 text-white">لیست رویدادها</h5>
                @can('event-create')
                    <a href="{{ route('events.create') }}" class="btn btn-sm text-white border-btn">
                        <span class="text">ایجاد رویداد جدید</span>
                    </a>
                @endcan
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped compact dataTable" id="recent-contacts-table"
                            style="text-align: center;">
                            <thead>
                                <tr>
                                    <th>شناسه</th>
                                    <th>عنوان</th>
                                    <th>نوع رویداد</th>
                                    <th>تاریخ ارسال</th>
                                    <th>تاریخ یادآوری</th>
                                    <th>وضعیت</th>
                                    <th>اقدامات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($events as $event)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $event->title }}</td>
                                        <td>
                                            <span
                                                class="badge badge-{{ $event->type->name == 'birthday' ? 'success' : ($event->type->name == 'anniversary' ? 'info' : 'primary') }}">
                                                {{ __($event->type->display_name) }}
                                            </span>
                                        </td>
                                        <td>{{ jdate($event->send_date)->format('Y/m/d H:i') }}</td>
                                        <td>{{ jdate($event->remind_at)->format('Y/m/d H:i') }}</td>
                                        <td>
                                            @if ($event->status == 'pending')
                                                <span class="badge badge-warning">در صف ارسال</span>
                                            @elseif($event->status == 'sent')
                                                <span class="badge badge-success">ارسال شده</span>
                                            @else
                                                <span class="badge badge-danger">ناموفق</span>
                                            @endif
                                        </td>
                                        <td>
                                            @can('event-edit')
                                                <a href="{{ route('events.edit', [$event->id, $event->id]) }}"
                                                    class="btn btn-sm btn-primary">
                                                    ویرایش
                                                </a>
                                            @endcan
                                            @can('event-delete')
                                                <form class="d-inline"
                                                    action="{{ route('events.destroy', [$event->id, $event->id]) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('آیا از حذف این رویداد مطمئن هستید؟')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        حذف
                                                    </button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" style="text-align: center;padding: 10px">هنوز اطلاعاتی ثبت نشده
                                            است</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div>

    {!! $events->links('pagination::bootstrap-5') !!}

@endsection
