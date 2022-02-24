@extends('layouts.app')

@section('content')
<div class="container">
    @foreach($posts as $post)
    <div class="row">
        <div class="col-8 offset-2">
            <a href="/profile/{{ $post->user->id }}">
                <img src="/storage/{{ $post->image }}" class="w-120">
            </a>
        </div>
    </div>
    <div class="row py-3">
        <div class="col-8 offset-2">
            <p><span class="font-weight-bold">
                <a href="/profile/{{ $post->user->id }}">
                    <span class="text-dark">{{ $post->user->username }}</span></span>
                </a> {{ $post->caption }}
            </p>
        </div>
    </div>
    @endforeach
    <div class="row">
        <div class="col-12 d-flex justify-content-center">
            {!! $posts->links() !!}
        </div>
    </div>
</div>
@endsection
