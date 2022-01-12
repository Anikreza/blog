<header>
    <nav class="navbar navbar-expand-lg  header">
        <div class="container-fluid">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Meraner Morgen Logo" class="logo">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon material-icons">menu</span>
            </button>

            <div class="collapse navbar-collapse nav-link-area" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @foreach($navigationOptions as $option)
                        <li class="nav-item">
                            <a class="nav-link @if(url()->current() == route('category', ['slug' => Str::slug($option)]) ) active @endif"
                               aria-current="page"
                               href="{{ route('category', ['slug' => Str::slug($option)]) }}">{{ $option }}</a>
                        </li>
                    @endforeach
                </ul>
                <form class="d-flex search-area">
                    {{--                        <input class="hidden" type="search" placeholder="Search" aria-label="Search">--}}
                    <img src="{{ asset('images/icons/search.svg') }}" alt="search" height="22">
                </form>
            </div>
        </div>
    </nav>
</header>
