@extends('frontend.layouts.default')
<?php error_reporting(0); ?>

@section('content')

    <div class="event_detail_banner1 main-section section-gapping">

        
        <!-- banner code start -->
        <section class="kh">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-11 col-lg-12 col-12 mt-md-5 mb-4">
                        <div class="event-deatil-header text-center">
                            <h1 class="hero-heading mb-md-3 hero-color">{{ $event->event_title }}</h1>
                            <p class="quote_para1 mb-0">{{ $event->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- countdown code start -->
        <!-- <section class="event_detail_timing comming_countdown">
            <div id="countdown">
                <ul>
                    <li><span id="days"></span>days</li>
                    <li><span id="hours"></span>Hours</li>
                    <li><span id="minutes"></span>Minutes</li>
                    <li><span id="seconds"></span>Seconds</li>
                </ul>
            </div>
        </section> -->
        <!-- countdown code end -->
        <section class="main-section section-gapping act_system_section pt-5 mt-5">
            <div class="container">
                <div class="d-flex event-single-ct">
                    <div class="abt-left-section">

                        <div>

                        </div>

                        <table class="register_table" width="100%" height="300px" align="center">
                            <!---row1--->
                            <tbody>
                                <tr>
                                    <td colspan="2">
                                        <div class="register_details text-left "> 
                                            <h4 class="hero-color event-time">  {{ date('F d, Y', strtotime($event->start_date)) }} at {{ date('h A', strtotime($event->start_time)) }} - {{ date('F d, Y', strtotime($event->end_date)) }} at {{ date('h A', strtotime($event->end_time)) }}</h4>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div class="register_details text-left "> 
                                            <strong>Venue:</strong>
                                            <p class="hero-color">{{ $event->venue }}, {{ $event->address }}, {{ $event->city }},
                                                {{ $event->zipcode }}</p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="register_details text-left"> <i class="fa fa-ticket"
                                                aria-hidden="true"></i>
                                            <span class="span_details text-left">Type Ticket</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="register_date text-right no-bg">
                                            <select class="type_ticket ticket_type input-fields" name="tickets">
                                                <option value="">-- Select --</option>
                                                @if (count($tickets) > 0)
                                                    @foreach ($tickets as $ticket)
                                                        <option value="{{ $ticket->id }}"
                                                            data-ticket_type="{{ $ticket->ticket_type }}"
                                                            data-sold_tickets="{{ $ticket->no_of_sold_tickets }}"
                                                            data-quantity="{{ $ticket->quantity }}"
                                                            data-price="{{ $ticket->price ? $ticket->price : 0 }}">
                                                            {{ $ticket->ticket_title }}
                                                        </option>
                                                    @endforeach
                                                @else
                                                    <option value=""> No tickets found </option>
                                                @endif
                                            </select>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="register_details text-left"> <i class="fa fa-ticket"
                                                aria-hidden="true"></i>
                                            <span class="span_details text-left">No. of Tickets: </span> 
                                            <span class="span_details text-left" style="font-size:15px;display:none"> (Only few
                                                tickets left <span class="remaining_tickets">0</span>)</span>
                                        </div>
                                    </td>
                                    <td>
										<div class="qty-container" style="justify-content: left;">
											<button class="qty-btn-minus btn-light manage-quantity" type="button" data-field="quantity" data-value="mins">
												<img src="{{ asset('frontend/images/icon-minus.png') }}" alt="minus">
											</button>
											<input type="text" name="qty" step="1" min="1" value="1" readonly class="quantity-field ticket_qty input-qty"/>
											<button class="qty-btn-plus btn-light manage-quantity" type="button" data-field="quantity" data-value="plus">
												<img src="{{ asset('frontend/images/icon-plus.png') }}" alt="plus">
											</button>
										</div>
									</td>
                                </tr>

                                <!---row7--->
                                <tr>
                                    <td>
                                        <div class="register_details"> <i class="fa fa-usd"
                                                aria-hidden="true"></i>
                                            <span class="span_details">Total Price</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="register_date total_price">$ 0</div>
                                    </td>
                                </tr>
                                <!---row8--->
                                <tr align="center" class='details_last'>
                                    <th class="last_wrap" colspan="2">
                                        <div class="input-field second-wrap ">
                                            <button class="btn-common buy_ticket" type="button ">Buy Ticket</button>
                                        </div>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                        <div class="abt-right-section" style="margin-top: 10px">
                            @if(!empty($event->venue_image))
                                <img src="{{ $event->venue_image }}" alt="venue_image" class="event-banner1 img-fluid w-100">
                            @endif
                        </div>
                    </div>
                    <div class="abt-right-section">
                        <img src="{{ $event->image }}" alt="logo " class="event-banner1 img-fluid w-100">
                    </div>
                    {{-- <div class="abt-right-section">
                        <img src="{{ $event->venue_image }}" alt="logo " class="event-banner1 img-fluid w-100">
                    </div> --}}
                </div>
                
            </div>
        </section>
        <!-- banner code start -->
        <!-- searchbar -->

        <section class="main-banner-vendor pt-5 text-center d-flex align-items-center justify-content-center"
            id="back_tp">
            <div class="container">
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-12 mt-5 mb-5">
                        <div class="detail_btn d-flex justify-content-center align-items-center">
                            @if (!Auth::user())
                                <!-- <div class="input-field mx-3">
                                    <a href="{{ url('/register') }}" class="text-decoration-none">
                                        <button class="detail-search" type="button ">Register Now</button>
                                    </a>
                                </div> -->
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- searchbar -->

    </div>

    <div class="main_content overflow-hidden">
        <!-- marquee code start -->
        <input type="hidden" id="startDate" value="{{ $event->start_date . ' ' . $event->start_time }}">
        <input type="hidden" id="endDate" value="{{ $event->end_date . ' ' . $event->end_time }}">
        <input type="hidden" id="event_id" value="{{ $event->id }}">
        <input type="hidden" id="loggedin_id" value="{{ Crypt::encrypt(Auth::user()->id) }}">
        {{-- @include('frontend.layouts.footer-marque') --}}
        <!-- code end -->
        <!-- marquee code start -->
    </div>

@endsection

@section('script')
    <script src="{{ asset('frontend/customjs/event-detail.js?v=' . time()) }}"></script>
@endsection
