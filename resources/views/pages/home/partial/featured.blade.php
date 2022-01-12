
    <div class="container">
        <div class="row justify-content-center">
            <h5 class="heading-xs dash dash-both">Featured Articles</h5>
        </div>
        <br/>
        <br/>
        <div class="row gutter-vr-30px justify-content-sm-center">
            @foreach($featuredArticles as $article)
                <div class="col-sm-8 col-md-4 text-center">
                    <div class="post post-alt">
                        @include('component.card.featuredCard',
                            [
                                'image' => $article['image'],
                                'title' => $article['title'],
                                'slug' => $article['slug'],
                                'category' => $category ?? $article['categories'][0]['name'],
                            ])
                    </div><!-- .post -->
                </div><!-- .col -->
            @endforeach

        </div><!-- .row -->
    </div><!-- .container -->

