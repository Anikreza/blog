@extends('master')
@section('content')
    @if(count($slidersArticles))
        @include('pages.home.partial.topSection', ['articles' => $slidersArticles ])
    @endif
    @include('pages.home.partial.center')
    @include('pages.home.partial.mostRead')
@endsection
