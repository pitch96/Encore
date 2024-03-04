@extends('frontend.layouts.default')
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
   
<!-- Start search section -->
<section class="section-gapping search-section">
    <div class="container">
        <form action="{{ url('events') }}" method="GET">
            <div class="form-group">
                <div class="form-control">
                    <input type="text" placeholder="Search for artist and events" name="title" class="input-fields large-fields app-form-text">
                </div>
                <div class="form-control">
                    <input type="text" id="dates1" name="dates" class="input-fields input-date app-form-text" value="01/01/2018 - 01/15/2018" />
                </div>
                <div class="form-control">
                    <input type="text" placeholder="Zip Code" name="zipcode" class="input-fields">
                </div>
                <div class="form-control search-btn">
                    <input type="submit" value="submit" class="input-submit app-form-text">
                </div>
            </div>
        </form>
    </div>
</section>
<!-- End search section -->

<!-- Start blog Section -->
<section class="blog-section">
    <div class="container">
        <div class="blog-post">
            <div class="blog-item">
                <div class="blog-full">
                    @if($random_popular_events-> count() > 0)
                    <a href="{{ url('event/details/' . $random_popular_events[0]->id) }}" class="blog-post-link">
                        <div class="blog-post-picture">
                            <img src="{{ $random_popular_events[0]->image }}" alt="post">
                        </div>
                        <h2 class="blog-post-title category-title">
                        {{ strlen($random_popular_events[0]->event_title) > 100 ? mb_substr($random_popular_events[0]->event_title, 0, 100) . '...' : $random_popular_events[0]->event_title }}
                        </h2>
                        <p>
                        {{ $random_popular_events[0]->description }}
                        </p>
                    </a>
                    @else 
                    <a href="{{ url('sales') }}" class="blog-post-link">
                        <div class="blog-post-picture">
                            <img src="{{ asset('frontend/images/blog/event_promote1.jpg') }}" alt="post">
                        </div>
                        <h2 class="blog-post-title category-title">
                            Promote your event
                        </h2>
                        <p>
                        Event organizers and promoters, showcase your upcoming event with us, and we'll manage all aspects of your ticket sales.
                        </p>
                        <a href="{{ url('sales') }}">Learn more</a>
                    </a>
                    @endif
                    
                </div>
                @if($events -> count() > 0)
                <div class="blog-view hidden-mobile">
                    <a href="{{ url('events') }}" class="btn-common">View Available Tickets</a>
                </div>
                @endif
            </div>
            <div class="blog-item">
                <div class="blog-half">
                @if($random_popular_events-> count() > 1)
                    <a href="{{ url('event/details/' . $random_popular_events[1]->id) }}" class="blog-post-link">
                        <div class="blog-post-picture">
                            <img src="{{ $random_popular_events[1]->image }}" alt="post">
                        </div>
                        <h2 class="blog-post-title category-title">
                        {{ strlen($random_popular_events[1]->event_title) > 50 ? mb_substr($random_popular_events[1]->event_title, 0, 50) . '...' : $random_popular_events[1]->event_title }}
                        </h2>
                        <p>
                        {{ $random_popular_events[1]->description }}
                        </p>
                    </a>
                    @else 
                    <a href="{{ url('sales') }}" class="blog-post-link">
                        <div class="blog-post-picture">
                            <img src="{{ asset('frontend/images/blog/event_ticket1.jpg') }}" alt="post">
                        </div>
                        <h2 class="blog-post-title category-title">
                            Sell event tickets
                        </h2>
                        <p>
                        Calling all event promoters and organizers! Amplify your event ticket promotion by partnering with us, and we'll take care of the rest for you.
                        </p>
                        <a href="{{ url('sales') }}">Learn more</a>
                    </a>
                    @endif 
                </div>
                <div class="blog-half">
                @if($random_popular_events-> count() > 2)
                    <a href="{{ url('event/details/' . $random_popular_events[2]->id) }}" class="blog-post-link">
                        <div class="blog-post-picture">
                            <img src="{{ $random_popular_events[2]->image }}" alt="post">
                        </div>
                        <h2 class="blog-post-title category-title">
                        {{ strlen($random_popular_events[2]->event_title) > 50 ? mb_substr($random_popular_events[2]->event_title, 0, 50) . '...' : $random_popular_events[2]->event_title }}
                        </h2>
                        <p>
                        {{ $random_popular_events[2]->description }}
                        </p>
                    </a>
                @else 
                <a href="{{ url('sales') }}" class="blog-post-link">
                        <div class="blog-post-picture">
                            <img src="{{ asset('frontend/images/blog/event_pass1.jpg') }}" alt="post">
                        </div>
                        <h2 class="blog-post-title category-title">
                            Sell event passes
                        </h2>
                        <p>
                        Elevate your event ticket marketing and sales – sign up with us today!                        
                        </p>
                        <a href="{{ url('sales') }}">Learn more</a>
                    </a>
                @endif 
                </div>
            </div>
        </div>
        @if($events -> count() > 0)
        <div class="blog-view hidden-desktop">
            <a href="#" class="btn-common">View Available Tickets</a>
        </div>
        @endif

    </div>
