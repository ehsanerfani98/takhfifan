@extends('admin.layout')
@section('title', 'ایجاد آیتم پرونده')

@section('content')

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                notifier.alert('{{ $error }}', {
                    labels: {
                        alert: 'خطا'
                    }
                })
            </script>
        @endforeach
    @endif

    @session('success')
        <script>
            notifier.success('{{ session('success') }}', {
                labels: {
                    success: 'تبریک'
                }
            })
        </script>
    @endsession

    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{ route('car-file-items.store') }}">
                @csrf
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">اطلاعات پرونده "{{ $carFile->title }}"</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">عنوان آیتم</label>
                                    <input type="text" name="title" id="title" class="form-control"
                                        placeholder="عنوان آیتم" value="{{ old('title') }}">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="car_file_id" value="{{ $carFile->id }}">
                        <button type="submit" class="btn btn-success btn-sm">ذخیره</button>
                    </div>
                </div>
            </form>
        </div>
        @can('car-file-items-list')
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">آیتم ها</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($carFile->items as $item)
                                <div class="col-md-1 mb-2">
                                    <div class=" w-100 d-flex flex-column align-items-center text-center"
                                        style="gap: 1rem;border: 1px solid #ed656d;border-radius: 6px">
                                        <div style="margin-top: 6px">{{ $item->title }}</div>
                                        <div>
                                            <label class="badge badge-danger">
                                                <form method="POST" action="{{ route('car-file-items.destroy', $item->id) }}"
                                                    style="display:inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="badge badge-danger border-0"
                                                        style="outline: none;padding: 0"
                                                        onclick="return confirm('آیا حذف شود؟')">حذف</button>
                                                </form>
                                            </label>
                                            <label class="badge badge-danger">
                                                <a href="{{ route('car-file-items.edit', $item->id) }}">ویرایش</a>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endcan


    </div>

@endsection

@push('script')
    <script src="{{ asset('admin/plugins/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        $(".select2").select2({
            rtl: true,
            placeholder: "یک پرونده انتخاب کنید"
        });
    </script>
@endpush
