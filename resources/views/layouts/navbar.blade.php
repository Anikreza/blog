<!-- Header -->
<header class="is-sticky is-shrink is-boxed header-s1" id="header">
    <div class="header-box">
        <div class="header-main">
            <div class="header-wrap">
                <!-- Logo  -->
                <div class="header-logo logo">
                    <a href="/" class="logo-link">
                        <img class="logo-white" src="{{asset("images/logo.png")}}" alt="logo">
                    </a>
                </div>

                <!-- Menu Toogle -->
                <div class="header-nav-toggle">
                    <a href="#" class="search search-mobile search-trigger"><i class="icon ti-search"></i></a>
                    <a href="#" class="navbar-toggle" data-menu-toggle="header-menu">
                        <div class="toggle-line">
                            <span></span>
                        </div>
                    </a>
                </div>
                <!-- Menu Toogle -->

                <!-- Menu -->
                <div class="header-navbar">
                    <nav class="header-menu" id="header-menu">
                        <ul class="menu">
                            @foreach($categories as $key => $category)
                                <li class="nav-item">
                                    <a class="nav-link @if(url()->current() == route('category', ['slug' => $key]) ) active @endif"
                                       aria-current="page"
                                       href="{{ route('category', ['slug' => $key]) }}">{{ strtoupper($category) }}</a>
                                </li>
                            @endforeach
                        </ul>
                            <ul class="menu-btns">
                                <li><a href="" class="btn search search-trigger"><i class="icon ti-search "></i></a>
                                </li>
                            </ul>
                    </nav>
                </div><!-- .header-navbar -->

                <!-- header-search -->
                <div class="header-search">
                    <form role="search" method="POST" class="search-form" action="#">
                        <div class="search-group">
                            <input type="text" class="input-search" placeholder="Search ...">
                            <button class="search-submit" type="submit"><i class="icon ti-search"></i></button>
                        </div>
                    </form>
                </div>
                <!-- . header-search -->
            </div>
        </div>
    </div>
</header>
<!-- end header -->