</section>
<!-- End blog Section -->

<!-- Start category section -->
<section class="category-section section-gapping">
    <div class="container">
        <div class="heading-wrap">
            <h2 class="main-title">
                EVENTS BY CATEGORY
            </h2>
            @if($categories -> count() > 4)
            <a href="{{ url('events') }}">
                View All Categories
            </a>
            @endif
        </div>
        <div class="grid-container grid-4">
                <a href="{{ url('events?category_id=1') }}" class="grid-item">
                    <div class="category-content">
                        <div class="category-picture">
                            <img src="{{ asset('frontend/images/category/concerts.png') }}" alt="category">
                        </div>
                        <h2 class="category-title dashboard-category-title">
                            Concerts
                        </h2>
                    </div>
                </a>
                <a href="{{ url('events?category_id=2') }}" class="grid-item">
                    <div class="category-content">
                        <div class="category-picture">
                            <img src="{{ asset('frontend/images/category/arts.png') }}" alt="category">
                        </div>
                        <h2 class="category-title dashboard-category-title">
                            Arts and Theater
                        </h2>

                    </div>
                </a>
                <a href="{{ url('events?category_id=3') }}" class="grid-item">
                    <div class="category-content">
                        <div class="category-picture">
                            <img src="{{ asset('frontend/images/category/sports.png') }}" alt="category">
                        </div>
                        <h2 class="category-title dashboard-category-title">
                            Sports
                        </h2>
                    </div>
                </a>
                <a href="{{ url('events?category_id=4') }}" class="grid-item">
                    <div class="category-content">
                        <div class="category-picture">
                            <img src="{{ asset('frontend/images/category/museums.png') }}" alt="category">
                        </div>
                        <h2 class="category-title dashboard-category-title">
                            Museums
                        </h2>
                    </div>
                </a>
        </div>
    </div>
</section>
<!-- End category section -->

<!-- Start event section -->
<section class="event-section footer-radius section-gapping">
    <div class="container">
        @if($random_popular_events-> count() > 0) 
            <div class="heading-wrap">
            <h2 class="main-title">
                POPULAR EVENTS
            </h2>
            @if($popular_events->count() > 4) 
                <a href="{{ url('events') }}">
                View All Events
            </a>
            @endif
        </div>
        <div class="grid-container grid-4">
            @forelse ($random_popular_events as $event)
            <a href="{{ url('event/details/' . $event->id) }}" class="grid-item">
                <div class="category-content">
                    <div class="category-picture">
                        <img src="{{ $event->image }}" alt="events">
                    </div>
                    <h4 class="category-title dashboard-category-title">
                        {{ strlen($event->event_title) > 50 ? mb_substr($event->event_title, 0, 50) . '...' : $event->event_title }}
                    </h4>
                    <p>
                        {{ $event->description }}
                    </p>
                </div>
            </a>
            @empty
   
            @endforelse
            
        </div>

        @endif
   
    </div>
</section>
<!-- End category section -->


@endsection


@section('script')
    <script src="{{ asset('frontend/customjs/dashboard.js?v=' . time()) }}"></script>
    <script src="{{ asset('frontend/customjs/event-detail.js?v=' . time()) }}"></script>
@endsection
