@extends('admin.layout')
@section('title', 'نمایش نقش ها')
@section('actions')
    @can('role-create')
        <a href="{{ route('roles.index') }}" class="btn btn-primary btn-sm btn-icon-split">
            <span class="text-white-50">
                <i class="fas fa-arrow-right"></i>
            </span>
            <span class="text">برگشت</span>
        </a>
    @endcan
@endsection

@section('content')


    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">اطلاعات نقش</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <strong>نقش : </strong>
                        <label class="badge badge-primary">{{ $role->title }}</label>
                    </div>

                    <div class="form-group">
                        <strong>مجوزها : </strong>
                        @if (!empty($rolePermissions))
                            @foreach ($rolePermissions as $v)
                                <label class="badge badge-success">{{ $v->title }}</label>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection