@extends('admin.layout')
@section('title', 'بایگانی نوتیفیکیشن ها')


@section('content')

    <div class="row">
        <div class="col-12">
            <div class="px-2 d-flex align-items-center justify-content-between">
                <h5 class="text-bold-700 my-2 text-white">بایگانی نوتیفیکیشن ها</h5>
                @can('contact-create')
                    <a href="{{ route('notifications.notification') }}" class="btn btn-sm text-white border-btn">
                        <span class="text">ارسال نوتیفیکیشن جدید</span>
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
                                        <th>عنوان</th>
                                        <th>توضیحات</th>
                                        {{-- <th>دریافت کننده ها</th> --}}
                                        <th>تاریخ ارسال</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($notifications as $notification)
                                        <tr>
                                            <td>{{ $notification->title }}</td>
                                            <td>{{ $notification->body }}</td>
                                            {{-- <td>
                                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                    data-target="#exampleModalCenter{{ $notification->id }}">نمایش</button>

                                                      <div class="modal fade" id="exampleModalCenter{{ $notification->id }}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                          <div class="modal-content">
                                                            <div class="modal-body text-left">
                                                                @foreach (unserialize($notification->receivers) as $item)
                                                                    <div class="bg-success text-white mb-1 p-1">{{ App\Models\User::where('device_token',$item)->first()->phone }}</div>
                                                                @endforeach
                                                            </div>
                                                          </div>
                                                        </div>
                                                      </div>
                                            </td> --}}
                                            <td>{{ $notification->created_at }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" style="text-align: center;padding: 10px">هنوز اطلاعاتی ثبت نشده است</td>
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
