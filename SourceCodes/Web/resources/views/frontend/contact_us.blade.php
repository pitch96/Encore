@extends('frontend.layouts.default')

@section('title', 'Contect Us')

@section('content')
<div class="overflow-hidden" id="user_bg">
    <!-- first section event code start-->

    <section class="main-section section-gapping act_system_section pt-5 mt-5">
        <div class="container">
            <div class="d-flex">
                <div class="abt-right-section">
                    <div class="blog_content1 text-left">
                        <h1 class="main-title text-center">Contact Us</h1>
                        <br>
                        <div class="contact-info">
                            <div class="contact-info-item">
                              <div class="contact-info-icon">
                                <img src="{{ asset('frontend/images/count_down2.png') }}" width="70" alt="img" class="img-fluid">    
                            </div>
                              
                              <div class="contact-info-content">
                                <h4 class="blog-post-title category-title">Office Address</h4>
                                <p>515 N Cedar Ridge, Suite 8<br>Duncanville, TX 75116</p>
                              </div>
                            </div>
                            
                            <div class="contact-info-item">
                              <div class="contact-info-icon">
                                <img src="{{ asset('frontend/images/count_down3.png') }}" width="70" alt="img" class="img-fluid">
                              </div>
                              
                              <div class="contact-info-content">
                              <h4 class="blog-post-title category-title">Office Phone</h4>
                                <p>682-410-4038</p>
                              </div>
                            </div>
                            
                            <div class="contact-info-item">
                              <div class="contact-info-icon">
                                <img src="{{ asset('frontend/images/count_down1.png') }}" width="70" alt="img" class="img-fluid">
                              </div>
                              
                              <div class="contact-info-content">
                              <h4 class="blog-post-title category-title">Office Email</h4>
                                <a href="mailto:{{ Config::get('constants.ADMIN_EMAIL3') }}"
                                    class="text-decoration-none">
                                    <p> {{ Config::get('constants.ADMIN_EMAIL3') }}
                                    </p>
                                </a>
                                <a href="mailto:{{ Config::get('constants.ADMIN_EMAIL4') }}"
                                    class="text-decoration-none">
                                    <p class="cart">{{ Config::get('constants.ADMIN_EMAIL4') }}
                                    </p>
                                </a>
                                <a href="mailto:{{ Config::get('constants.ADMIN_EMAIL5') }}"
                                    class="text-decoration-none">
                                    <p class="cart">{{ Config::get('constants.ADMIN_EMAIL5') }}
                                    </p>
                                </a>
                              </div>
                            </div>
                          </div>
                    </div>
                </div>
                <div class="abt-left-section">
                    <img src="{{ asset('frontend/images/contactus.jpg') }}" />    
                 </div>
            </div>
            <div class="caody px-md-4 no-bg">
                       
                <form method="POST" id="contactusForm" action="{{ url('contactus') }}"
                    class="needs-validation validation_form position-relative">
                    @csrf
                    <?php //print_r(session()->all()) ?>
                    <div class="form_inner_container p-3">
                        <div class="form-control" id="msg">
                            <p>Contact us to help promote, plan, or produce your next event.</p>
                            @if($errors->any())
                                @foreach($errors->getMessages() as $error)
                                    <span style="color: red;">{{$error[0]}}</span>
                                @endforeach
                            @endif 
                            @if(session()->has('error'))
                            <p style="color: red;">{{session()->get('error')}}</p>
                            @endif
                            @if(session()->has('success'))
                            <p style="color: green;">{{session()->get('success')}}</p>
                            @endif
                        </div>

                        <div class="d-flex mobile-column">
                            <div class="form-control w-100">
                                <input type="text" class="name-field input-fields" id="name" name="name" value="{{ old('name') }}" placeholder="Enter your name" required maxLength="40">
                            </div>

                            <div class="form-control w-100">
                                <input type="email" class="input-fields" id="email" name="email" value="{{ old('email') }}" placeholder="example@gmail.com" required>
                            </div>
                        </div>

                        <div class="d-flex mobile-column">
                            <div class="form-control w-100">
                                <input type="text" id="subject" class="input-fields" value="{{ old('subject') }}" required name="subject" placeholder="Subject">  
                            </div>

                            <div class="form-control w-100">
                                <input type="text" id="phone_no" class="input-fields" value="{{ old('phone_no') }}" required name="phone_no" placeholder="(123) 456-7890">  
                            </div>
                        </div>
                        
                        <div class="form-control form-row py-2">
                            <div class="col-md-12 mb-3">
                                <textarea style="height: auto" class="input-fields cust-sel-size" name="queries" id="validationCustom05" placeholder="Type your Query…" rows="4" cols="40" required>{{ old('queries') }}</textarea>
                            </div>
                        </div>
                        <div class="form-control g-recaptcha" id="feedback-recaptcha2"
                            data-sitekey="{{ config('constants.GOOGLE_RECAPTCHA_KEY') }}">
                        </div>

                        <div class="form-control">
                            <button type="submit" class="btn btn-block btn-common contact-btn" id="contact1">Contact
                                Us</button>

                        </div>

                    </div>
                    <!-- container -->
                </form>
            </div>
        </div>
    </section>
    <!--contact form end-->
</div>

@endsection

@section('script')

<script>

    $(document).ready(function() {
        $("#contactusForm").validate({
            submitHandler: function(form){
                $('#msg').html('');
                var response = grecaptcha.getResponse(0);
                if (response.length === 0) {
                    $('#msg').html('<p style="color: red;">Please verify the reCaptcha</p>');
                    return false;
                }
                var data = $("#contactusForm").serialize()+'&g-recaptcha-response='+response;
                $.ajax({
                    type: 'post',
                    url: base_url + '/contactusajax',
                    data: data,
                    success: function (res) {
                        Swal.fire({
                            icon: res.status,
                            title: 'Subscribe',
                            html: res.message,
                            showDenyButton: false, showCancelButton: false,
                            confirmButtonText: `Ok`,
                        });
                        $('#msg').html('');
                        $("#contactusForm")[0].reset()
                    }
                })
                grecaptcha.reset();
		    }
        });
    })
</script>
@endsection
