<header>
    <nav class="navbar navbar-expand-lg  header">
        <div class="container-fluid">
            <a href="{{ route('home') }}">
                @if(isset($logoInfo['img'])  && $logoInfo['img'] && $logoInfo['img'] !== null)
                    <img src="{{ $logoInfo['img'] }}" alt="{{ $logoInfo['title'] }}" class="logo">
                @else
                    {{ env('APP_NAME') }}
                @endif
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon material-icons">menu</span>
            </button>

            <div class="collapse navbar-collapse nav-link-area" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @foreach($categories as $key => $category)
                        <li class="nav-item">
                            <a class="nav-link @if(url()->current() == route('category', ['slug' => $key]) ) active @endif"
                               aria-current="page"
                               href="{{ route('category', ['slug' => $key]) }}">{{ strtoupper($category) }}</a>
                        </li>
                    @endforeach
                </ul>
                <div class="d-flex search-area" onclick="openSearch()">
                    {{--                        <input class="hidden" type="search" placeholder="Search" aria-label="Search">--}}
                    <img src="{{ asset('images/icons/search.svg') }}" class="hide-for-mobile" alt="search" height="22">
                    <span class="hide-for-desktop search-label">Suche</span>
                </div>
            </div>
        </div>
    </nav>
</header>
