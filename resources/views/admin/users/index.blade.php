@extends('admin.layout')
@section('title', 'مدیریت کاربران')

@push('style')
    <style>
        .bg-red {
            background-color: #fa626b;
            color: white;
        }

        .text-red {
            color: #fa626b;
        }

        .list-group-item {
            border: none;
            transition: all 0.3s ease;
        }

        .list-group-item:hover {
            background-color: #f8f9fa;
        }

        .modal-content {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            border-bottom: 1px solid #e9ecef;
            border-radius: 12px 12px 0 0 !important;
        }

        .modal-footer {
            border-top: 1px solid #e9ecef;
            border-radius: 0 0 12px 12px !important;
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
                <h5 class="text-bold-700 my-2 text-white">لیست کاربران</h5>
                <div>
                    @can('role-list')
                        <a href="{{ route('roles.index') }}" class="btn btn-sm text-white border-btn">
                            <span class="menu-title">مدیریت نقش ها</span>
                        </a>
                    @endcan
                    @can('user-create')
                        <a href="{{ route('users.create') }}" class="btn btn-sm text-white border-btn">
                            <span class="text">ایجاد کاربر جدید</span>
                        </a>
                    @endcan
                </div>
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
                                        <th class="border-top-0">نام و نام خانوادگی</th>
                                        <th class="border-top-0">شماره موبایل</th>
                                        <th class="border-top-0">نقش ها</th>
                                        <th class="border-top-0" width="300px">اقدامات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $key => $user)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ optional($user->document)->first_name . ' ' . optional($user->document)->last_name }}
                                            </td>
                                            <td>{{ $user->phone }}</td>
                                            <td>
                                                @if (!empty($user->getRoleNames()))
                                                    @foreach ($user->roleObjects as $role)
                                                        <label class="badge badge-success">{{ $role->title }}</label>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                                                    data-target="#actionsModal-{{ $user->id }}">
                                                    گزینه ها
                                                </button>

                                                <div class="modal fade" id="actionsModal-{{ $user->id }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="actionsModalLabel-{{ $user->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-red">
                                                                <h6 class="modal-title font-weight-bold text-white"
                                                                    id="actionsModalLabel-{{ $user->id }}">
                                                                    <i class="fas fa-user-cog mr-1"></i>
                                                                    اقدامات کاربر
                                                                </h6>
                                                                <button type="button" class="close text-white" data-dismiss="modal"
                                                                    aria-label="بستن">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body p-0">
                                                                <div class="list-group list-group-flush">
                                                                    @can('user-edit')
                                                                        <a href="{{ route('users.edit', $user->id) }}"
                                                                            class="list-group-item list-group-item-action d-flex align-items-center py-1">
                                                                            <i class="fas fa-edit text-red"></i>
                                                                            <span class="flex-grow-1">ویرایش اطلاعات
                                                                                کاربر</span>
                                                                            <i class="fas fa-chevron-left text-muted"></i>
                                                                        </a>
                                                                    @endcan

                                                                    <a href="{{ route('documents.show', $user->id) }}"
                                                                        class="list-group-item list-group-item-action d-flex align-items-center py-1">
                                                                        <i class="fas fa-id-card text-red"></i>
                                                                        <span class="flex-grow-1">مشاهده پروفایل</span>
                                                                        <i class="fas fa-chevron-left text-muted"></i>
                                                                    </a>

                                                                    <a href="{{ route('transactions.show', $user->id) }}"
                                                                        class="list-group-item list-group-item-action d-flex align-items-center py-1">
                                                                        <i
                                                                            class="fas fa-exchange-alt text-red"></i>
                                                                        <span class="flex-grow-1">مدیریت تراکنش‌ها</span>
                                                                        <i class="fas fa-chevron-left text-muted"></i>
                                                                    </a>

                                                                    <a href="{{ route('wallets.show', $user->id) }}"
                                                                        class="list-group-item list-group-item-action d-flex align-items-center py-1">
                                                                        <i class="fas fa-wallet text-red"></i>
                                                                        <span class="flex-grow-1">مدیریت کیف پول</span>
                                                                        <i class="fas fa-chevron-left text-muted"></i>
                                                                    </a>

                                                                    <a href="{{ route('subscriptions.show', $user->id) }}"
                                                                        class="list-group-item list-group-item-action d-flex align-items-center py-1">
                                                                        <i class="fas fa-star text-red"></i>
                                                                        <span class="flex-grow-1">مدیریت اشتراک‌ها</span>
                                                                        <i class="fas fa-chevron-left text-muted"></i>
                                                                    </a>

                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>


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
    </div>




    {!! $data->links('pagination::bootstrap-5') !!}


@endsection
