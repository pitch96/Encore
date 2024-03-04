@extends('frontend.layouts.default')

@section('title', 'Privacy Policy')

@section('content')

    <div class="">

        <style>
            .blink{
                background: yellow;
            }
        </style>
    </div>

    
		<!-- Start Policy section -->
		<section class="policy-section section-gapping">
			<div class="container">
				<div class="policy-heading">
					<h5 class="main-title">
						<img src="{{ asset('frontend/images/privacy_policy.jpg') }}" alt="privacy policy image" class="img-fluid privacy-policy-image">
					</h5>
				</div>
				<div class="dropdown">
					<button class="dropdown-link">General Terms</button>
					<ul class="dropdown-options">
					  <li><a href="#" data-section="1">General Terms</a></li>
					  <li><a href="#" data-section="2">Information we may collect about you</a></li>
					  <li><a href="#" data-section="3">How and on which basis we use your personal information</a></li>
					  <li><a href="#" data-section="8">Our use of cookies</a></li>
					  <li><a href="#" data-section="4">Disclosure of your personal information</a></li>
					  <li><a href="#" data-section="5">How we hold and protect your personal information</a></li>
					  <li><a href="#" data-section="6">Your rights</a></li>
					  <li><a href="#" data-section="7">Links to other websites</a></li>

                      
					  
					</ul>
				</div>
				<section id="1" class="section-wise d-flex">
                    <div style="flex:0.4">
                        <h5 class="main-title">General Terms</h5>
                    </div>
                    <div style="flex: 1.6;">
                    <p class="policies_para pb-1">
                    Encore Events ("We", “us”, “our”) are committed to protecting and respecting your privacy and keeping your personal information secure.
