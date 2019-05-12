
@extends('layouts.app')
@section('title')
    Home
@endsection
@section('content')

    <div class="intro intro-carousel">
        <div id="carousel" class="owl-carousel owl-theme">
            <div class="carousel-item-a intro-item bg-image" style="">
                <div class="overlay overlay-a"></div>
                <div class="intro-content display-table">
                    <div class="table-cell">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="intro-body">
                                        <h1 class="intro-title mb-4">
                                            <span class="color-b">Upload </span> Video
                                            <br> And Share Instantly</h1>
                                        <p class="intro-subtitle intro-price">
                                            <a href="/home"><span class="price-a">Upload</span></a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
