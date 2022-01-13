<div class="post-thumb">
    <a href="{{ route('article-details', ['slug' => $slug]) }}">
        <img src="{{asset($image)}}" alt="">
    </a>
</div>
<div class="post-entry d-sm-flex d-block align-items-start">
    <div class="post-date">
        <p>Mar <strong>19</strong></p>
    </div>
    <div class="post-content">
        <div class="post-author d-flex align-items-center">
            <div class="author-thumb">
                <img src="{{asset($image)}}" alt="">
            </div>
            <div class="author-name">
                <p>Mark Anthony</p>
            </div>
        </div>
        <h3><a href="{{ route('article-details', ['slug' => $slug]) }}">{{$title}}</a></h3>
        <div class="content">
            <p>{{$excerpt}}</p>
        </div>
        <div class="post-tag d-flex">
            <ul class="post-cat">
                <li><a href="#"><em class="icon ti-bookmark"></em> <span>{{$category}}</span></a></li>
            </ul>
        </div>
    </div>
</div>
