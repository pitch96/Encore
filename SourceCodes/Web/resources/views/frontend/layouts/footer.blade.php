<!-- footer code end -->
<footer class="footer_bg text-left pt-5 ">
    <div class="container-fluid">
        <div class="row pb-md-4">
            <div class="col-lg-3 col-md-4 col-12">
                <p> <a href="{{ url('/') }}"> <img src="{{ asset('frontend/images/logo.png') }} " alt="logo "
                            class="img-fluid "></a> </p>
                <p class="text-left footer_para ">515 N Cedar Ridge</p>
                {{-- <p class="text-left footer_para ">Apr 02, 8:00 PM</p> --}}
                <p class="text-left footer_para "> Dr Suite 8</p>
                <p class="text-left footer_para ">Duncanville, TX 75116</p>
                <div class="footer-list pt-1 ">
                    <ul>
                        {{-- <li>
                                <a href="# "> <i class="connect_icon fa fa-twitter px-2 " aria-hidden="true "></i> </a>
                            </li> --}}
                        <li>
                            <a href="{{ config('constants.ENCORE_EVENTS_FACEBOOK_URL') }}" target="_blank"> <i
                                    class="connect_icon fa fa-facebook px-2 " aria-hidden="true "></i></a>
                        </li>
                        <li>
                            <a href="{{ config('constants.ENCORE_EVENTS_INSTAGRAM_URL') }}" target="_blank"> <i
                                    class="connect_icon fa fa-instagram px-2 " aria-hidden="true "></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            {{-- <div class="col-lg-2 col-md-4 col-12 text-left">
                    <div class="foot-list ">
                        <h5>Our Services</h5>
                        <ul>
                            <li> <a href="# " class="listing text-decoration-none">Vlogs</a> </li>
                            <li> <a href="# " class="listing text-decoration-none">Pricing  </a> </li>
                            <li> <a href="# " class="listing text-decoration-none">Offers &amp; Coupons</a> </li>
                        </ul>
                    </div>
                </div> --}}
            <div class="col-lg-2 col-md-4 col-12 text-left">
                <div class="foot-list ">
                    <h5>Our Company</h5>
                    <ul>
                        <li> <a href="{{ url('aboutus') }}" class="listing text-decoration-none">About Us</a> </li>
                        <li> <a href="{{ url('contactus') }}" class="listing text-decoration-none">Contact Us </a> </li>
                        <li> <a href="{{ url('privacypolicy') }}" class="listing text-decoration-none">Privacy
                                Policy</a> </li>
                        <li> <a href="{{ url('termsconditions') }}" class="listing text-decoration-none">Terms &amp;
                                Conditions</a> </li>
                        <li> <a href="{{ url('sales') }}" class="listing text-decoration-none">Market With Us</a> </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-12 text-left"></div>
            <div class="col-lg-5 col-md-8 col-12 text-left">
                <div class="foot-list ">
                    <h5>Get weekly program and schedule subscribe our newsletter</h5>
                    <div class="seacx ">
                        <form id="subscription-form">
                            @csrf
                            <p class='newsletter'>
                                <i class="fa fa-envelope " aria-hidden="true "></i>
                                <input name="" value="" class="subscriber_email" placeholder='Email Id'
                                    type='email' id="email">
                                <button type="button" id="subscribe">Subscribe</button>
                            <div class="g-recaptcha" id="feedback-recaptcha"
                                data-sitekey="{{ config('constants.GOOGLE_RECAPTCHA_KEY') }}"
                                data-callback="hideAlertMsg">
                            </div>
                            <div class="newsfeedback text-left email-validation" style="display: none"> </div>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <hr class="top_line ">
        <div class="py-3">
            <div class="container-fluid">
                <div class="row flex-row-reverse mx-md-5">
                    <div class="bottom_footer col-xl-8 col-lg-12 col-md-12">
                        <p class="copy_ryt ">EncoreEvents © @php echo date("Y"); @endphp All rights reserved</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- footer code end -->
