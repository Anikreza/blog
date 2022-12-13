@extends('master')
@section('content')
<body class="body-wider"  style="background-color: #f6fdef">
<div class="section blog section-x tc-grey">
    <div class="container">
        @include('component.breadcrumb')
        <div class="row gutter-vr-30px ">
                <div class="col-md-8 ">
                    @foreach($categoryArticles as $article)
                    <div class="post post-full ">
                        <div class="col-md-10">
                            <div class="post post-full post-details ">
                                @include('component.card.searchCard',
                                    [
                                        'image' => $article->image,
                                        'title' => $article->title,
                                        'slug' => $article->slug,
                                        'description' => $article->description,
                                        'category' => $category->name,
                                    ])
                            </div>
                        </div>
                    </div><!-- .post -->
                    @endforeach
                </div><!-- .col -->

            <div class="col-md-8 order-md-last">
                <div class="button-area pagination-area">
                    <ul class="pagination text-center text-md-right">
                        {{ $categoryArticles->render("pagination::bootstrap-4") }}
                    </ul>
                </div>
            </div><!-- .col -->
            <div class="col-md-4 pl-lg-4">
                @include('component.card.sideBarCard',['tags'=>$tags,'header'=>'Sea Posts By Tag'])
            </div><!-- .col -->
        </div><!-- .row -->
    </div><!-- .container -->
</div>
<!-- end section/blog -->
</body>
@endsection
