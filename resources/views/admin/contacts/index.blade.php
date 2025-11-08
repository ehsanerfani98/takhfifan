@extends('admin.layout')
@section('title', 'مدیریت مخاطبین')

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
                <h5 class="text-bold-700 my-2 text-white">لیست مخاطبین</h5>
                @can('contact-create')
                    <a href="{{ route('contacts.create') }}" class="btn btn-sm text-white border-btn">
                        <span class="text">ایجاد مخاطب جدید</span>
                    </a>
                @endcan
            </div>

            <div class="card">
                <div class="card-body">
                    <div id="recent-contacts" class="media-list position-relative">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped compact dataTable" id="recent-contacts-table"
                                style="text-align: center;">
                                <thead>
                                    <tr>
                                        <th class="border-top-0">شناسه</th>
                                        <th class="border-top-0">نام مخاطب</th>
                                        <th class="border-top-0">شماره تلفن</th>
                                        <th class="border-top-0">ایمیل</th>
                                        <th class="border-top-0">وضعیت در سامانه</th>
                                        <th class="border-top-0">وضعیت نوتیفیکیشن</th>
                                        <th class="border-top-0">تاریخ ایجاد</th>
                                        <th class="border-top-0" width="200px">اقدامات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($contacts as $key => $contact)
                                        @php
                                            $user = App\Models\User::where('phone', $contact->phone);
                                        @endphp
                                        <tr>
                                            <td>{{ ($contacts->currentPage() - 1) * $contacts->perPage() + $key + 1 }}</td>
                                            <td>{{ $contact->name }}</td>
                                            <td>{{ $contact->phone ?? '-' }}</td>
                                            <td>{{ $contact->email ?? '-' }}</td>
                                            <td>
                                                @if ($user->exists())
                                                    <span class="badge badge-success">ثبت نام کرده است</span>
                                                @else
                                                    <span class="badge badge-danger">ثبت نام نکرده است</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($user->exists())
                                                    @if (!empty($user->first()->device_token) || !is_null($user->first()->device_token))
                                                        <span class="badge badge-success">فعال</span>
                                                    @else
                                                        <span class="badge badge-danger">غیرفعال</span>
                                                    @endif
                                                @else
                                                    <span class="badge badge-danger">ثبت نام نکرده است</span>
                                                @endif
                                            </td>
                                            <td>{{ jdate($contact->created_at)->format('Y/m/d H:i') }}</td>
                                            <td>
                                                @can('contact-edit')
                                                    <a href="{{ route('contacts.edit', $contact->id) }}"
                                                        class="btn btn-primary btn-sm">
                                                        ویرایش
                                                    </a>
                                                @endcan

                                                @can('contact-delete')
                                                    <form class="d-inline" method="POST"
                                                        action="{{ route('contacts.destroy', $contact->id) }}"
                                                        onsubmit="return confirm('آیا از حذف این مخاطب مطمئن هستید؟')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            حذف
                                                        </button>
                                                    </form>
                                                @endcan

                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" style="text-align: center;padding: 10px">هنوز اطلاعاتی ثبت
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

    {!! $contacts->links('pagination::bootstrap-5') !!}

@endsection
