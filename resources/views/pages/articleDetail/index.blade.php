@extends('master')
@section('content')
    <div class="section blog section-x">
        <div class="container">
            @include('component.breadcrumb')
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="post post-full post-details">
                        <div class="post-thumb">
                            <img src="{{asset($article->image)}}" alt="">
                        </div>
                        <div class="post-entry d-sm-flex d-block align-items-start">
                            <div class="content-left d-flex d-sm-block">
                                <div class="post-date">
                                    <p>Mar <strong>19</strong></p>
                                </div>
                                <ul class="social text-center">
                                    @foreach($shareLinks as $key=>$link)
                                    <li>
                                        <a href="{{ $link }}" target="_blank" class='pin fab fa-{{$key}}' >
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="post-content post-content-wd">
                                <div class="post-meta d-block d-lg-flex align-items-center">
                                    <div class="post-author d-flex align-items-center flex-shrink-0 align-self-start">
                                        <div class="author-thumb">
                                            <img src="images/author-image-a.jpg" alt="">
                                        </div>
                                        <div class="author-name">
                                            <p>Mark Anthony</p>
                                        </div>
                                    </div>
                                    <div class="post-tag d-flex">
                                        <ul class="post-cat">
                                            <li><a href="{{ route('category', ['slug' =>  $category->slug]) }}"><em
                                                        class="icon ti-bookmark"></em>
                                                    <span>{{ $category->name }}</span></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <h3>{{ $article['title'] }}</h3>
                                <div class="content">
                                    {{--                                <p>The Demodern team is responsible for the diverse solutions of the individual applications,--}}
                                    {{--                                    the overall staging and conception of the 'Discovery Dock. exercitation ullamco laboris nisi --}}
                                    {{--                                    ut aliquip ex ea commodo.On the other hand we denounce with righteous indignation and dislike--}}
                                    {{--                                    men who are so beguiled and demoralized by the charms of pleasure of the moment so blinded by--}}
                                    {{--                                    desire that they cannot foresee the pain and trouble that are bound.</p>--}}
                                    {{--                                <p class="block-text"><em>On the other hand we denounce with righteous indignation and dislike --}}
                                    {{--                                        men who are so beguiled and demoralized by the charms of pleasure of the moment so --}}
                                    {{--                                        blinded by desire that they cannot foresee the pain.</em></p>--}}
                                    {{--                                <p>Exercitation ullamco laboris nisi ut aliquip ex ea commodo.On the other hand we denounce--}}
                                    {{--                                    with righteous indignation and dislike men who are so beguiled and demoralized by the charms--}}
                                    {{--                                    of pleasure of the moment so blinded by desire that they cannot foresee the pain and trouble--}}
                                    {{--                                    that are bound.</p>--}}
                                    <p> {{ $article['description'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- post -->
                    <!-- tags -->
                    <div>
                    <span class="label-primary">
                       TAGS:
                    </span>
                        @foreach($article->keywords as $keyword)
                            <a class="post-tag" href="{{ route('tag', ['slug' => \Str::slug($keyword->title)]) }}">
                                <span
                                    style=" font-size:16px; margin-left: 10px; background-color:#ea4a4a; color: #ffffff; padding: 10px; border-radius: 5px">{{ $keyword->title }}</span>
                            </a>
                        @endforeach
                    </div>
                    <br/>
                    <br/>
                    <!-- tags -->
                    <!-- similar Posts -->

                    <div class="wgs">
                        <div class="section-head">
                            <h4 class="label-primary" style="font-weight: 500">Related Posts</h4>
                        </div>
                        <div class="row gutter-vr-30px ">
                            @foreach($similarArticles as $article)
                                <div class="col-12 col-lg-6 bg-white">
                                    <div class="post post-full post-v2">
                                        @include('component.card.similarArticle',
                                               [
                                                   'image' => $article['image'],
                                                   'title' => $article['title'],
                                                   'slug' => $article['slug'],
                                                   'category' => $article['categories'][0],
                                               ])
                                    </div><!-- .post -->
                                </div><!-- .col -->
                            @endforeach
                        </div><!-- .row -->
                    </div><!-- .wgs -->
                </div><!-- .col -->
            </div><!-- .row -->
        </div><!-- .container -->
    </div>
@endsection
