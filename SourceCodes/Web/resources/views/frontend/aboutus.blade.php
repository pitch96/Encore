@extends('frontend.layouts.default')

@section('title', 'About Us')

@section('content')

    <div class="overflow-hidden" id="user_bg">
        <!-- first section event code start-->
        <section class="main-section section-gapping act_system_section pt-5 mt-5">
            <div class="container">
                <div class="d-flex  page-content">
                    <div class="abt-left-section">
                       <img src="{{ asset('frontend/images/about_us.jpg') }}" />    
                    </div>
                    <div class="abt-right-section">
                        <div class="blog_content1 text-left">
                            <h1 class="main-title text-center">About Us</h1>
                            <p> We are a self-service ticketing platform for live events that allows you to create, maintain, share, and explore different events all around the United States.</p>
                            <p>We believe in serving your venue with tools, access to content, solutions, and working with you, to exceed your objectives.</p>
                            <p>We are here to exceed all of your expectations of any ticketing platform.</p>
                            <p>At Encore Events, we want to give you a Five Star Experience in order to make your event a true success.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--contact form end-->
    </div>

@endsection

@section('script')

@endsection
