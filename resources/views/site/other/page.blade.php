@extends('site.layout')
@section('title', $page->title)

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="card-header mb-3">
            {{ $page->title }}
            </div>
            <img src="{{ asset($page->featured_image) }}" style="width: 100%" alt="{{ $page->title }}">
            <div style="font-size: 14px;line-height: 1;margin-top: 1rem">
                {!! $page->description !!}
            </div>
        </div>
    </div>
@endsection
