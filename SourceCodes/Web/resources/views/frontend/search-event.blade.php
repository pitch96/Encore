@extends('frontend.layouts.default')
@section('title', 'Search Events')
@section('style')
    <style>
        input[type="date"]::-webkit-calendar-picker-indicator {
            opacity: 0;
        }
    </style>
@endsection

@section('content')
    <div class="searchevent_banner1 main-section section-gapping">
        <div class="container">
            <!-- banner code start -->
            <section class="kh">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-11 col-lg-12 col-12 mt-md-5 mb-4">
                            <div class="searchevent_header">
                                <h1 class="main-title text-center">Events</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- banner code start -->

            <!-- searchbar -->
            <section class="main-banner-vendor pt-5" id="back_tp">

            <div class="searchbox">
                    <div class="header_searchinput">
                        <form action="" method="get">
                            <div class="event-search-wr row d-flex justify-content-between align-items-center no-bg">
                                <div class="form-control">
                                    <select class="catergory_dropdown input-fields" name="category_id"
                                        id="category_id">
                                        <option value="">All Categories</option>
                                        @if (count($categories) > 0)
                                            @foreach ($categories as $category)
                                                <option @if ($category->id == request()->get('category_id')) selected @endif
                                                    value="{{ $category->id }}">{{ $category->name }}
                                                </option>
                                            @endforeach
                                        @else
                                            <option value=""> No category found </option>
                                        @endif
                                    </select>

                                </div>

                                <div class="form-control">
                                    <input type="text" id="title" name="title" class="input-fields search_eventtitle"
                                        placeholder="Search for Event title" value="{{ request()->title }}">
                                </div>
                                <div class="form-control">
                                    <input type="text" id="dates2" name="dates" class="input-fields input-date app-form-text" value="{{ request()->dates }}" />
                                </div>
                                <div class="form-control">
                                <input type="text" placeholder="Zip Code" name="zipcode" class="input-fields" value="{{ request()->zipcode }}">
                                </div>
                                <div class="form-control search-btn">
                                    <input type="submit" value="submit" class="input-submit app-form-text">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
            <!-- searchbar -->

            <section class="event-summary d-flex">
                <div id="eventListwrapper" class="event-ticket-table">
                    <table class="">
                        <thead>
                            <tr>
                                <th></th>
                                <th style="width:7%">Event Title</th>
                                <th>Details</th>
                                <th>Venue</th>
                                <th>Date/Time</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($events as $event)
                            <tr>
                                <td>
                                    <div class="event-img">
                                        <img src="{{ $event->image }}" alt="event">
                                    </div>
                                </td>
                                <td>
                                    <p>
                                        {{ Str::length($event->event_title) > 20 ? substr($event->event_title, 0, 20) . '...' : $event->event_title }}
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        {{ $event->description }}
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        {{ $event->venue }}, {{ $event->address }}, {{ $event->city }}, {{ $event->zipcode }}
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        {{ date('F d, Y', strtotime($event->start_date)) }}, {{ date('h A', strtotime($event->start_time)) }}
                                    </p>
                                </td>
                                <td class="events-table__cell" data-label="Availability">
                                    <a href="{{ url('event/details/'.$event->id) }}" class="event__cta" data-id="{{ $event->id }}" title="Book Programme Now">Buy Tickets</a>
                                </td>
                            </tr>
                            @empty
                                <tr class="sm-thrd">
                                    <td colspan="7" class="text-center text-white">No records found</td>
                                </tr>
                            @endforelse
                        </tbody>
                      </table>
                    <table class="events-table" style="display: none">
                        <tbody>
                            @foreach($events as $event)
                                <tr class="events-table__row members-event">
                                    <td class="events-table__cell events-table__cell--date" data-label="Date">
                                        <table>
                                            <tr>
                                                <td style="width:60%"><img src="{{ $event->image }}" alt="{{ $event->event_title }}"></td>
                                                <td class="search-event-row-date-month">
                                                    <span>{{ date('F d', strtotime($event->start_date)) }}</span>
                                                    <span>{{ date('D', strtotime($event->start_date)) }}, {{ date('h:i a', strtotime($event->start_time)) }}</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td class="events-table__cell events-table__cell--description" data-label="Description">
                                        <h3 class="member-event__heading search-event-row-event-title">{{ $event->event_title }}</h3>
                                        <p class="members-event__summary">{{ $event->description }}</p>
                                        <p class="members-event__venue">{{ $event->venue }}</p>
                                    </td>
                                    <td class="events-table__cell" data-label="Availability">
                                        <a href="{{ url('event/details/'.$event->id) }}" class="event__cta" data-id="{{ $event->id }}" title="Book Programme Now">Buy Tickets</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
 
@endsection

@section('script')
    <script src="{{ asset('frontend/customjs/dashboard.js?v=' . time()) }}"></script>
@endsection
