@extends('admin.layout')
@section('title', 'ایجاد مقدار ویژگی')

@section('content')

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                notifier.alert('{{ $error }}', {
                    labels: { alert: 'خطا' },
                })
            </script>
        @endforeach
    @endif

    <form action="{{ route('attribute-values.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">اطلاعات مقدار ویژگی</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>ویژگی</label>
                                    <select name="attribute_id" class="form-control">
                                        @foreach($attributes as $id => $name)
                                            <option value="{{ $id }}" {{ old('attribute_id') == $id ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>مقدار</label>
                                    <input type="text" name="value" class="form-control" value="{{ old('value') }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>نامک</label>
                                    <input type="text" name="slug" class="form-control" value="{{ old('slug') }}">
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
