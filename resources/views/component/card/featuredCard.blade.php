<div class="post-thumb">
    <a href="{{ route('article-details', ['slug' => $slug]) }}">
        <img src="{{asset($image)}}" style="width: 100%"/>
    </a>
</div>
<div class="post-content">
    <ul class="post-tag">
        <li><a href="">
                <span>DECEMBER 08, 2018</span></a>
        </li>
    </ul>
    <h4><a href="{{ route('article-details', ['slug' => $slug]) }}">{{$title}}</a></h4>
    <p style="height: 55px; overflow: hidden; margin-top: 10px"> {{$description}}</p>
    <a href="{{ route('article-details', ['slug' => $slug]) }}" class="btn-primary btn-arrow">Read More</a>
</div>
