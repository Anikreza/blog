<div class="post-thumb">
    <a href="{{ route('article-details', ['slug' => $slug]) }}">
        <img src={{$image}} alt="">
    </a>
</div>
<div class="post-entry bg-secondary d-sm-flex d-block align-items-start">
    <div class="post-date">
        <p>Mar <strong>19</strong></p>
    </div>
    <div class="post-content post-content-s2">
        <div class="post-meta d-flex align-items-center">
            <div class="post-author d-flex align-items-center">
                <div class="author-thumb">
                    <img src="images/author-image-a.jpg" alt="">
                </div>
                <div class="author-name">
                    <p>Mark Anthony</p>
                </div>
            </div><!-- author -->
            <div class="post-tag">
                <ul class="post-cat">
                    <li>
                        <a href="#"><em class="icon ti-bookmark"></em>
                            <span>{{$category}}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <h3>{{ $title}}</h3>
    </div>
</div>
