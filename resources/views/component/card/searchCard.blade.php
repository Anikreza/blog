<div class="post-thumb">
    <a href="{{ route('article-details', ['slug' => $slug]) }}">
        <img src="{{asset($image)}}" alt="" style="width: 100%; box-shadow: 3px 3px 3px 3px #000000; border-radius: 5px">
    </a>
</div>
<div class="post-entry d-sm-flex d-block align-items-start">
    <div class="post-date" >
        <p>Mar <strong>19</strong></p>
    </div>
    <div class="post-content" style=" text-align: justify">
        <div class="post-author d-flex align-items-center">
            <div class="author-thumb">
                <img src="{{asset($image)}}" alt="">
            </div>
            <div class="author-name">
                <p>Mark Anthony</p>
            </div>
            <div class="post-tag d-flex" style="margin-left: 10px">
                <ul class="post-cat">
                    <li><a href="#"><em class="icon ti-bookmark"></em> <span>{{$category}}</span></a></li>
                </ul>
            </div>
        </div>
        <h3><a href="{{ route('article-details', ['slug' => $slug]) }}">{{$title}}</a></h3>
        <div class="content" style="max-height: 152px; overflow: hidden;">
                        {!! $description !!}
        </div>
        <a href="{{ route('article-details', ['slug' => $slug]) }}" class="btn-primary btn-arrow">Read More</a>
    </div>
</div>
