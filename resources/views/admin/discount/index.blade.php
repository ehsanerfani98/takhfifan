@extends('admin.layout')
@section('title', 'لیست کدهای تخفیف')


@section('content')

    <div class="row">
        <div class="col-12">
            <div class="px-2 d-flex align-items-center justify-content-between">
                <h5 class="text-bold-700 my-2 text-white">لیست کدهای تخفیف</h5>
                @can('user-create')
                    <a href="{{ route('discounts.create') }}" class="btn btn-sm text-white border-btn">
                        <span class="text">افزودن کد تخفیف</span>
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
                                        <th>عنوان</th>
                                        <th>کد تخفیف</th>
                                        <th>مبلغ</th>
                                        <th>درصد</th>
                                        <th>نوع تخفیف</th>
                                        <th>تعداد مجاز استفاده</th>
                                        <th>تاریخ انقضا</th>
                                        <th>وضعیت</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($discounts as $discount)
                                        <tr>
                                            <td data-label="عنوان">{{ $discount->title }}</td>
                                            <td data-label="کد تخفیف">{{ $discount->code }}</td>
                                            <td data-label="مبلغ">{{ number_format($discount->amount) }} تومان</td>
                                            <td data-label="درصد">{{ $discount->percent }}%</td>
                                            <td data-label="نوع تخفیف">
                                                @if ($discount->getRawOriginal('type') == 'amount')
                                                    <span class="badge badge-primary">مبلغی</span>
                                                @else
                                                    <span class="badge badge-success">درصدی</span>
                                                @endif
                                            </td>
                                            <td data-label="تعداد مجاز استفاده">
                                                {{ $discount->limitdiscount == 0 ? 'نامحدود' : $discount->limitdiscount }}
                                            </td>
                                            <td data-label="تاریخ انقضا">{{ jdate($discount->expiration)->format('Y/m/d') }}
                                            </td>

                                            <td data-label="وضعیت">
                                                @if ($discount->getRawOriginal('status') == 'enable')
                                                    <span class="badge badge-success">فعال</span>
                                                @else
                                                    <span class="badge badge-danger">غیرفعال</span>
                                                @endif
                                            </td>
                                            <td data-label="عملیات">
                                                <a href="{{ route('discounts.edit', $discount->id) }}"
                                                    class="btn btn-primary btn-sm btn-icon-split">
                                                    ویرایش
                                                </a>
                                                <form action="{{ route('discounts.destroy', $discount->id) }}"
                                                    method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm btn-icon-split"
                                                        onclick="return confirm('آیا از حذف این کد تخفیف مطمئن هستید؟')">
                                                        حذف
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" style="text-align: center;padding: 10px">هنوز اطلاعاتی ثبت
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



@endsection
