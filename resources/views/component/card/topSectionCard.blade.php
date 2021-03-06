<div class="post-thumb">
    <a href="{{ route('article-details', ['slug' => $slug]) }}">
        <img src="{{asset($image)}}" style="width: 100%"/>
    </a>
</div>
<div class="post-entry bg-white d-sm-flex d-block align-items-start">
    <div class="post-date">
        <p>Mar <strong>19</strong></p>
    </div>
    <div class="post-content">
        <div class="post-meta d-flex align-items-center">
            <div class="post-author d-flex align-items-center">
                <div class="author-thumb">
                    <a href='/articleDetail'>
                        <img src="{{asset($image)}}"/>
                    </a>
                </div>
                <div class="author-name">
                    <p>Mark Anthony</p>
                </div>
            </div><!-- author -->
            <div class="post-tag">
                <ul class="post-cat">
                    <li><a href="{{ route('category', ['slug' =>  $category->slug]) }}"><em class="icon ti-bookmark"></em> {{$category->name}}</a></li>
                </ul>
            </div><!-- .post-tag -->
        </div>
        <h4><a href="#">{{$title}}</a></h4>
    </div>
</div>