This policy describes how we use the personal information that we collect from you in connection with your receipt of our products and services (the “Services”) and when you interact with our websites and apps (together, the “Websites”).
Important: This policy applies to you if you contract with us to receive the Services or otherwise interact with us regarding your use, or potential use, of the Services. It also applies if you interact with us, including by using our websites or interacting with us via social media.
The policy does not apply to you if you are a ticket buyer or an event attendee who has sourced a ticket from an event organizer which uses the Encore Events platform. In such circumstances, we process ticket buyers’ and event attendees’ personal information solely on the event organizers’ behalf (as their “processor”) and the event organizers has the legal responsibility to tell ticket buyers and event attendees how their personal information will be collected and used. Our privacy practices in respect of such personal information are governed by the contract we have in place with the event organizer.
                    </p>
                    </div>
				</section>
                <section id="2" class="section-wise d-flex">
                    <div style="flex:0.4">
                        <h5 class="main-title">Information we may collect about you</h5>
                    </div>
                    <div style="flex: 1.6;">
                        <p class="policies_para pb-1">    
                            We collect information from you when you fill
                                in forms on encoreevents.live (including when you register to use our Services), when
                                you respond to any surveys that we send to you to complete, post materials on the
                                Websites,
                                request further information about the Services and when you report a problem with our
                                Websites. This information may include
                            </p>
                        <p class="policies_para pb-1"> We may collect and process the following personal data about you:
                        </p>
                           <ul class="policies_para pb-1">
                                    <li><p class="policies_para pb-1"> Your name</p></li>
                                    <li><p class="policies_para pb-1"> Your address</p></li>
                                    <li><p class="policies_para pb-1"> Your email address and phone number</p></li>
                                    <li><p class="policies_para pb-1"> Details of any opinions or complaints you raise regarding the Service (including
                                        those posted on public forums and social media) and
                                        details of any correspondence that you have with us, including via our online
                                        customer support function.</p></li>
                                    <li><p class="policies_para pb-1"> Your responses to any surveys or questionnaires that we may send to you.</p></li>
                                    <li><p class="policies_para pb-1"> Details of transactions you carry out through our Websites and of the fulfilment
                                        of your orders. All payments are made through our payment processors (see
                                        Payments via our website below). All card details are provided direct to the
                                        payment processor
                                        and we only receive transaction details and certain limited card details (name,
                                        address, card type, last four digits of card number and expiry date) from the
                                        payment processor to manage your payments and to identify your transactions.
                                    </p></li>
                                    <li><p class="policies_para pb-1"> Your preferences in receiving marketing communications from us.</p></li>
                            </ul>
                            <p class="policies_para pb-1"><br> 
                            <b>Other information we collect about your visit to our website or use of our apps: </b>
                                with regard to each of your visits
                                to our Websites, we may automatically collect details of your visit, including, but not
                                limited to, traffic data,
                                location data, weblogs and other communication data. We may also collect information
                                about your computer, including
                                where available your IP address, operating system and browser type, for system
                                administration, analysis of how users are
                                using our Websites and to report aggregate information to our advertisers. We may also
                                collect details of the resources that you access on our Website.
                                See Our use of cookies below and our Cookie Policy for more information.
                            </p>    
                        <p class="policies_para pb-1"> We may also collect, use and share anonymized data and aggregated
                            data such as statistical or demographic data for any purpose. Anonymized and aggregated data
                            may be derived from your personal data but is not considered personal data in law as this
                            data does not directly or indirectly reveal your identity. For example, we may aggregate
                            statistics to understand usage of our Websites.</p>
    
                        <p class="policies_para pb-1">We do not collect any special categories of personal data about
                            you (this includes details about your race or ethnicity, religious or philosophical beliefs,
                            sex life, sexual orientation, political opinions, trade union membership, information about
                            your health and genetic and biometric data). Nor do we collect any information about
                            criminal convictions and offences.</p>
                    </div>
				</section>
                <section id="3" class="section-wise d-flex">
                    <div style="flex:0.4">
                        <h5 class="main-title">How and on which basis we use your personal information</h5>
                    </div>
                    <div style="flex: 1.6;">
                        <p class="policies_para pb-1"> We will only use your personal information for specific purposes
                            and when we have a lawful basis to do so. Most commonly,
                            we will use your personal data in the following circumstances: to perform a contract with you or to take steps at your request prior to entering a
                            contract with you. We use your personal information to enter into and perform our contracts, including:<br>                               
                        </p>
                        <ul class="policies_para pb-1">
                            <li><p class="policies_para pb-1">To provide you with information or services that you request from us.</p></li>
                            <li><p class="policies_para pb-1">To provide you with access to the Services, including to register you as a user of the
                                Services and to enable to you to set up an account and to sell tickets via the Services.</p></li>
                            <li><p class="policies_para pb-1">To determine your eligibility for our Services.</p></li>
                            <li><p class="policies_para pb-1">To provide the functionality of the Services that you have requested via our Websites.</p></li>
                            <li><p class="policies_para pb-1">To send you service notifications.</p></li>
                            <li><p class="policies_para pb-1">To allow you (or the corporate client you represent) to participate in interactive
                                features of our Services, when you choose to do so.</p></li>
                            <li><p class="policies_para pb-1">To notify you about changes to our Service.</p></li>
                            <li><p class="policies_para pb-1">To manage our relationship with you.</p></li>
                        </ul>
                        <p class="policies_para pb-1"><br>When you have given us your consent to use your personal
                                information, we use your personal information when you have given your consent
                            for us to process your personal information:</p> 
                        <ul class="policies_para pb-1">
                            <li><p class="policies_para pb-1">To allow us to set cookies and other similar technologies which provide information
                                about your online behavior and browsing patterns which we use for the purposes of
                                targeted marketing and advertising.</p></li>
                            <li><p class="policies_para pb-1">To allow us to set cookies and other similar technologies which provide information
                                about your online behavior and browsing patterns which we use for the purposes of
                                analyzing use and movement around our Websites so that we may improve our Services and
                                our Websites.</p></li>
                            <li><p class="policies_para pb-1">To send you marketing communications by email and text if your consent is required. If
                                we are sending you information about our services and products that are similar to those
                                that you have already purchased, we will rely on soft opt-in consent which we can take
                                as given because you have signed up for our similar services already.</p></li>
                        </ul>
                        <p class="policies_para pb-1"><p class="policies_para pb-1">To comply with our legal obligations, we use your personal information to comply with various legal and
                            regulatory obligations, including:
                        </p>
                        <ul class="policies_para pb-1">
                            <li><p class="policies_para pb-1">To notify you about changes to our terms or privacy policy.</p></li>
                            <li><p class="policies_para pb-1">To comply with mandatory law enforcement or regulatory requests for the disclosure of
                                your personal information, including in circumstances of suspected fraudulent activity.
                            </p></li>
                        </ul>
                        <p class="policies_para pb-1"><br>To fulfill our legitimate interests
                                and your interests and fundamental rights do not override those interests, we use your personal information in order to deploy and develop
                            our services, to improve our risk management and to defend our legal rights, including: </p>
    
                        <ul class="policies_para pb-1">
                            <li><p class="policies_para pb-1">To ensure that content from our Website is presented in the most effective manner.</p></li>
                            <li><p class="policies_para pb-1">To administer our site and for internal operations, including troubleshooting, data
                                analysis, research and statistical purposes.</p></li>
                            <li><p class="policies_para pb-1">As part of our efforts to keep our Website safe and secure and to monitor actual or
                                suspected fraudulent activity.</p></li>
                            <li><p class="policies_para pb-1">To carry out retargeting advertising.</p></li>
                            <li><p class="policies_para pb-1">To measure the effectiveness of our Services so that we can improve our Services;</li>
                            <li><p class="policies_para pb-1">Analyzing your habits and movement between pages when you visit the Websites so that we
                                may improve our Services and our Websites.</p></li>
                            <li><p class="policies_para pb-1">To send you information about the Services that you are receiving and any changes to
                                such Services and new features that you need to be aware of.</p></li>
                            <li><p class="policies_para pb-1">To provide you with information about new features of the Services that you are
                                receiving and about our services and products that are similar to those that you have
                                already purchased or inquired about.</p></li>
                            <li><p class="policies_para pb-1">To build profiles of potential purchasers of our products and services and to identify
                                potential purchasers of our products and services.</p></li>
                        </ul>
                        <p class="policies_para pb-1"><br><b>Marketing, targeted advertising and
                                opting out</b></p>
                        <p class="policies_para pb-1">You will only receive our marketing communications if we can
                            lawfully send them to you, that is: </p>
    
                        <ul class="policies_para pb-1">
                            <li><p class="policies_para pb-1">When you have specifically consented to receive them.</p></li>
                            <li><p class="policies_para pb-1">If you have already purchased our products and services, we may send you information
                                about our similar products or services under soft opt-in consent.</p></li>
                            <li><p class="policies_para pb-1">In your business capacity if you have requested information from us, if you provided us
                                with your details or if we have identified you as someone who may be interested in our
                                products/services.</p></li>
                        </ul>
                        <p class="policies_para pb-1"><br>We use third-party advertising platforms, such as Facebook,
                            Google, etc., to send you advertising messages that are targeted at you.
                            See our use of cookies below and our Cookie Policy for more
                            information. You can opt-out of our direct marketing at any time by: </p>
    
                        <ul class="policies_para pb-1">
                            <li><p class="policies_para pb-1">Unsubscribing from our marketing messages by following the opt-out/”unsubscribe” links
                                on any marketing email sent to you or by emailing privacy@encoreevents.live </p></li>
                            <li><p class="policies_para pb-1">Telling us you do not wish to receive targeted advertising by emailing
                                privacy@encoreevents.live</p></li>
                        </ul>
                        <p class="policies_para pb-1"><br><b>Payments and Profiling<b></p>
                        <p class="policies_para pb-1">Our payment processors (see Payments via our websites) use
                            technology to help them make decisions about financial transactions and your card payments
                            which may
                            prevent you from accessing our Services or continuing to use our Services. In this role, our
                            Payment Processors act as controllers and may monitor
                            insights and patterns of payment transactions and other online signals to reduce the risk of
                            fraud, money laundering and other harmful activity.
                            This activity is carried out in accordance with their privacy policies available here:</p>
                        <ul class="policies_para pb-1">
                            <li><p class="policies_para pb-1">Stripe Global Privacy Policy</p></li>
                            <li><p class="policies_para pb-1">Paypal Privacy Statement</p></li>
                        </ul>
                    </div>
                </section>
                <section id="8" class="section-wise d-flex">
                    <div style="flex:0.4">
                        <h5 class="main-title">Our use of cookies</h5>
                    </div>
                    <div style="flex: 1.6;">
                        <p class="policies_para pb-1">Our Websites use cookies and other similar technologies to
                            distinguish you from other users of our Websites. Some cookies are necessary to allow our
                            Websites to function, others help us provide you with a good experience when you browse our
                            Websites, others allow us to collect data to improve our sites and others are for the
                            purposes of targeted advertising.
                        </p>
                        <p class="policies_para pb-1"><b>Retargeting</b></p>
    
                        <p class="policies_para pb-1">Our Websites use retargeted advertising. As a result of this
                            retargeting, you may see ads for our services on other sites such as Facebook. Our
                            retargeting providers will read a cookie that is already in your browser, or they will place
                            an anonymous cookie or ‘pixel’ in your browser when you visit our Websites. Click here to
                            change your cookie consent.</p>
                            <p class="policies_para pb-1"><b>Analytics</b></hp>
                        <p class="policies_para pb-1"> We use analytics services (e.g., Google) in order to better
                            understand our users’ needs and to optimize our Service and experience. These are technology
                            services that help us better understand our users experience (e.g. how much time they spend
                            on which pages, which links they choose to click, what users do and don’t like, etc.) and
                            this enables us to build and maintain our Service with user feedback. The analytics services
                            use cookies and other technologies to collect data on your behavior and your devices (e.g.,
                            device's IP address, device screen size, device type unique device identifiers, browser
                            information, geographic location, preferred language). Hotjar stores analytics information
                            on our behalf in a pseudonymized user profile. Hotjar is contractually forbidden to sell any
                            of the data collected on our behalf. For details of Google’s privacy practices, see Google
                            Analytics privacy information.
                            <br>You have choices as to which cookies you agree to. Please see our Cookie Policy to find
                            out about the cookies we use, what they are used for and how to set or change your
                            preferences in relation to cookies.
                        </p>
                    </div>
                    </section>
                <section id="4" class="section-wise d-flex">
                    <div style="flex:0.4">
                        <h5 class="main-title">Disclosure of your personal information</h5>
                    </div>
                    <div style="flex: 1.6;">
                    <p class="policies_para pb-1"><b>Payments and Profiling</b></p>
                        <p class="policies_para pb-1">All payments through our Websites are made using the payment
                            services provided by Stripe and Paypal (Payment Processors). To use these payment services
                            you must have your own account with the Payment Processor and have connected your account
                            with our Services. To provide your card and billing details, you will be directed to a
                            Payment Processor’s service.
                            <br> In processing card payments, the Payment Processor acts as a data processor to us but
                            in other respects, both we and the Payment Processors act as data controllers and we will
                            share personal information with the Payment Processors and the Payment Processors will share
                            personal information with us in order to provide the Services. For further information on
                            how the Payment Processors handle your personal data see:
                        </p>
                        <ul class="policies_para pb-1">
                            <li><p class="policies_para pb-1">Stripe Global Privacy Policy</p></li>
                            <li><p class="policies_para pb-1">Paypal Privacy Statement</p></li>
                        </ul>
                        <p class="policies_para pb-1"><br><b>Others with whom we may share your
                                personal information</b></p>
    
                        <p class="policies_para pb-1">We share limited personal data with our affiliates only to the
                            extent required to provide our Services and for internal administration purposes.
                            <br> We may disclose your personal information to selected third parties, including:
                        </p>
                        <ul class="policies_para pb-1">
                            <li><p class="policies_para pb-1">Third party service providers who we use to help manage our business. Please email
                                privacy@encoreevents.live if you would like details of our service providers.</p></li>
                            <li><p class="policies_para pb-1">Insurers and/or professional advisers insofar as reasonably necessary for the purposes
                                of obtaining or maintaining insurance coverage, managing risks, obtaining professional
                                advice, or the establishment, exercise or defense of legal claims.</p></li>
                            <li><p class="policies_para pb-1">If Encore Events or substantially all of its assets are acquired by a third party, to
                                the relevant third party (and its advisers) who may use the data in connection with the
                                acquisition.</p></li>
                            <li><p class="policies_para pb-1">Taxation authorities, regulators, law enforcement agencies or other authorities if
                                required by such authorities or by due process of law.</p></li>
                        </ul>
                    </div>
                </section>
                <section id="5" class="section-wise d-flex">
                    <div style="flex:0.4">
                        <h5 class="main-title">How we hold and protect your personal information</h5>
                    </div>
                    <div style="flex: 1.6;">
                        <p class="policies_para pb-1"> <b>How we keep your personal information secure</b> <br>
                            We have put in place appropriate security measures to prevent your personal data from being
                            accidentally lost, used, or accessed in an unauthorized way, altered or disclosed. In
                            addition, we limit access to your personal data to those employees, agents, contractors and
                            other third parties who have a business need to know.
                        </p>
    
                        <p class="policies_para pb-1"> All information you provide to us is stored on our secure
                            servers. Any payment transactions will be carried out by our Payment Processors over
                            encrypted connections using SSL technology. Unfortunately, the transmission of information
                            via the internet is not completely secure and any transmission is at your own risk.
                            <br> We have put in place procedures to deal with any suspected personal data breach and
                            will notify you and any applicable regulator of a breach where we are legally required to do
                            so.
                            </p>
                            <p class="policies_para pb-1"><b>Our retention of your personal information</b> <br></p>
    
                            <p class="policies_para pb-1">
                            We will retain your personal data for as long as necessary to provide you with our services
                            and for so long as you do not wish to unsubscribe from our marketing communications or from
                            receiving targeted advertising. We will also retain your personal data as necessary to
                            fulfil our contractual obligations and to comply with our legal obligations, resolve
                            disputes, and enforce our agreements.
                            Where we no longer need to process your personal data for the purposes set out in this
                            Privacy Policy, we will delete your personal data from our systems unless we need to retain
                            a limited amount of information to make sure that we act in accordance with your wishes.
                            Where permissible, we will also delete your personal data on your request. Information on
                            how to make a deletion request can be found in the section entitled “Your rights” below.
                            <br> Please email privacy@encoreevents.live if you would like details of our retention
                            periods for different kinds of personal data.
                            </p>
                    </div>
                </section>
                </section>
                <section id="6" class="section-wise d-flex">
                    <div style="flex:0.4">
                        <h5 class="main-title">Your rights</h5>
                    </div>
                    <div style="flex: 1.6;">
                        <p class="policies_para pb-1">
                            You have certain legal rights with respect to your personal information depending on your
                            location and applicable laws. You may exercise your rights at any time by contacting us at
                            privacy@encoreevents.live.
                        </p>
                        <p class="policies_para pb-1"> <b>Right to rectification:</b> You have the right to have
                            inaccurate or incomplete personal data corrected or to restrict the processing of personal
                            data whilst the accuracy is checked. <br>
                            <b>Right to erasure:</b> You have the right to ask to have personal data we hold about you
                            erased. This enables you to ask us to delete or remove personal data where there is no good
                            reason for us continuing to process it. You also have the right to ask us to delete or
                            remove your personal data where you have successfully exercised your right to object to
                            processing (see below), where we may have processed your information unlawfully or where we
                            are required to erase your personal data to comply with law. <br>
                            <b>Right to data portability:</b> In certain circumstances, you have the right to have data
                            we hold about you transferred to yourself or another data controller. Note, this right only
                            applies to information that is processed by automated means which you initially provided
                            consent for us to use or where we used the information to perform a contract with you. <br>
                            <b>Right to object:</b> You have the right to: ask us not to process your personal data for
                            direct marketing purposes; object, on grounds relating to your situation, to the processing
                            of your personal data (including profiling) where we are relying on a legitimate interest.
                            <br>
                            <b>Right to withdraw consent:</b> You have the right to withdraw consent at any time where
                            we are relying on consent to process your personal data. However, this will not affect the
                            lawfulness of any processing carried out before you withdraw your consent. <br>
                            <b>Right to complain:</b> You have the right to lodge a complaint with the UK Information
                            Commissioners Office (if you are a United Kingdom based customer) or other data protection
                            supervisory authority applicable to you if you are unhappy with the way we are handling your
                            personal data. <br>
                            </p>
                        <p class="policies_para pb-1">
                            <b>Your rights if you are a resident of California</b>
                        </p>
                        <p class="policies_para pb-1">
                            <b>How We Collect, Use, and Disclose your Personal Information.</b> The Information we may
                            collect about you section describes the personal information we may have collected over the
                            last 12 months, including the categories of sources of that information. We collect this
                            information for the purposes described in the How and on which basis we use your personal
                            information section. We share this information as described in the Disclosure of your
                            personal information section. We use cookies, including advertising cookies, as described in
                            Our use of cookies; and our Cookie Policy.
                        </p>
                        <p class="policies_para pb-1">
                            <b>Your CCPA Rights and Choices.</b> As a California consumer and subject to certain
                            limitations under the CCPA, you have choices regarding our use and disclosure of your
                            personal information: <br>
                            </p>
                            <p class="policies_para pb-1">
                            Exercising the right to know. You may request, up to twice in a 12-month period, the
                            following information about the personal information we have collected about you during
                            the past 12 months:
                            </p>
                        <ul class="policies_para pb-1">
                            <li><p class="policies_para pb-1">The categories and specific pieces of personal information we have collected
                                        about you.</p></li>
                            <li><p class="policies_para pb-1">The categories of sources from which we collected the personal information.</p></li>
                            <li><p class="policies_para pb-1">The business or commercial purpose for which we collected the personal
                                        information</p></li>
                            <li><p class="policies_para pb-1">The categories of third parties with whom we shared the personal information.</p></li>
                            <li><p class="policies_para pb-1">The categories of personal information about you that we disclosed for a
                                        business purpose, and the categories of third parties to whom we disclosed that
                                        information for a business purpose.</p></li>
                            <li><p class="policies_para pb-1">Exercising the right to delete. You may request that we delete the personal information
                                we have collected from you, subject to certain limitations under applicable law.</li>
                            <li><p class="policies_para pb-1">Exercising the right to opt-out from a sale. You may request to opt out of any “sale” of
                                your personal information that may take place.</p></li>
                            <li><p class="policies_para pb-1">Non-discrimination. The CCPA provides that you may not be discriminated against for
                                exercising these rights.</p></li>
                        </ul>
                        </p>
                        <p class="policies_para pb-1">
                            <br><b>What we may need from you</b> <br>
                            We may need to request specific information from you to help us confirm your identity and
                            ensure your right to access your personal data (or to exercise any of your other rights).
                            This is a security measure to ensure that personal data is not disclosed to any person who
                            has no right to receive it. We may also contact you to ask you for further information in
                            relation to your request to speed up our response.
                        </p>
                        <p class="policies_para pb-1">
                            <b>Time limit to respond: </b>
                            We try to respond to all legitimate requests within one month. Occasionally it may take us
                            longer than a month if your request is particularly complex or you have made a number of
                            requests. In this case, we will notify you and keep you updated.
                        </p>
                    </div>
                </section>
                </section>
                <section id="7" class="section-wise d-flex">
                    <div style="flex:0.4">
                        <h5 class="main-title">Links to other websites</h5>
                    </div>
                    <div style="flex: 1.6;">
                        <p class="policies_para pb-1">Our sites may, from time to time, contain links to and from the
                            websites of our partner networks, advertisers, and affiliates. If you follow a link to any
                            of these websites, please note that these websites have their own privacy policies and that
                            we do not accept any responsibility or liability for these policies. Please check these
                            policies before you submit any personal information to these websites.</p>
                        <p class="policies_para pb-1"><b id="para8">Changes to our privacy policy</b></p>
                        <p class="policies_para pb-1">Any changes we may make to our privacy policy in the future will
                            be posted on this page and we will notify you of any material changes to this policy through
                            our website or other usual communication channels. We recommend that you review this page
                            from time to time for updates. In an effort to keep you better informed, the date that this
                            Privacy Policy was last updated is provided at the top of this page. To the extent that you
                            agreed, by interacting with our website previously, to an older version of this policy, the
                            current Privacy Policy supersedes and governs and your consent is binding on any continued
                            use by you of this website. </p>
                        <p class="policies_para pb-1" ><b id="para9">How to contact us</b></p>
                        <p class="policies_para pb-1">Questions, comments, and requests regarding this privacy policy
                            are welcomed and should be addressed to: privacy@encoreevents.live.</p>
                    </div>
                </section>
			</div>
		</section>
		<!-- End Policy section -->

@endsection

@section('script')

@endsection

<script>
    function animateToPara(para) {
        var elmnt = document.getElementById(para);
        elmnt.scrollIntoView({behavior:'smooth', block:'center'});
        elmnt.classList.add('blink');
        setTimeout(() => {
            elmnt.classList.remove('blink');
        }, 900);
    }
</script>