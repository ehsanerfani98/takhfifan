@extends('admin.layout')
@section('title', 'ویرایش آیتم پرونده')

@section('content')

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            notifier.alert('{{ $error }}', { labels: { alert: 'خطا' } })
        </script>
    @endforeach
@endif

<form method="POST" action="{{ route('car-file-items.update', $item->id) }}">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">آیتم پرونده "{{ $item->carFile->title }}"</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">عنوان آیتم</label>
                                <input type="text" name="title" id="title" class="form-control" value="{{ $item->title }}">
                            </div>
                        </div>
                    </div>
                    <a href="{{ url()->previous() }}" class="btn btn-success btn-sm">بازگشت</a>
                    <button type="submit" class="btn btn-success btn-sm">ذخیره</button>

                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@push('script')
<script src="{{ asset('admin/plugins/select2/dist/js/select2.full.min.js') }}"></script>
<script>
$(".select2").select2({ rtl:true, placeholder:"یک پرونده انتخاب کنید" });
</script>
@endpush
