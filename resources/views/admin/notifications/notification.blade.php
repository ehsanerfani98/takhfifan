@extends('admin.layout')
@section('title', 'ارسال نوتیفیکیشن')

@push('style')
    <link rel="stylesheet" href="{{ asset('admin/plugins/select2/dist/css/select2.min.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">ارسال نوتیفیکیشن</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('send.notification') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>گیرندگان</label>
                            <select name="recipients" class="form-control select2" multiple>
                                @foreach ($users as $user)
                                    <option value="{{ $user->device_token }}">
                                        {{ empty($user->phone) || is_null($user->phone) ? $user->email : $user->phone }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>نقش کاربری</label>
                            <select name="roles" class="form-control select2" id="roles" multiple>
                                @foreach ($roles as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ !is_null(old('roles')) ? (in_array($value, old('roles')) ? 'selected' : '') : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>عنوان</label>
                            <input type="text" class="form-control" name="title">
                        </div>
                        <div class="form-group">
                            <label>توضیحات</label>
                            <textarea class="form-control" name="body"></textarea>
                        </div>
                        <button type="button" id="send-notif" class="btn btn-sm btn-danger">ارسال</button>
                    </form>
                </div>
            </div>
        </div>
    @endsection

    @push('script')
        <script src="{{ asset('admin/plugins/select2/dist/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/select2/dist/js/i18n/fa.js') }}"></script>

        <script>
            $(".select2").select2({
                rtl: true
            });
            $(".select2.round").select2({
                rtl: true,
                containerCssClass: "round"
            });
            $(".select2.curve").select2({
                rtl: true,
                containerCssClass: "curve"
            });

            $(".allow-cancel").select2({
                rtl: true,
                allowClear: true,
                placeholder: {
                    id: "",
                    placeholder: "..."
                }
            });


            $('#send-notif').click(function(e) {
                var recipients = $('select[name="recipients"]').val();
                var roles = $('select[name="roles"]').val();
                var btn = $(this);
                var btnText = $(this).text();
                btn.html(btnText + ' <span class="spinner-border spinner-border-sm"></span> ');
                var title = $('input[name="title"]').val();
                var body = $('textarea[name="body"]').val();
                $.ajax({
                    type: "post",
                    url: '{{ route('send.notification') }}',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        title: title,
                        body: body,
                        tokens: recipients,
                        roles: roles
                    },
                    success: function(response) {
                        notifier.success('با موفقیت ارسال شد', {
                            labels: {
                                success: 'تبریک'
                            },
                        })
                        btn.html(btnText);
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON) {
                            notifier.alert(xhr.responseJSON.error, {
                                labels: {
                                    alert: 'خطا'
                                },
                            })
                        }
                        btn.html(btnText);
                    }
                });
            });
        </script>
    @endpush
