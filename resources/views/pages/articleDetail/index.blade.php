@extends('master')
@include('layouts.navbar')
<div class="section blog section-x">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="post post-full post-details">
                    <div class="post-thumb">
                        <img src="{{ $article['image'] }}" alt="">
                    </div>
                    <div class="post-entry d-sm-flex d-block align-items-start">
                        <div class="content-left d-flex d-sm-block">
                            <div class="post-date">
                                <p>Mar <strong>19</strong></p>
                            </div>
                            <ul class="social text-center">
                                <li><a href="" class="fac fab fa-facebook-f"></a></li>
                                <li><a href="" class="twi fab fa-twitter"></a></li>
                                <li><a href="" class="pin fab fa-pinterest-p"></a></li>
                                <li><a href="" class="goo fab fa-google-plus-g"></a></li>
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
                                        <li><a href="#"><em class="icon ti-bookmark"></em>
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
                </div><!-- post -->

                <!-- similar Posts -->

                <div class="wgs">
                    <div class="section-head">
                        <h3 class="wgs-heading mb-10">Related Posts</h3>
                    </div>
                    <div class="row gutter-vr-30px">
                        @foreach($similarArticles as $article)
                        <div class="col-12 col-lg-6">
                            <div class="post post-full post-v2">
                                @include('component.card.similarArticle',
                                       [
                                           'image' => $article['image'],
                                           'title' => $article['title'],
                                           'slug' => $article['slug'],
                                           'category' => $article['categories'][0]['name'],
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
