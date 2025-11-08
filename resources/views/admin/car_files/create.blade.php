@extends('admin.layout')
@section('title', 'ایجاد پرونده')

@section('content')

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            notifier.alert('{{ $error }}', { labels: { alert: 'خطا' } })
        </script>
    @endforeach
@endif

<form method="POST" action="{{ route('car-files.store') }}">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">اطلاعات پرونده</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">عنوان پرونده</label>
                                <input type="text" name="title" id="title" class="form-control" placeholder="عنوان پرونده" value="{{ old('title') }}">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success btn-sm">ذخیره</button>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection
