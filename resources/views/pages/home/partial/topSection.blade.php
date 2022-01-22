<div class="section section-l section-news ">
    <br/>
    <div class="container">
        <div class="row justify-content-center">
        </div><!-- .row -->
        <div class="row gutter-vr-30px">
            @foreach($articles as $article)
                <div class="col-md-6">
                    <div class="post post-full post-v2">
                        @include('component.card.topSectionCard',
                            [
                                'image' => $article['image'],
                                'title' => $article['title'],
                                'slug' => $article['slug'],
                                'category' => $category ?? $article['categories'][0],
                            ])
                    </div>
                </div><!-- .col -->
            @endforeach
        </div><!-- .row -->
    </div><!-- .container -->
</div>

