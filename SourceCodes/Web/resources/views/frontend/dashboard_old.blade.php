@extends('frontend.layouts.app')
<?php error_reporting(0); ?>
@section('title', 'Dashboard')
@section('style')
    <style>
        input[type="date"]::-webkit-calendar-picker-indicator {
            opacity: 0;
        }
    </style>
@endsection
@section('content')
    <div class="baner_hea">
        @include('frontend.layouts.header')
    </div>
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-pause="false">
        <ol class="carousel-indicators">
            @forelse ($banner_images as $key => $banner_image)
                <li data-target="#carouselExampleIndicators" data-slide-to="{{ $key }}"
                    class="{{ $key === 0 ? 'active' : '' }}"></li>
            @empty
            @endforelse
        </ol>
        <div class="carousel-inner">
            @forelse ($banner_images as $key => $banner_image)
                <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                    <img src="{{ $banner_image->banner_image }}" class="d-block w-100" alt="..." height="800"
                        width="100%">

                    <!-- banner code start -->
                    <section class="kh banner_content">
                        <div class="container text-white">
                            <div class="row justify-content-center">
                                <div class="col-xl-11 col-lg-12 col-12 mt-md-5 mb-4">
                                    <div class="bg_header">
                                        {!! $banner_image->description !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            @empty
            @endforelse

        </div>
        <!-- banner code start -->
        <!-- countdown code start -->
        <section class="comming_countdown position-ab">
            <div id="countdown">
                <ul>
                    <li><span id="days"></span>days</li>
                    <li><span id="hours"></span>Hours</li>
                    <li><span id="minutes"></span>Minutes</li>
                    <li><span id="seconds"></span>Seconds</li>
                </ul>
            </div>
        </section>
        <!-- countdown code end -->
        <!-- searchbar -->
        <section class="main-banner-vendor text-center d-flex align-items-center justify-content-center" id="back_tp">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="searchwrapper">
                            <div class="searchbox">
                                <div class="container">
                                    <form class="header_searchinput" method="post" action="{{ url('events') }}">
                                        @csrf
                                        <div class="row d-flex justify-content-between align-items-center">
                                            <div class="col-xl-3 col-lg-3 col-md-4 col-12 text-left">
                                                <div class="row d-flex justify-content-center align-items-center">
                                                    <div class="col-md-10 col-12 date-calender">
                                                        <p class="start_date d-md-block mb-0 ">Start date:</p>
                                                        <input value="" class="form-control" name="date"
                                                            type="date" id="date">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-9 col-lg-9 col-md-8 col-12 d-flex">
                                                <div class="form-group has-search mb-0 ">
                                                    <span class="fa fa-search form-control-feedback "></span>
                                                    <input type="text" id="title" name="title"
                                                        class="search_eventtitle form-control"
                                                        placeholder="Search for Event title">
                                                </div>
                                                <div class="input-field second-wrap ">
                                                    <button class="btn-search" type="submit">Search</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- searchbar -->
    </div>

    <div class="main_content overflow-hidden">
        <!-- most popular event code start-->
        <section class="blog-section pt-md-5 mt-md-2">
            <div class="container ">
                <div class="row justify-content-center mb-md-3 pt-3 ">
                    <div class="col-12 ">
                        <div class="row mb-2 ">
                            <div class="col-md-12 col-sm-12 col-12 ">
                                <div class="development-content text-center ">
                                    <h1 class="our_sub_head pb-1"> Events By Category</h1>
                                </div>
                            </div>
                        </div>
                        <!-- row -->

                        <div class="row ">
                            <div class="col-md-12 ">
                                <div class="filters ">
                                    <ul>
                                        <li data-category="all" class="is-checked filter-by-category">ALL</li>
                                        @forelse ($categories as $category)
                                            <li data-category="{{ $category->id }}"
                                                class="text-uppercase filter-by-category"> {{ $category->name }} </li>
                                        @empty
                                        @endforelse

                                    </ul>
                                    @if (count($categories) >= 5 || count($events) > 9)
                                        <div class="input-field view_more_btn">
                                            <a href="{{ url('events') }}" class="text-decoration-none"> <button
                                                    class="btn-search" type="button ">View More</button> </a>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12 px-0 ">
                                {{-- Start Include Events by category list here --}}
                                <div class="rows all-events">
                                    @include('frontend.events-by-category')
                                </div>
                                <div class="rows filter-events"></div>
                                {{-- End Include Events by category list here --}}
                            </div>
                            <!-- col -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- filter code end -->

        <section class="app_our_team text-center pt-md-4 mb-md-3 pb-md-5 mb-5">
            <div class="container ">
                <div class="row justify-content-center mb-md-3">
                    <div class="col-lg-12 col-12">
                        <div class="our_team_topic">
                            <h1 class="our_sub_head mb-md-4 pb-4">Most Popular Events</h1>
                        </div>
                    </div>
                    <div class="col-12 px-md-5">
                        @if (count($popular_events) > 3)
                            <div class="owl-carousel owl_carousel_3 slider-icon pt-2">
                                @forelse ($popular_events as $event)
                                    <div class="item ">
                                        <div class="col-12 ">
                                            <div class="fx1 card-view ">
                                                <a href="{{ url('event/details/' . $event->id) }}">
                                                    <div class="item ">
                                                        <img src="{{ $event->image }}"
                                                            class="app_team_img img-fluid position-relative "
                                                            alt="img ">
                                                        <h4>{{ strlen($event->event_title) > 15 ? mb_substr($event->event_title, 0, 15) . '...' : $event->event_title }}
                                                        </h4>
                                                        <p>{{ date_format(date_create($event->start_date), 'd M Y') }}</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                        @else
                            @forelse ($events as $event)
                                <div class="item ">
                                    <div class="col-3 float-left">
                                        <div class="fx1 card-view ">
                                            <a href="{{ url('event/details/' . $event->id) }}">
                                                <div class="item ">
                                                    <img src="{{ $event->image }}"
                                                        class="app_team_img img-fluid position-relative " alt="img ">
                                                    <h4>{{ strlen($event->event_title) > 15 ? mb_substr($event->event_title, 0, 15) . '...' : $event->event_title }}
                                                    </h4>
                                                    <p>{{ date_format(date_create($event->start_date), 'd M Y') }}</p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <h2 class="text-white">No Record Found</h2>
                            @endforelse
                        @endif
                    </div>
                </div>
            </div>
        </section>
        <!-- code end -->

        <!-- marquee code start -->
        <input type="hidden" id="startDate"
            value="{{ !empty($events[0]) ? $events[0]->start_date . ' ' . $events[0]->start_time : '' }}">
        <input type="hidden" id="endDate"
            value="{{ !empty($events[0]) ? $events[0]->end_date . ' ' . $events[0]->end_time : '' }}">
        @include('frontend.layouts.footer-marque')

    </div>

@endsection


@section('script')
    <script src="{{ asset('frontend/customjs/dashboard.js?v=' . time()) }}"></script>
    <script src="{{ asset('frontend/customjs/event-detail.js?v=' . time()) }}"></script>
@endsection
