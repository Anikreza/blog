<div class="post-thumb">
    <a href="{{ route('article-details', ['slug' => $slug]) }}">
        <img src="{{asset($image)}}" style="width: 100%"/>
    </a>
</div>
<div class="post-content">
    <p class="post-tag">DECEMBER 08, 2018</p>
    <h4><a href="/articleDetail">{{$title}}</a></h4>
    <a href="/articleDetail" class="btn btn-arrow">Read More</a>
</div>
