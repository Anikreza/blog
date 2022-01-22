@extends('master')
@section('content')
    <div class="section blog section-x">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="post post-full post-details">
                        <div class="post-entry d-sm-flex d-block align-items-start">
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
                                </div>
                                <h3>{{ $page['title'] }}</h3>
                                <div class="content">
                                    <p>  {!! $page['description'] !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br/>
                </div><!-- .col -->
            </div><!-- .row -->
        </div><!-- .container -->
    </div>
@endsection
