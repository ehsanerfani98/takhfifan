@extends('site.layout')

@section('content')
<div class="container">
    <h3>لیست گفتگوها</h3>
    <ul class="list-group">
        @foreach($conversations as $conv)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>
                    گفتگو با:
                    {{ auth()->user()->hasRole('advisor') ? $conv->user->name : $conv->advisor->name }}
                </span>
                <a href="{{ route('user.chat.room', $conv->id) }}" class="btn btn-sm btn-primary">ورود به چت</a>
            </li>
        @endforeach
    </ul>
</div>
@endsection
