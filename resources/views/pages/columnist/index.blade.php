@extends('master')
@section('content')
    <div class="section blog section-x">
        <div class="container">
            @include('component.breadcrumb')
            <div class="row columnist-row">
                    <div class="col col-md-4 col-12">
                        <img src="{{ asset('images/about-a.jpg') }}"
                             class="d-block img-fluid img-thumbnail"
                             alt="Tanvir Reza Anik">
                    </div>
                    <div class="col col-md-8 col-12 columnist-info">
                        <h2>Tanvir Reza Anik</h2>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean pulvinar ac dolor vel posuere. Praesent condimentum scelerisque nisi, ac lacinia dolor feugiat id. Donec elementum porttitor imperdiet. Nunc tellus mauris, ullamcorper iaculis dapibus id, maximus in lorem. Suspendisse porttitor ante id diam aliquam, a ornare augue congue. Sed non mollis quam, vel tempus felis. Nunc fringilla vehicula tristique. Proin semper mauris eu neque ultrices luctus.
                        </p>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean pulvinar ac dolor vel posuere. Praesent condimentum scelerisque nisi, ac lacinia dolor feugiat id. Donec elementum porttitor imperdiet. Nunc tellus mauris, ullamcorper iaculis dapibus id, maximus in lorem. Suspendisse porttitor ante id diam aliquam, a ornare augue congue. Sed non mollis quam, vel tempus felis. Nunc fringilla vehicula tristique. Proin semper mauris eu neque ultrices luctus.
                        </p>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean pulvinar ac dolor vel posuere. Praesent condimentum scelerisque nisi, ac lacinia dolor feugiat id. Donec elementum porttitor imperdiet. Nunc tellus mauris, ullamcorper iaculis dapibus id, maximus in lorem. Suspendisse porttitor ante id diam aliquam, a ornare augue congue. Sed non mollis quam, vel tempus felis. Nunc fringilla vehicula tristique. Proin semper mauris eu neque ultrices luctus.
                        </p>
                    </div>
                </div>
            </div>
        </div>
@endsection
