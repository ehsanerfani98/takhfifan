@extends('admin.layout')
@section('title', 'ویرایش رویداد')

@push('style')
    <link type="text/css" rel="stylesheet" href="{{ asset('admin/plugins/JalaliDatePicker/jalalidatepicker.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/plugins/select2/dist/css/select2.min.css') }}">
@endpush

@section('content')

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                notifier.alert('{{ $error }}', {
                    labels: {
                        alert: 'خطا'
                    },
                })
            </script>
        @endforeach
    @endif


    <form method="POST" action="{{ route('events.update', $event->id) }}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">اطلاعات رویداد</h6>
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label for="contact_id">مخاطب</label>
                            <select name="contact_id" id="contact_id" class="form-control select2" required>
                                @foreach ($user->contacts as $contact)
                                    <option value="{{ $contact->id }}"
                                        {{ $event->contact_id == $contact->id ? 'selected' : '' }}>
                                        {{ $contact->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small>چنانچه مخاطب در سامانه ثبت نام نکرده باشد و همچنین نوتیفیکشن خود را فعال نکرده باشد ، نوتیفیکیشن ارسال نخواهد شد</small>
                        </div>

                        <div class="form-group">
                            <label for="title">عنوان رویداد</label>
                            <input type="text" name="title" id="title" class="form-control"
                                value="{{ old('title', $event->title) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="notes">پیام</label>
                            <textarea name="notes" id="notes" rows="3" class="form-control">{{ old('notes', $event->notes) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">زمان‌بندی و وضعیت</h6>
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label for="type_id">نوع رویداد</label>
                            <select name="type_id" id="type_id" class="form-control select2" required>
                                @foreach ($eventTypes as $type)
                                    <option value="{{ $type->id }}"
                                        {{ $event->type_id == $type->id ? 'selected' : '' }}>
                                        {{ $type->display_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="send_date">تاریخ و زمان ارسال پیام</label>
                            <input data-jdp name="send_date" id="send_date" class="form-control"
                                value="{{ old('send_date', \Morilog\Jalali\Jalalian::fromDateTime($event->send_date)->format('Y/m/d H:i')) }}"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="remind_at">تاریخ و زمان یادآوری</label>
                            <input data-jdp name="remind_at" id="remind_at" class="form-control"
                                value="{{ old('remind_at', \Morilog\Jalali\Jalalian::fromDateTime($event->remind_at)->format('Y/m/d H:i')) }}"
                                required>
                        </div>

                        <button type="submit" class="btn btn-success btn-block">
                            ذخیره تغییرات
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('script')
    <script src="{{ asset('admin/plugins/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/select2/dist/js/i18n/fa.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/plugins/JalaliDatePicker/jalalidatepicker.min.js') }}"></script>
    <script>
        jalaliDatepicker.startWatch({
            time: true,
            hasSecond: false,
            minDate: "today",
            persianDigits: true
        });

        $(".select2").select2({
            rtl: true,
        });

        // document.querySelector('form').addEventListener('submit', function(e) {
        //     const sendDate = new Date(document.getElementById('send_date').value);
        //     const remindAt = new Date(document.getElementById('remind_at').value);

        //     if (remindAt >= sendDate) {
        //         e.preventDefault();
        //         alert('تاریخ یادآوری باید قبل از تاریخ ارسال باشد.');
        //     }
        // });
    </script>
@endpush
