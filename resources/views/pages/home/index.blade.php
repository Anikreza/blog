@extends('master')
@section('content')
    @if(count($publishedArticles))
        @include('pages.home.partial.topSection', ['articles' => $publishedArticles ])
    @endif

    @if(count($featuredArticles))
    @include('pages.home.partial.featured',['featuredArticles'=>$featuredArticles])
    @endif

    @if(count($mostReadArticles))
    @include('pages.home.partial.mostRead',['mostReadArticles'=>$mostReadArticles])
    @endif
@endsection
