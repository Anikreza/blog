<div class="section section-l bg-secondary section-news">
    <div class="container">
        <div class="row justify-content-center">
        </div><!-- .row -->
        <div class="row gutter-vr-30px">
            <div class="col-md-6">
                @foreach($articles as $article)
                    <div>
                        @include('component.card.topSectionCard',
                            [
                                'image' => $article['image'],
                                'title' => $article['title'],
                                'slug' => $article['slug'],
                                'category' => $category ?? $article['categories'][0]['name'],
                            ])
                    </div>
                @endforeach
            </div><!-- .col -->
        </div><!-- .row -->
    </div><!-- .container -->
</div>
