@extends('frontend.layouts.default')

@section('title', 'Sales')

@section('content')

    <div class="overflow-hidden" id="user_bg">
        <!-- first section event code start-->
        <section class="main-section section-gapping act_system_section pt-5 mt-5">
            <div class="container">
                <div>
                <h1 class="main-title text-center">Market your event with us</h1>
                </div>
                <div class="d-flex page-content">
                    <div class="abt-right-section">
                        <div class="sales-wr blog_content1 text-left">
                            <ul class="list">
                                <li class="sale-items">
                                    <div class="sale-desc">
                                        <h3>You are in control</h3>
                                        <p>Let us help you create and manage multiple events</p>
                                    </div>
                                </li>
                                <li class="sale-items">
                                    <div class="sale-desc">
                                        <h3>Powerful promoter dashboard</h3>
                                        <p>You will have access to our powerful dashboard application to view and manage the events and ticket sales</p>
                                    </div>
                                </li>
                                <li class="sale-items">
                                    <div class="sale-desc">
                                        <h3>Reach more audience</h3>
                                        <p>Encore events has a global reach. Attract more customers that are looking into attending your events.</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="blog-view" style="justify-content: flex-start;">
                            <a href="{{ route('register') }}?source=sales" class="btn-common">Signup now</a>
                        </div>
                    </div>
                    <div class="abt-left-section">
                        <img src="{{ asset('frontend/images/blog/event_pass1.jpg') }}" />    
                     </div>
                </div>
            </div>
        </section>
        <!--contact form end-->
    </div>

@endsection

@section('script')

@endsection
