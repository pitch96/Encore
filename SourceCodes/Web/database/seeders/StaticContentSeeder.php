<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StaticContent;

class StaticContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $staticPageDatas = [
            [
                "page_id" => 1,
                "content" => '<div class="blog_content1 text-left">                   
                <p class="policies_para pb-1"> Encore Events, Inc is a self-service ticketing platform for live events that allows you to create, maintain, share, and explore different events all around the United States. Encore Events, Inc believes in serving your venue with tools, access to content, solutions, and working with you, to exceed your objectives. We are here to exceed all of your expectations of any ticketing platform. At Encore Events, Inc we want to give you a Five Star Experience in order to make your event a true success.
                <br>
                 ~Thank you for choosing Encore Events, Inc.
                </p>
                </div>'
            ],
            [
                "page_id" => 2,
                "content" => '<div class="blog_content1 text-left">
                <p class="policies_para pb-1"> Encore Events ("We", “us”, “our”) are committed to protecting and
                    respecting your privacy and keeping your
                    personal information secure. </p>
                <p class="policies_para pb-1">This policy describes how we use the personal information that we
                    collect from you in connection with your
                    receipt of our products and services (the “Services”) and when you interact with our
                    websites and apps (together, the “Websites”).</p>
                <p class="policies_para pb-1"> Important: This policy applies to you if you contract with us to
                    receive the Services or otherwise interact
                    with us regarding your use, or potential use, of the Services. It also applies if you
                    interact with us, including by using our
                    websites or interacting with us via social media. </p>
                <p class="policies_para pb-1"> The policy does not apply to you if you are a ticket buyer or an
                    event attendee who has sourced a ticket from an event
                    organizer which uses the Encore Events platform. In such circumstances, we process ticket
                    buyers’ and event attendees’ personal information solely
                    on the event organizers’ behalf (as their “processor”) and the event organizers has the
                    legal responsibility to tell ticket buyers and event attendees
                    how their personal information will be collected and used. Our privacy practices in respect
                    of such personal information are governed by the contract
                    we have in place with the event organizer. </p>
                <ul class="policies_para pb-1">
                    <li>Information we may collect about you (#1)</li>
                    <li>How and on which basis we use your personal information; (#2)</li>
                    <li>Our use of cookies; (#3)</li>
                    <li>Disclosure of your personal information; (#4)</li>
                    <li>How we hold and protect your personal information; (#5)</li>
                    <li>Your rights; (#6)</li>
                    <li>Links to other websites; (#7)</li>
                    <li>Changes to our privacy policy; (#8) and</li>
                    <li>How to contact us. (#9)</li>
                </ul>
                <p class="policies_para pb-1">You can contact us at the "Contact us" section below or at email
                    info@encoreevents.live</p>
                <p class="policies_para pb-1"> <b>Information we may collect about you (#1)</b></p>
                <p class="policies_para pb-1"> We may collect and process the following personal data about you:
                </p>
                <ul class="policies_para pb-1">
                    <li><b>Information that you provide to us.</b> We collect information from you when you fill
                        in forms on encoreevents.live (including when you register to use our Services), when
                        you respond to any surveys that we send to you to complete, post materials on the
                        Websites,
                        request further information about the Services and when you report a problem with our
                        Websites. This information may include
                        <ul class="policies_para pb-1">
                            <li>your name;</li>
                            <li>your address;</li>
                            <li>your email address and phone number;</li>
                            <li>details of any opinions or complaints you raise regarding the Service (including
                                those posted on public forums and social media) and
                                details of any correspondence that you have with us, including via our online
                                customer support function;</li>
                            <li>your responses to any surveys or questionnaires that we may send to you;</li>
                            <li>details of transactions you carry out through our Websites and of the fulfilment
                                of your orders. All payments are made through our payment processors (see
                                Payments via our website below). All card details are provided direct to the
                                payment processor
                                and we only receive transaction details and certain limited card details (name,
                                address, card type, last four digits of card number and expiry date) from the
                                payment processor to manage your payments and to identify your transactions; and
                            </li>
                            <li>your preferences in receiving marketing communications from us.</li>
                        </ul>
                    </li>
                    <li><b>Other information we collect about your visit to our website or use of our apps.</b>
                        With regard to each of your visits
                        to our Websites, we may automatically collect details of your visit, including, but not
                        limited to, traffic data,
                        location data, weblogs and other communication data. We may also collect information
                        about your computer, including
                        where available your IP address, operating system and browser type, for system
                        administration, analysis of how users are
                        using our Websites and to report aggregate information to our advertisers. We may also
                        collect details of the resources that you access on our Website.
                        See Our use of cookies below <b>(link)</b> and our Cookie Policy for more information
                    </li>
                </ul>
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
                <p class="policies_para pb-1"> <b>How and on which basis we use your personal information
                        (#2)</b> </p>
                <p class="policies_para pb-1"> We will only use your personal information for specific purposes
                    and when we have a lawful basis to do so. Most commonly,
                    we will use your personal data in the following circumstances:<br>
                    <b>To perform a contract with you or to take steps at your request prior to entering a
                        contract with you</b> <br>
                    We use your personal information to enter into and perform our contracts, including: <br>
                </p>
                <ul class="policies_para pb-1">
                    <li>to provide you with information or services that you request from us;</li>
                    <li>to provide you with access to the Services, including to register you as a user of the
                        Services and to enable to you to set up an account and to sell tickets via the Services;
                    </li>
                    <li>to determine your eligibility for our Services;</li>
                    <li>to provide the functionality of the Services that you have requested via our Websites;
                    </li>
                    <li>to send you service notifications;</li>
                    <li>to allow you (or the corporate client you represent) to participate in interactive
                        features of our Services, when you choose to do so;</li>
                    <li>to notify you about changes to our Service; and</li>
                    <li>to manage our relationship with you.</li>
                </ul>
                <p class="policies_para pb-1"><b>When you have given us your consent to use your personal
                        information</b></p>
                <p class="policies_para pb-1">We use your personal information when you have given your consent
                    for us to process your personal information: </p>
                <ul class="policies_para pb-1">
                    <li>to allow us to set cookies and other similar technologies which provide information
                        about your online behavior and browsing patterns which we use for the purposes of
                        targeted marketing and advertising.</li>
                    <li>to allow us to set cookies and other similar technologies which provide information
                        about your online behavior and browsing patterns which we use for the purposes of
                        analyzing use and movement around our Websites so that we may improve our Services and
                        our Websites; and</li>
                    <li>to send you marketing communications by email and text if your consent is required. If
                        we are sending you information about our services and products that are similar to those
                        that you have already purchased, we will rely on soft opt-in consent which we can take
                        as given because you have signed up for our similar services already.</li>
                </ul>
                <p class="policies_para pb-1"><b class="policies_para pb-1">To comply with our legal obligations
                </b></p><b class="policies_para pb-1">
                <p class="policies_para pb-1">We use your personal information to comply with various legal and
                    regulatory obligations, including: </p>
                <ul class="policies_para pb-1">
                    <li>to notify you about changes to our terms or privacy policy; and</li>
                    <li>to comply with mandatory law enforcement or regulatory requests for the disclosure of
                        your personal information, including in circumstances of suspected fraudulent activity.
                    </li>
                </ul>
                <p class="policies_para pb-1"><b class="policies_para pb-1">To fulfill our legitimate interests
                        and your interests and fundamental rights do not override those interests</b> </p>
                <p class="policies_para pb-1"> We use your personal information in order to deploy and develop
                    our services, to improve our risk management and to defend our legal rights, including: </p>
                <ul class="policies_para pb-1">
                    <li>to ensure that content from our Website is presented in the most effective manner;</li>
                    <li>to administer our site and for internal operations, including troubleshooting, data
                        analysis, research and statistical purposes;</li>
                    <li>as part of our efforts to keep our Website safe and secure and to monitor actual or
                        suspected fraudulent activity;</li>
                    <li>to carry out retargeting advertising;</li>
                    <li>to measure the effectiveness of our Services so that we can improve our Services;</li>
                    <li>analyzing your habits and movement between pages when you visit the Websites so that we
                        may improve our Services and our Websites;</li>
                    <li>to send you information about the Services that you are receiving and any changes to
                        such Services and new features that you need to be aware of;</li>
                    <li>to provide you with information about new features of the Services that you are
                        receiving and about our services and products that are similar to those that you have
                        already purchased or inquired about; and</li>
                    <li>to build profiles of potential purchasers of our products and services and to identify
                        potential purchasers of our products and services.</li>
                </ul>
                <p class="policies_para pb-1"><b class="policies_para pb-1">Marketing, targeted advertising and
                        opting out</b> </p>
                <p class="policies_para pb-1">You will only receive our marketing communications if we can
                    lawfully send them to you, that is: </p>
                <ul class="policies_para pb-1">
                    <li>when you have specifically consented to receive them;</li>
                    <li>if you have already purchased our products and services, we may send you information
                        about our similar products or services under soft opt-in consent; and</li>
                    <li>in your business capacity if you have requested information from us, if you provided us
                        with your details or if we have identified you as someone who may be interested in our
                        products/services.</li>
                </ul>
                <p class="policies_para pb-1"> We use third-party advertising platforms, such as Facebook,
                    Google, etc., to send you advertising messages that are targeted at you.
                    See our use of cookies below <b>(Link)</b> and our Cookie Policy <b>(Link)</b> for more
                    information. <br>
                    You can opt-out of our direct marketing at any time by: </p>
                <ul class="policies_para pb-1">
                    <li>unsubscribing from our marketing messages by following the opt-out/”unsubscribe” links
                        on any marketing email sent to you or by emailing privacy@encoreevents.live; and/or</li>
                    <li>telling us you do not wish to receive targeted advertising by emailing
                        privacy@encoreevents.live</li>
                </ul>
                <h5 class="pt-md-3 mt-md-2">Payments and Profiling</h5>
                <p class="policies_para pb-1">Our payment processors (see Payments via our websites) use
                    technology to help them make decisions about financial transactions and your card payments
                    which may
                    prevent you from accessing our Services or continuing to use our Services. In this role, our
                    Payment Processors act as controllers and may monitor
                    insights and patterns of payment transactions and other online signals to reduce the risk of
                    fraud, money laundering and other harmful activity.
                    This activity is carried out in accordance with their privacy policies available here:</p>
                <ul class="policies_para pb-1">
                    <li>Stripe Global Privacy Policy</li>
                    <li>Paypal Privacy Statement</li>
                </ul>
                <p class="policies_para pb-1"><b>Our use of cookies (#3) </b></p>
                <p class="policies_para pb-1">Our Websites use cookies and other similar technologies to
                    distinguish you from other users of our Websites. Some cookies are necessary to allow our
                    Websites to function, others help us provide you with a good experience when you browse our
                    Websites, others allow us to collect data to improve our sites and others are for the
                    purposes of targeted advertising.
                </p>
                <h5 class="pt-md-3 mt-md-2">Retargeting</h5>
                <p class="policies_para pb-1">Our Websites use retargeted advertising. As a result of this
                    retargeting, you may see ads for our services on other sites such as Facebook. Our
                    retargeting providers will read a cookie that is already in your browser, or they will place
                    an anonymous cookie or ‘pixel’ in your browser when you visit our Websites. Click here to
                    change your cookie consent.</p>
                <h5 class="pt-md-3 mt-md-2">Analytics</h5>
                <p class="policies_para pb-1"> We use analytics services (e.g., Google) in order to better
                    understand our users’ needs and to optimize our Service and experience. These are technology
                    services that help us better understand our users experience (e.g. how much time they spend
                    on which pages, which links they choose to click, what users do and don’t like, etc.) and
                    this enables us to build and maintain our Service with user feedback. The analytics services
                    use cookies and other technologies to collect data on your behavior and your devices (e.g.,
                    devices IP address, device screen size, device type unique device identifiers, browser
                    information, geographic location, preferred language). Hotjar stores analytics information
                    on our behalf in a pseudonymized user profile. Hotjar is contractually forbidden to sell any
                    of the data collected on our behalf. For details of Google’s privacy practices, see Google
                    Analytics privacy information.
                    <br>You have choices as to which cookies you agree to. Please see our Cookie Policy to find
                    out about the cookies we use, what they are used for and how to set or change your
                    preferences in relation to cookies.
                </p>
                <p class="policies_para pb-1"><b>Disclosure of your personal information (#4)</b></p>
                <h5 class="pt-md-3 mt-md-2">Payments and Profiling</h5>
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
                    <li>Stripe Global Privacy Policy</li>
                    <li>Paypal Privacy Statement</li>
                </ul>
                <p class="policies_para pb-1"><b class="policies_para pb-1">Others with whom we may share your
                        personal information</b></p>
                <p class="policies_para pb-1">We share limited personal data with our affiliates only to the
                    extent required to provide our Services and for internal administration purposes.
                    <br> We may disclose your personal information to selected third parties, including:
                </p>
                <ul class="policies_para pb-1">
                    <li>third party service providers who we use to help manage our business. Please email
                        privacy@encoreevents.live if you would like details of our service providers;</li>
                    <li>insurers and/or professional advisers insofar as reasonably necessary for the purposes
                        of obtaining or maintaining insurance coverage, managing risks, obtaining professional
                        advice, or the establishment, exercise or defense of legal claims;</li>
                    <li>if Encore Events or substantially all of its assets are acquired by a third party, to
                        the relevant third party (and its advisers) who may use the data in connection with the
                        acquisition;</li>
                    <li>taxation authorities, regulators, law enforcement agencies or other authorities if
                        required by such authorities or by due process of law.</li>
                </ul>
                <p class="policies_para pb-1"> <b>How we hold and protect your personal information (#5)</b>
                </p>
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
                    <br> <b>Our retention of your personal information</b> <br>
                    We will retain your personal data for as long as necessary to provide you with our services
                    and for so long as you do not wish to unsubscribe from our marketing communications or from
                    receiving targeted advertising. We will also retain your personal data as necessary to
                    fulfil our contractual obligations and to comply with our legal obligations, resolve
                    disputes, and enforce our agreements.
                    Where we no longer need to process your personal data for the purposes set out in this
                    Privacy Policy, we will delete your personal data from our systems unless we need to retain
                    a limited amount of information to make sure that we act in accordance with your wishes.
                    Where permissible, we will also delete your personal data on your request. Information on
                    how to make a deletion request can be found in the section entitled “Your rights”, below.
                    <br> Please email privacy@encoreevents.live if you would like details of our retention
                    periods for different kinds of personal data.
                </p>
                <p class="policies_para pb-1"> <b>Your rights (#6)</b></p>
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
                </p><ul class="policies_para pb-1">
                    <li>Exercising the right to know. You may request, up to twice in a 12-month period, the
                        following information about the personal information we have collected about you during
                        the past 12 months:
                        <ul class="policies_para pb-1">
                            <li>the categories and specific pieces of personal information we have collected
                                about you;</li>
                            <li>the categories of sources from which we collected the personal information;</li>
                            <li>the business or commercial purpose for which we collected the personal
                                information;</li>
                            <li>the categories of third parties with whom we shared the personal information;
                                and;</li>
                            <li>the categories of personal information about you that we disclosed for a
                                business purpose, and the categories of third parties to whom we disclosed that
                                information for a business purpose.</li>
                        </ul>
                    </li>
                    <li>Exercising the right to delete. You may request that we delete the personal information
                        we have collected from you, subject to certain limitations under applicable law.</li>
                    <li>Exercising the right to opt-out from a sale. You may request to opt out of any “sale” of
                        your personal information that may take place.</li>
                    <li>Non-discrimination. The CCPA provides that you may not be discriminated against for
                        exercising these rights.</li>
                </ul>
                <p></p>
                <p class="policies_para pb-1">
                    <b>What we may need from you</b> <br>
                    We may need to request specific information from you to help us confirm your identity and
                    ensure your right to access your personal data (or to exercise any of your other rights).
                    This is a security measure to ensure that personal data is not disclosed to any person who
                    has no right to receive it. We may also contact you to ask you for further information in
                    relation to your request to speed up our response.
                </p>
                <p class="policies_para pb-1">
                    <b>Time limit to respond</b>
                    We try to respond to all legitimate requests within one month. Occasionally it may take us
                    longer than a month if your request is particularly complex or you have made a number of
                    requests. In this case, we will notify you and keep you updated.
                </p>
                <p class="policies_para pb-1"><b>Links to other websites (#7)</b></p>
                <p class="policies_para pb-1">Our sites may, from time to time, contain links to and from the
                    websites of our partner networks, advertisers, and affiliates. If you follow a link to any
                    of these websites, please note that these websites have their own privacy policies and that
                    we do not accept any responsibility or liability for these policies. Please check these
                    policies before you submit any personal information to these websites.</p>
                <p class="policies_para pb-1"><b>Changes to our privacy policy (#8)</b></p>
                <p class="policies_para pb-1">Any changes we may make to our privacy policy in the future will
                    be posted on this page and we will notify you of any material changes to this policy through
                    our website or other usual communication channels. We recommend that you review this page
                    from time to time for updates. In an effort to keep you better informed, the date that this
                    Privacy Policy was last updated is provided at the top of this page. To the extent that you
                    agreed, by interacting with our website previously, to an older version of this policy, the
                    current Privacy Policy supersedes and governs and your consent is binding on any continued
                    use by you of this website. </p>
                <p class="policies_para pb-1"><b>How to contact us (#9)</b></p>
                <p class="policies_para pb-1">Questions, comments, and requests regarding this privacy policy
                    are welcomed and should be addressed to: privacy@encoreevents.live.</p>
                </b>
            </div>'
            ],
            [
                "page_id" => 3,
                "content" => '<div class="blog_content1 text-left">
                <div class="blog_content1 text-left">
                 <p class="policies_para pb-1">The following are the rules ("TERMS") that govern the use of EncoreEvents.live (“We”, “us”, the “SITE”) by any user of the SITE (“USER” or “You”).</p>
                 <p class="policies_para pb-1">By using or visiting this SITE or purchasing tickets in any manner from the SITE, you expressly agree to abide and be bound by these Terms and Conditions, (“Terms”), as well as all applicable laws, ordinances, regulations, and any agreements incorporated herein by reference (e.g., our Privacy Policy). SITE reserves the right to change these Terms at any time, and you agree that any such anticipated modifications, amendments, or alterations, regardless of kind, shall become effective and binding upon you once posted by us to the SITE. The “Last Updated” date above will tell you when the terms were last revised. To the extent that these Terms differ from a prior version of the Terms which you previously agreed to, this version governs. If USER violates these TERMS SITE may terminate USER’S access to the SITE, bar USER from future use of the SITE, cancel USER’S ticket order, and/or take appropriate legal action against USER.</p>
                 <p class="policies_para pb-1"> <b>General</b> EncoreEvents.live ("SITE") acts as a marketplace, an intermediary between buyers and ticket sellers ("TICKET SELLERS") to facilitate the purchase and sale of event tickets, and as such is not directly involved in the actual ticket sale transaction between the buyers and TICKET SELLERS. <b>All sales are final.</b> As tickets sold through SITE are often obtained through the secondary market and prices are determined by the individual ticket seller, the prices for tickets may be above or below face value (i.e., the cost listed on the ‘face’ of the ticket itself). Tickets sold through SITE are from a third party; therefore, sometimes the buyers name will not be printed on the tickets. Please note that the name on the tickets does not affect the buyers ability to access the event.
                 </p>
                 <ul class="policies_para pb-1"> <li> IF AN EVENT IS CANCELLED, you will be given a full refund minus any delivery charges if the tickets have already been delivered.</li>
                 </ul>
                 <p class="policies_para pb-1"> <b>All sales are final</b> Since tickets are a one-of-a-kind item and not replaceable, there are no refunds, exchanges or cancellations. If an event is <b>postponed or rescheduled</b>, tickets will be honored for the rescheduled date. New tickets generally will not need to be issued; in the rare case that new tickets are needed, USER will be contacted by the TICKET SELLER.
                 </p>
                 <p class="policies_para pb-1"> If an event is <b>cancelled without a rescheduled date</b>, USER will need to contact the TICKET SELLER who fulfills USERs order (hereinafter, “FULFILLER”) for a refund. The FULFILLER may require USER to return the supplied tickets at USERs expense before receiving any refund USER is entitled to due to cancellation. SITE is not responsible for providing or securing this refund for USER. Any shipping and handling charges are not refundable. Refunds will be processed in the same currency as the original order. Conversion charges, including though not exhaustive of the ones issued by USERs bank, if any, are not covered by SITE or Fulfiller. Neither SITE nor the FULFILLER will issue exchanges or refunds after a purchase has been made or for lost, stolen, damaged or destroyed tickets. When USER receives tickets, USER should keep them in a safe place. Please note that direct sunlight or heat may damage tickets.
                 </p>
                 <p class="policies_para pb-1"> <b>Above Face Value</b> Tickets obtained through SITE are often obtained through secondary market TICKET SELLERS and are being resold, in many cases, above the price or "face value" listed on the ticket. All ticket prices include additional service charges and handling fees as defined on each order. SITE and TICKET SELLERS are not directly affiliated with any performer, sports team, or venue; and SITE does not act as a primary sale box office, unless otherwise stated. By agreeing to these TERMS, USER agrees that the purchase price for tickets on their order does not reflect the original purchase price of the ticket and may be either higher or lower than the original purchase price.
                 </p>
                 <p class="policies_para pb-1"> <b>Ticket Availability</b> SITE cannot and does not guarantee ticket availability until USER is in possession of their tickets. Generally, all ticket listings on SITE are a unique set of tickets from an individual TICKET SELLER. Some listings on SITE may only be representations of available tickets or an offer by SITE to obtain tickets and not actual seat locations or currently available tickets.
                 </p>
                 <p class="policies_para pb-1"> Occasionally tickets ordered may no longer be available at the price or in the quantity originally ordered at the time the order is received. If equivalent or better seat locations are available at the same price, the TICKET SELLER will fill the order with the alternative seat locations. If no alternates are available, either USER’S credit card will not be charged at all or the entire amount will be refunded, and USER will be notified that the USERs request has been rejected
                 </p>
                 <p class="policies_para pb-1"> <b>Orders</b> placed through SITE will be fulfilled by one of SITES network of participating TICKET SELLERS. Contact information for the FULFILLER will be provided to USER upon completion of the purchase process. If this information is lost, USER may contact CustomerSupport@EncoreEvents.live to retrieve information about the order. USER should carefully enter all required information when submitting an order. USER is responsible for any errors made when entering their information, errors may result in issues such as a delay in processing the order or in delivery of tickets or in cancellation of order. All orders placed on the SITE or with the customer contact center must be confirmed by the respective seller before the buyer guarantee takes effect.
                 </p>
                 <p class="policies_para pb-1"> <b>Zone Tickets, Tickets Not in Hand</b> For certain live events, we permit a limited number of pre-approved sellers to offer tickets for sale that they do not currently possess. These tickets may be marked on the listing as "Zone Tickets" or as "tickets not in hand". If you purchase Zone Tickets or tickets marked as "not in hand", the seller is committing to obtain the tickets described for you upon receipt of your order. These tickets, like all tickets sold on this SITE, are backed by our 100% Money Back Guarantee. After you place your order and your order is confirmed by the seller, we guarantee that your tickets will be within the area listed or one comparable or better and that you will receive these tickets in time for the event or you will get your money back.
                 </p>
                 <p class="policies_para pb-1"> <b>Pricing</b> All prices are in United States Dollars (USD) unless otherwise specifically stated. SITE cannot confirm the price for any products or services purchased on the SITE until after an order is completed by USER. Despite SITE"S best efforts, a small number of products and services listed on the SITE may be priced incorrectly. If the FULFILLER discovers the actual correct price is higher than the stated price, the FULFILLER will either complete the order at the original stated price, contact USER to inform them of different price with an option to purchase, or cancel USER’S order and notify USER of such cancellation.
                 </p>
                 <p class="policies_para pb-1"> <b>Schedule of Fees and Charges</b> The price charged to USERs credit card beyond the price of the individual tickets shall include the following fees and charges:
                 </p>
                 <p class="policies_para pb-1"> <b>Service Fee:</b> Cost per ticket associated with SITE operation, customer service center operation, obtaining tickets on behalf of USER and other costs associated with the fulfillment of USERs ticket request.
                 </p>
                 <p class="policies_para pb-1"> <b>Delivery:</b> Costs associated with the Delivery Method chosen by USER and the SITES arrangement of USERs ticket delivery by the FULFILLER.
                 </p>
                 <p class="policies_para pb-1"> <b>Total: </b> Entire amount charged to USER, including each tickets price as set by the FULFILLER, Service Fee, and Delivery.
                 </p>
                 <p class="policies_para pb-1"> <b>Taxes</b> TICKET SELLER is responsible for keeping abreast of all changes to the tax withholding requirements and amounts in the various tax jurisdictions where TICKET SELLER sells tickets, and, for determining whether any taxes are due for any tickets sold and, except for states for which SITE has informed TICKET SELLER that SITE will collect certain taxes, , for collecting and remitting such taxes in accordance with applicable law. Except for states for which SITE has informed TICKET SELLER that SITE will add taxes to the checkout calculation, TICKET SELLER shall include any applicable sales, use, excise, service and other taxes in the ticket price. TICKET SELLER shall provide SITE with any information SITE requires in order to enable SITE to report information regarding payments SITE has made to TICKET SELLER to relevant tax authorities including but not limited to employer identification number, social security number, or tax id number and TICKET SELLER authorizes SITE to release that information to the relevant tax authorities.
                 </p>
                 <p class="policies_para pb-1">Payment</p>
                 <ul class="policies_para pb-1"> <li> <b>Credit Card Charges</b> USERs credit card will be charged by the FULFILLER responsible for fulfilling their order and not SITE. If USER has any questions about charges on USERs credit card statement, USER should contact SITE at CustomerSupport@EncoreEvents.live or direct USERs question to FULFILLER responsible for completing the ticket order. FULFILLER may charge or authorize USERs credit card in advance of confirming ticket availability. If tickets are ultimately found to be unavailable, the USERs credit card will not be charged or USER will receive a full refund for the charged amount. </li> <li> <b>Payment by Debit Card</b> In some cases, FULFILLER may attempt to authorize a debit card multiple times, creating several holds on USERs account. This often happens when a third-party credit card processing company requires additional security verification such as a CVV, Zip Code, or address, or when USERs information is incorrectly provided or mistyped. Though the FULFILLER will only clear USERs transaction once, the hold(s) will temporarily lower USERs available balance. Any hold(s) may take up to several days to clear. </li> <li> <b>Payment by Affirm.</b> If USER selects Affirm as a payment option and is approved by Affirm use of Affirm as a payment method is subject to Affirm’s policies, fees, and terms of service, USER should visit the Affirm website at https://www.affirm.com/terms for Affirm’s Terms of Service. USER should also review Affirm’s Privacy Policy at https://www.affirm.com/privacy. If USER has questions about Affirm, USER must contact Affirm Customer Care directly at (855) 423-3729 or by using other contact information provided at www.affirm.com where contact information may be updated more frequently than it is on this page. </li> <li> <b>Third Party Payment Platforms (Paypal, ApplePay, etc.)</b> If USER selects to complete a transaction on SITE using a Third Party Payment Platform, such third party services may be subject to separate policies, terms of use, and or fees of said third parties and USER accepts the same by completing the transaction using the Third Party Payment Platform. The name on the transaction of USERs Third Party Payment Platform account will be "My Ticket Tracker." If USER has any questions about the transaction on the Third Party Payment Platform account, USER should contact CustomerSupport@EncoreEvents.live. </li> <li> <b>Collecting Payment for Orders</b> USER agrees that FULFILLER has the right to collect payment for any order if FULFILLER has shipped the items purchased to USER. If a third party provider error, system error, or other payment processing error or problem of any kind results in an unprocessed payment and therefore USERs payment card is not charged the total amount due even though the item(s) were shipped to USER, USER hereby authorizes FULFILLER to collect the amount of the total amount due, unless expressly prohibited by law, through whatever means FULFILLER deems appropriate. USER shall be responsible for any and all legal fees or collection costs incurred by USER, FULFILLER, and/or SITE associated with collecting payment. In no event will SITE or FULFILLER be responsible for such collection costs or legal fees. </li> <li> <b>Security of Card Holder Data</b> SITE and or FULFILLER are responsible for the security of the cardholder data that SITE and FULFILLER are in possession of or otherwise stores, processes, or transmits on behalf of the USER. </li>
                 </ul>
                 <p class="policies_para pb-1"> <b>International Orders</b> International Orders placed by USER may be subject to delayed processing. SITE recommends that any USER placing an order on the SITE from outside the U.S. contact their credit card company or financial institution prior to placing an order to prevent unnecessary delays or holds. Neither SITE nor FULFILLER shall be responsible for delays, holds, or any extra fees associated with placing an International Order.
                 </p>
                 <p class="policies_para pb-1"> <b>Disputed Charges</b> By placing an order, USER authorizes SITE to charge USERs method of payment for the total amount, which includes the ticket price, service and delivery fees, and any other optional services USER agrees to purchase. If USER disputes a charge and it is determined that the charge was valid and not the result of credit card or other payment fraud, SITE has the right to seek payment, including all associated fees, by whatever means SITE deems appropriate, including but not limited to using collection agencies and legal remedies. SITE may mitigate its damages by relisting the tickets that are the subject of the payment dispute. USER may lose access to any/all tickets purchased if USER files a dispute with their issuer.
                 </p>
                 <p class="policies_para pb-1"> <b>Event Listings</b> SITE does not guarantee the accuracy of event information on SITE including but not limited to event name, event location or venue, event start time, or event date. Event start times are subject to change without notice. Changes to an event including but not limited to event location or venue, event start time, event date, performer list, performance type, length of event, and amenities included in a ticket package may be done at the discretion of the venue, performer, promoter or other party responsible for the event each of which are unaffiliated with SITE and SITE has no control over such changes, nor can SITE be liable for any such changes. USER agrees to visit the website of the venue, stadium, team, or performer to find out if there have been any event time adjustments.
                 </p>
                 <p class="policies_para pb-1"> <b>Ticket Holder Behavior Policy</b> The USER agrees to abide by all rules and policies of the venue where the event is located relating to conduct and behavior. Should the USER be ejected from the event or denied entry for failure to abide by the venues rules and policies, USER shall be subject to all applicable fines and legal or other expenses associated with the ejection. In addition, all costs associated with the purchase of event tickets will not be refundable. Further, should the ejection result in the loss of the TICKET SELLERs right to use any other tickets, including season tickets at that venue, or the right to purchase other tickets from that venue, USER shall be held liable for all reasonable costs, expenses, and losses associated with said loss, including but not limited to all direct, indirect, vicarious, consequential, exemplary, incidental, special or punitive damages, including lost profits.
                 </p>
                 <p class="policies_para pb-1"> <b>Fraudulent Use</b> To protect USER from fraud, USER may be required to provide additional proof of identify on any order. Proof of identity may include but is not limited to a signed credit card authorization and/or photocopies of public documents such as a state drivers license or federal passport.
                 </p>
                 <p class="policies_para pb-1"> <b>Delivery</b> All orders are delivered to USER using the delivery method chosen for the order. In some cases a USERs selected shipping must be upgraded without notice to USER and the USER will be charged for the upgraded shipping. Most orders are shipped the same business day in which they are received. Orders placed after business hours may be shipped on the next business day. Shipments may require direct signature at the point of delivery. USER is responsible to provide correct shipping address at the time of purchase. SITE and SELLER will not provide refunds if USER provides incorrect shipping information. USER must contact SELLER or SITE customer support if USER has not received an email with tracking information. By placing an order, USER understands and agrees to the following shipping terms.
                 </p>
                 <p class="policies_para pb-1"> <b>Delayed Shipment</b> Event tickets are generally delivered according to the delivery method selected at the time of ticket checkout. Most tickets are shipped the same business day in which the order is received or, if an order is placed after business hours, tickets may be shipped on the next business day. However, tickets may not always be available for immediate delivery, particularly in cases when the tickets have been purchased far in advance of the event in question or for certain events including but not limited to the following: all off-season orders for professional sporting leagues, concerts, and Las Vegas and other Nevada events; delivery may also be delayed due to the actions of the performer, venue, or team. While most tickets are delivered within three business days of the delivery method chosen, this does not imply a guaranteed delivery date. In these situations tickets may be marked with an estimated ship date. USER will be provided with account access information that will allow them to view the status of their order, tickets and tracking information, if available, after purchase. In the case where tracking information is not available USER may contact a representative of the FULFILLER for shipment information or an estimated delivery date. Tickets will be shipped when available, and choice of an expedited delivery method does not guarantee that tickets will be shipped immediately. USER should check the order notes for the estimated delivery date.
                 </p>
                 <p class="policies_para pb-1"> <b>International Shipping</b> If USER is located outside of the United States, USER must choose an International Delivery option. If a domestic shipping option is chosen for an order to be shipped outside the United States, the shipping cost will be adjusted by the FULFILLER after the order is placed to use the International Rate.
                 </p>
                 <p class="policies_para pb-1"> <b>Delivery Verification</b> If USER specifies a shipping address that does not allow for Delivery Verification, such as a Post Office Box, USER may be required to pay an additional fee to cover the additional risks associated with this type of order. If such a shipping address is used, the FULFILLER will, at its discretion, either contact USER about the additional fee prior to shipping or cancel USER’S order and notify USER of such cancellation. Shipments may require direct signature at the point of delivery. Once FULFILLER has shipped the tickets, it is USERs responsibility to receive the package. Should the package be refused, undelivered, or returned, refunds or credits will not be issued by FULFILLER as per the All Sales Are Final policy of these Terms set forth above. If a package has been returned and must be re-shipped by the FULFILLER, it is the USER responsibility to contact the FULFILLER for re-shipping options. USER understands that additional delivery fees may be charged prior to reshipping.
                 </p>
                 <p class="policies_para pb-1"> <b>E-Ticket Download</b> Electronic tickets or "e-tickets", including those marked as "Instant", may not be available for immediate download in all circumstances. Due to potential fraud concerns, some "Instant" e-ticket purchases may be downgraded to regular e-ticket download to allow for additional processing. In such cases, USER will receive notification with USER’S receipt explaining that USER’S order has been downgraded to regular e-ticket download. After placing an order, USER will receive an email with instructions on how to download the tickets; therefore, it is important that USER provides accurate email address information during the order process. The USER will be required to enter order specific credentials to gain access to the tickets, and USER must have access to a printer from which to print the tickets. USER is responsible for contacting Customer Support should USER not receive the email instructions, be unable to download the tickets, or be unable to print the tickets. Neither SITE nor FULFILLER will issue refunds for USERs failure to provide a correct email address or failure to print the tickets.
                 </p>
                 <p class="policies_para pb-1"> <b>Electronic Transfer</b> Electronic transfer delivery may not be available for immediate access. After placing an order, USER will receive an email with instructions on how to accept the electronic transfer; therefore, it is important that USER provides accurate email address information during the order process. The USER will be required to create an account with the associated ticket transfer system to gain access to the tickets, and USER must have access to a smart device to present the QR code displayed via the electronic transfer system for entry at the event. USER is responsible for contacting Customer Support should USER not receive the email instructions, be unable to accept the ticket transfer, or be unable to locate the ticket transfer email. Neither SITE nor FULFILLER will issue refunds for USER’S failure to provide a correct email address or accept ticket transfer offer. Neither SITE nor FULFILLER will issue refunds in the event a USER declines the ticket transfer offer.
                 </p>
                 <p class="policies_para pb-1"> <b>Local Delivery</b> USER must pick up the tickets from the designated location provided to the USER, which will be located near the venue. USER will need to bring a government-issued ID in order to claim the tickets and may be asked to present the credit card used at time of purchase as further verification. Should USER encounter a problem at the local delivery location, USER must contact FULFILLER for assistance. Neither SITE nor FULFILLER will issue refunds for USER’S failure to provide a valid government-issued ID or other required documentation for release of tickets or if USER does not pickup tickets from designated location
                 </p>
                 <p class="policies_para pb-1"> <b>Will-Call Option</b> USER must pick up the tickets at the box office of the venue approximately one hour before the scheduled start of the event. USER will need to bring a government-issued ID in order to claim the tickets. Should USER encounter a problem at the box office, USER must contact FULFILLER for assistance
                 </p>
                 <p class="policies_para pb-1"> <b>Denied Entry to an Event</b> If USER is having difficulty using the tickets to gain entry to the event at the venue, USER should contact SITE immediately by calling (855) 261-6909. If SITE is not able to resolve the matter and USER is denied entry by the venue, USER may be eligible for a refund. To be eligible for a refund USER must obtain written proof from the venue showing that USER was denied entry to the event and email that proof along with a description of the circumstances to SITE at CustomerSupport@EncoreEvents.live within ten (10) days of the event.
                <br /> If SITE receives the email with written proof from the venue and USERs description of the circumstances of the denied entry within ten (10) days of the event, SITE will investigate USERs claim. If SITE, in its reasonable discretion, determines that USER was denied entry USER will receive a refund of the cost of the tickets and all fees and shipping charges. The refund will be USERs sole remedy for the denied entry.
                 </p>
                 <p class="policies_para pb-1"> <b>Permitted Use</b> USER agrees that USER is only authorized to visit, view, and to retain a copy of pages of this SITE for USER’S own personal use, and that USER shall not duplicate, download, publish, modify, or otherwise distribute the material on this SITE for any purpose other than to review event and promotional information, for personal use, or to purchase tickets or merchandise for USER’S personal use, unless otherwise specifically authorized by SITE to do so. USER may not use any robot, spider, scraper, offline reader, site search/retrieval application or other manual or automatic device, tool, or process to retrieve or in any way reproduce, circumvent, or interfere with the Site or its contents, nor may USER use any automated software or computer system to search for, reserve, buy, or otherwise obtain tickets from SITE. USER may not submit any software or other materials that contain any viruses, worms, Trojan horses, defects, date bombs, time bombs, ransomware, malware, malicious code, or other items of a destructive nature. The content and software on this SITE is the property of SITE and/or its suppliers and is protected by U.S. and international copyright laws.
                 </p>
                 <p class="policies_para pb-1"> <b>Links</b> The SITE may automatically produce search results that reference or link to third party websites throughout the Internet. SITE has no control over these sites or the content within them. SITE cannot guarantee, represent or warrant that the content contained in these third party sites is accurate, legal and/or inoffensive. SITE does not endorse the content of any third party site, nor does SITE warrant that they will not contain malicious content or otherwise impact USER’S computer systems. By using the SITE to search for or link to another site, USER agrees and understands that USER may not make any claim against SITE for any damages or losses, whatsoever, resulting from use of the SITE to obtain search results or to link to another site. If USER experiences a problem with a link from the SITE, please notify SITE at CustomerSupport@EncoreEvents.live and SITE will investigate USER’S claim and take any actions deemed appropriate at SITES sole discretion.
                 </p>
                 <p class="policies_para pb-1"> <b>Violation of the Terms SITE</b>, in its sole discretion, and without prior notice, may terminate USER’S access to the SITE, cancel USER’S ticket order or exercise any other remedy available to it. USER agrees that monetary damages may not provide a sufficient remedy to SITE for violations of these terms and conditions and USER consents to injunctive or other equitable relief for such violations. SITE may release USER information by operation of law, if the information is necessary to address an unlawful or harmful activity against SITE. SITE is not required to provide any refund to USER if USER is terminated as a USER of this SITE.
                 </p>
                 <p class="policies_para pb-1"> <b>Intellectual Property Information</b> For purposes of these TERMS, “CONTENT” is defined as any information, communications, software, photos, videos, graphics, music, sounds, written computer code, layout, UX/UI elements, artwork, interactive elements, sound bites or effects, and other material and services that can be viewed by USER’S on the site. This includes, but is in no way limited to, message boards, chat, and other original content. By accepting these TERMS, USER acknowledges and agrees that all CONTENT presented to USER on this site is protected by copyrights, trademarks, service marks, patents or other proprietary rights and laws, and is the sole property of SITE and/or its affiliates. USER is only permitted to use the CONTENT as expressly authorized in writing by SITE or the specific provider of CONTENT. Except for a single copy made for personal use only, USER may not copy, reproduce, modify, republish, upload, post, transmit, or distribute any documents or information from this site in any form or by any means without prior written permission from SITE or the specific CONTENT provider, and USER is solely responsible for obtaining permission before reusing any copyrighted material that is available on this site. Any unauthorized use of the materials appearing on this site may violate copyright, trademark and other applicable laws and could result in criminal or civil penalties. Neither SITE nor any of its affiliates warrant or represent that USER’S use of materials displayed on, or obtained through, this site will not infringe the rights of third parties. All other trademarks or service marks are property of their respective owners. Nothing in these TERMS grants USER any right to use any trademark, service mark, logo, and/or the name of SITE or any of its affiliates. SITE reserves the right to terminate the privileges of any USER who uses this SITE to unlawfully transmit or receive copyrighted material without a license or express consent, valid defense or fair use exemption to do so. After proper notification by the copyright holder or its agent to us, and confirmation through court order or admission by the USER that they have used this SITE as an instrument of unlawful infringement, SITE will terminate the infringing USER’S rights to use and/or access to this SITE. SITE may, also in its sole discretion, decide to terminate a USERs rights to use or access to the SITE prior to that time if SITE believes that the alleged infringement has occurred. Moreover, for the purposes of enforcement of violations of this paragraph (e.g., complying with a Court Order or subpoena) it is expressly agreed that SITE may disclose certain facts about USER (e.g., name and contact information) alleged to be engaging in any infringing behavior.
                 </p>
                 <p class="policies_para pb-1"> <b>Disclaimers</b> SITE MAKES NO ASSURANCES THAT THE SITE WILL BE ERROR-FREE, UNINTERRUPTED, OR PROVIDE SPECIFIC RESULTS FROM USE OF THE SITE OR ANY SITE CONTENT, SEARCH OR LINK THEREIN. THE SITE AND SITE CONTENT ARE DELIVERED ON AN "AS-IS" AND "AS-AVAILABLE" BASIS. SITE MAKES NO ASSURANCES THAT FILES USER ACCESSES OR DOWNLOADS FROM THE SITE WILL BE FREE OF VIRUSES OR CONTAMINATION OR DESTRUCTIVE FEATURES. SITE DISCLAIMS ALL WARRANTIES, EXPRESS OR IMPLIED INCLUDING ALSO ANY IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE. SITE WILL NOT BE LIABLE FOR ANY DAMAGES OF ANY KIND ARISING FROM THE USE OF THIS SITE, INCLUDING WITHOUT LIMITATION, DIRECT, INDIRECT, VICARIOUS, INCIDENTAL, SPECIAL, PUNITIVE, LOSS OF BUSINESS OR LOSS OF PROFITS OR CONSEQUENTIAL DAMAGES, WHETHER BASED UPON BREACH OF CONTRACT, BREACH OF WARRANTY, TORT, NEGLIGENCE, PRODUCT LIABILITY OR OTHERWISE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
                <br /> SITE DISCLAIMS ANY AND ALL LIABILITY FOR THE ACTS, OMISSIONS AND CONDUCT OF ANY THIRD PARTY USER’S, SITE USER’S, ADVERTISERS AND/OR SPONSORS ON THE SITE, IN CONNECTION WITH THE SITE SERVICE OR OTHERWISE RELATED TO USER USE OF THE SITE AND/OR THE SITE SERVICE. SITE IS NOT RESPONSIBLE FOR THE PRODUCTS, SERVICES, ACTIONS OR FAILURE TO ACT OF ANY TICKET BROKER, VENUE, PERFORMER, (INCLUDING BUT NOT LIMITED TO THEIR PERFORMANCE, FAILURE TO PERFORM OR MODIFICATION OF THE PERFORMANCE OR EVENT IN ANY WAY), PROMOTER OR OTHER THIRD PARTY IN CONNECTION WITH OR REFERENCED ON THE SITE.
                 </p>
                 <p class="policies_para pb-1"> <b>Limitation on Liability</b> USER acknowledges that SITE is a venue allowing people to buy and sell tickets to concert, sporting and entertainment events. The listings of ticket inventory on SITE are provided by a third party ("PROVIDER"). Neither SITE nor PROVIDER is involved in the actual transaction between buyers and sellers. While SITE and PROVIDER may help facilitate the resolution of disputes, neither SITE nor PROVIDER has control over the content of the tickets listed on SITE, the truth or accuracy of such listings, the ability of the FULFILLER to sell tickets, or that USER and FULFILLER will actually complete a transaction. Regardless of this provision, if either SITE or PROVIDER is found to be liable, SITE or PROVIDERS liability to USER or any third party is limited to the greater of (a) any amounts due under SITEs limited guarantee when applicable, (b) the amount of fees in dispute not to exceed the total fees of the transaction, or (c) $100.
                <br /> Except in jurisdictions where such provisions are restricted, in no event will SITE or PROVIDER be liable to USER for any indirect, vicarious, consequential, exemplary, incidental, special or punitive damages, including lost profits, even if SITE and PROVIDER have been advised of the possibility of such damages. USER further agrees that the maximum available remedy on any successful claim is the greater of the choices listed in the paragraph above.
                 </p>
                 <p class="policies_para pb-1"> <b>Indemnity</b> USER agrees to indemnify and hold SITE, its subsidiaries, affiliates, officers, agents and other partners and employees, harmless from any loss, liability, claim or demand, including reasonable attorneys fees, made by any third party due to or arising out of USER’S use of the SITE, including also USER’S use of the SITE to provide a link to another site or to upload content or other information to the SITE.
                 </p>
                 <p class="policies_para pb-1"> <b>Governing Law</b> USER agrees that any controversy or claim arising out of or relating to the use of SITE will be governed by the laws of the State of Texas without regard to its conflict of law provisions. USER agrees to personal jurisdiction by venue in the state and federal courts of the State of Texas, Dallas County.
                 </p>
                 <p class="policies_para pb-1"> <b>Arbitration and Dispute Resolution</b> Any controversy, claim, dispute, or other action, arising out of or relating to the use of SITE, any order placed on SITE, or these policies including any dispute over the validity, enforceability or scope of this arbitration provision (a “CLAIM” or “CLAIMS”) shall be resolved through binding arbitration administered by the American Arbitration Association (the “AAA”) in accordance with its Consumer Rules. SITE will pay all filing, administration, and arbitrator fees for any arbitration for a CLAIM of US $10,000 or less. If, however, the arbitrator finds that either the substance of the CLAIM or the relief sought in the CLAIM is frivolous or that the CLAIM was brought for an improper purpose (as measured by the standards set forth in Federal Rule of Civil Procedure 11(b)), then the payment of all such fees will be governed by applicable AAA Rules. In such case, USER agrees to reimburse SITE for all monies previously disbursed by SITE that are otherwise USERs obligation to pay under the AAA Rules. In addition, if USER initiates an arbitration for a CLAIM for more than US $10,000, the payment of fees will be governed by the AAA Rules. The AAA rules will determine whether the arbitration will take place through written submissions by USER and SITE, by telephone, or in person. SITE and USER shall both participate in the selection of an arbitrator. Any award issued through arbitration is enforceable in any court of competent jurisdiction.
                 </p>
                 <p class="policies_para pb-1"> BY AGREEING TO ARBITRATE, USER IS GIVING UP THE RIGHT TO LITIGATE (OR PARTICIPATE IN AS A PARTY OR CLASS MEMBER) ANY AND ALL CLAIMS IN COURT BEFORE A JUDGE OR JURY. INSTEAD, A NEUTRAL ARBITRATOR WILL RESOLVE ALL CLAIMS. IF USER DOES NOT WISH TO BE BOUND BY THIS ARBITRATION PROVISION, USER MUST NOTIFY SITE IN WRITING WITHIN 30 DAYS OF THE DATE THAT USER PLACES AN ORDER ON SITE. USERs WRITTEN NOTIFICATION TO SITE MUST INCLUDE USERs NAME, ADDRESS AND ORDER NUMBER AS WELL AS A CLEAR STATEMENT THAT USER DOES NOT WISH TO RESOLVE CLAIMS WITH SITE THROUGH ARBITRATION. WRITTEN NOTIFICATION SHOULD BE MAILED TO SITE
                 </p>
                 <p class="policies_para pb-1"> Any arbitration or trial of any CLAIM will take place on an individual basis without resort to any form of class or representative action ("CLASS ACTION WAIVER"). Regardless of anything else in this Arbitration Provision, the validity and effect of this CLASS ACTION WAIVER may be determined only by a court and not by an arbitrator. USER and SITE acknowledge that the CLASS ACTION WAIVER is material and essential to the arbitration of any disputes between the parties and is non-severable from the agreement to arbitrate CLAIMS. If the CLASS ACTION WAIVER is limited, voided or found unenforceable, then the parties agreement to arbitrate shall be null and void with respect to such proceeding, subject to the right to appeal the limitation or invalidation of the CLASS ACTION WAIVER. USER AND SITE ACKNOWLEDGE AND AGREE THAT UNDER NO CIRCUMSTANCES WILL A CLASS ACTION BE ARBITRATED.
                 </p>
                 <p class="policies_para pb-1"> All CLAIMS brought by USER against SITE must be resolved in accordance with this Arbitration and Dispute Resolution Section. All CLAIMS filed or brought contrary to this Arbitration and Dispute Resolution Section shall be considered improperly filed. Should USER improperly file a CLAIM, SITE may recover attorneys fees and costs up to US$1,000 from USER, provided that SITE has notified USER in writing of the improperly filed CLAIM, and USER fails to promptly withdraw the CLAIM after USER receives notice of improper filing from SITE.
                 </p>
                 <p class="policies_para pb-1"> Events in Illinois. Pursuant to 815 ILCS 414/1.5(c)(5), complaints involving tickets to events in Illinois may be resolved through binding arbitration and administered by the American Arbitration Association in accordance with its Commercial Arbitration Rules including the Optional Rules for Emergency Measures of Protection. USER and FULFILLER agree to submit to the jurisdiction of the State of Illinois for such complaints
                 </p>
                 <p class="policies_para pb-1"> <b>Force Majeure</b> SITE shall not be deemed in default or otherwise liable under these rules and policies due to its inability to perform its obligations by reason of any fire, earthquake, flood, substantial snowstorm, epidemic, pandemic, outbreak of plague or widespread illness, accident, explosion, casualty, strike, lockout, labor controversy, riot, civil disturbance, act of public enemy, cyber-terrorism, embargo, war, act of God, or any municipal, county, state or national ordinance or law, or any executive, administrative or judicial order (which order is not the result of any act or omission which would constitute a default hereunder), or any failure or delay of any transportation, power, or communications system or any other or similar cause not under SITES control (hereinafter all of the foregoing is collectively referred to as “FORCE MAJEURE”). Notwithstanding the foregoing, SITE shall be permitted to terminate this Agreement with or without notice to USER in the event that USER is prevented from performing hereunder due to FORCE MAJEURE.
                 </p>
                 <p class="policies_para pb-1"> <b>Registration</b> Certain areas of the SITE are provided solely to registered USER’S of the SITE. Any USER registering for such access agrees to provide true and accurate information during the registration process. SITE reserves the right to terminate the access of USER should SITE know, or have reasonable grounds to suspect that USER has entered false or misleading information during the registration process. ALL REGISTERED USER’S MUST BE OVER EIGHTEEN (18) YEARS OF AGE. Children under the age of eighteen (18) shall not be permitted to register. SITE reserves the right to require valid credit card information as proof of legal age. SITE maintains a strict online Privacy Policy (Hyperlink to Privacy Policy Here) and will not sell or provide USER credit card information to third parties.
                 </p>
                 <p class="policies_para pb-1"> <b>USER Account</b> USER will select a username and password as part of the registration process. All USER account pages are protected with Secure Socket Layer (SSL) encryption. USER is fully responsible for maintaining the confidentiality of their username and password. USER agrees to immediately notify SITE at CustomerSupport@EncoreEvents.live should USER know, or have reasonable grounds to suspect, that the username or password have been compromised. SITE shall not be responsible for USER’S failure to abide by this paragraph. SITE may, in its sole discretion, terminate the USER’S account for any reason. Under no circumstances shall SITE be liable to any USER or third party for termination of USER’S account.
                 </p>
                 <p class="policies_para pb-1"> <b>Third Party Advertisers</b> SITE may allow third party advertisers to advertise on the SITE. SITE undertakes no responsibility for USER’S dealings with, including any on-line or other purchases from, any third party advertisers. SITE shall not be responsible for any loss or damage incurred by USER in its dealings with third party advertisers
                 </p>
                 <p class="policies_para pb-1"> <b>Virtual Services Terms Virtual Experiences:</b> Through SITE, USER may purchase the right to access virtual experiences where you can receive a service through the internet rather than in person. These virtual experiences include personalized videos (“VIDEOS”), virtual lessons (“LESSONS”) virtual meet and greets (“M&amp;G”), virtual reality experiences (“VRES”) and other similar services that may be added later, which are all collectively referred to herein as “VIRTUAL SERVICES”, from celebrities, including athletes, actors, performers, artists, influencers, and others (each, a “TALENT USER”). From the list of the virtual experiences posted on the SITE, USER may submit a request to a TALENT USER for a VIRTUAL SERVICE for USER or a third party that USER identifies as a recipient (“RECIPIENT”).
                 </p>
                 <p class="policies_para pb-1"> All VIRTUAL SERVICES are provided by third party providers, not SITE. SITE is not responsible for the acts or omissions of such third party providers.
                 </p>
                 <p class="policies_para pb-1"> USER acknowledges and agrees that TALENT USER has sole discretion to determine how to fulfill USER’s request and the content of the VIRTUAL SERVICES created or conducted, and that TALENT USER shall not be required to follow USER’S request exactly.
                 </p>
                 <p class="policies_para pb-1"> A good faith effort will be made to schedule all VIRTUAL SERVICES within 7 business days of USER’S purchase. USER may request that TALENT USER reschedule a VIRTUAL SERVICE within 30 days of a USER’S originally scheduled experience start time, provided the request to do so is made and acknowledged 5 days before the experience start time. In the event TALENT USER’S availability changes, SITE reserves the right to reschedule USER’s experience at a mutually agreeable time. SITE will contact USER to reschedule using the contact information USER provided to SITE when placing the order for VIRTUAL SERVICES.
                 </p>
                 <p class="policies_para pb-1"> SITE reserves the right to refuse or reject service to anyone for any reason at any time. TALENT USER reserves the right to reject any request at their sole discretion.
                 </p>
                 <p class="policies_para pb-1"> VIDEOS are licensed, not sold. USER is buying a license to use it, not the actual VIDEO itself.
                 </p>
                 <p class="policies_para pb-1"> LESSONS are intended for one RECIPIENT only. One additional person (parent or guardian and/or purchaser) may observe at no additional fee. However, this is not encouraged, as it can be distracting for the RECIPIENT. SITE may require that USER pay an additional fee for any person who is not the parent or guardian of the RECIPIENT or purchaser of the LESSON.
                 </p>
                 <p class="policies_para pb-1"> VRES are a simulated experience where a third party provider uses a technology that provides a USER with a simulated experience of stepping inside a computer-generated 3D world. USER will need to have certain accessories to accept delivery of a VRE. Accessories may be included in the price of USER’s order if so specified. USER must provide a complete and accurate delivery address to receive such equipment. Due to the nature of the purchase the delivery address for such accessories cannot be modified once the order is submitted.
                 </p>
                 <p class="policies_para pb-1"> VIRTUAL SERVICES require that USER have certain equipment to accept delivery of the service ordered. If equipment is not listed as included with the VIRUAL SERVICE ordered when USER places an order, it is USER’s responsibility to ensure that USER has the necessary equipment (including but not limited to high speed internet access, a device that can connect to the internet, or any materials necessary to participate in a LESSON or receive the VIRTUAL SERVICES) to accept delivery of the VIRTUAL SERVICES. SITE will not issue refunds because USER does not have the necessary equipment.
                 </p>
                 <p class="policies_para pb-1"> USER understands that USER’S information (not including credit card information), may be transferred unencrypted and that such transfer may involve (a) transmissions over various networks; and (b) changes to conform and adapt to technical requirements of connecting networks or devices. Credit card information is always encrypted during transfer over networks.
                 </p>
                 <p class="policies_para pb-1"> <b>Virtual Experience Refund Policy:</b> All VIRTUAL SERVICES are non-refundable. Notwithstanding the foregoing, if USER’S request for VIRTUAL SERVICES is rejected or if the VIRTUAL SERVICE is cancelled rather than rescheduled, USER will receive a refund for the cancelled or rejected VIRTUAL SERVICES less the value of any items or components that were processed, delivered or redeemed.
                 </p>
                 <p class="policies_para pb-1"> <b>Virtual Experience Behavior Policy:</b> USER must behave in a respectful manner. For more details, please consult our Experience Guidelines.
                 </p>
                 <p class="policies_para pb-1"> <b>Limited License to Use the Virtual Services</b>. In exchange for paying the required fee, USER acquires a limited license to use the VIRTUAL SERVICES solely for USER’s personal use as specified in these terms and for a single use unless otherwise specified. USER shall not reproduce, duplicate, copy, sell, resell or exploit any portion of the VIRTUAL SERVICES, or access the VIRTUAL SERVICES or any content on the SITE through which the VIRTUAL SERVICES are provided, without express written permission from SITE.
                 </p>
                 <p class="policies_para pb-1"> Subject to USER’s payment in full of the required fee and these terms, TALENT USER hereby grants USER the following limited rights to use the VIDEO solely for USER’S own personal, non-commercial, and non-promotional purposes: a non-exclusive, royalty-free, fully paid, worldwide, sublicensable, revocable license to use, reproduce, distribute, and publicly display the VIDEO, in any and all media (for example, on social media platforms), whether now known or hereafter invented or devised.
                 </p>
                 <p class="policies_para pb-1"> USER shall not sell, resell, or encumber TALENT USER’S rights in any VIDEO. USER may sublicense USER’S rights in a VIDEO only to the extent necessary for USER to use the VIDEO as permitted under these Terms (for example, sharing it with friends on a social media platform or sending it to a RECIPIENT in each case solely for personal, non-commercial, and non-promotional purposes as set forth above).
                 </p>
                 <p class="policies_para pb-1"> USER may use a VIDEO only in accordance with these terms, which includes the VIRTUAL SERVICES Acceptable Use Policy (Hyperlink to Acceptable Use Policy Here). SITE may terminate all or part of the licenses granted in these VIRTUAL SERVICES TERMS at any time for any reason. SITE reserves the right to remove a VIDEO from our SITE at any time for any reason without any notice to USER.
                 </p>
                 <p class="policies_para pb-1"> USER agrees that a M&amp;G is priced based on one to four RECIPIENTS for a specified period of time via virtual teleconferencing. Larger groups require prior approval and payment of additional fees.
                 </p>
                 <p class="policies_para pb-1"> <b>Additional Terms:</b> Some VIRTUAL SERVICES may have additional terms and conditions that USER must agree to in order to use the VIRTUAL SERVICE (“ADDITIONAL TERMS”). If ADDITIONAL TERMS apply, we will make them available to USER in connection with that product or service. By using that product or service, USER agrees to the ADDITIONAL TERMS. To the extent that the ADDITIONAL TERMS conflict with any of these Terms, these Terms will govern unless the ADDITIONAL TERMS say that some or all of these Virtual Experience terms do not apply.
                 </p>
                 <p class="policies_para pb-1"> <b>Virtual Experience Acceptable Use Policy</b> Our goal is to create a positive, useful, and safe user experience. To promote this goal, we prohibit certain kinds of conduct specified in this Acceptable Use Policy and elsewhere on the SITE. The following Acceptable Use Policy applies to USER’S use of VIRTUAL EXPERIENCES:
                 </p>
                 <p class="policies_para pb-1"> USER is responsible for USER’s use of any VIDEO, LESSON, VIRTUAL REALITY product or other VIRTUAL SERVICE and any activity that occurs through USER’S SITE account.
                 </p>
                 <p class="policies_para pb-1"> By using the Virtual Experiences, USER represents and warrants that:
                 </p>
                 <p class="policies_para pb-1"> a) you will not use a false identity or provide any false or misleading information; <br /> b) you will not (whether on the SITE or anywhere else) use or authorize the use of any VIDEO for any purposes other than: (i) the specific limited purposes set forth in the SITE Terms and (ii) those set out in any applicable Additional Terms; and<br /> c) in connection with any VIDEO, you will not request: (i) a business or any other RECIPIENT that is the subject of any criminal action, or that is involved in, connected with or promotes illegal or unlawful activity, violence or hate speech; or (ii) content that disparages or defames any person, entity, brand, or business.<br /> d) You will not: <br /> I. violate any law, regulation, or court order;<br /> II. violate, infringe, or misappropriate the intellectual property, privacy, publicity, moral or "droit moral," or other legal rights of any third party;<br /> III. take any action—including but not limited to actions such as posting, sharing, communicating, inciting or encouraging, whether implicit or explicit and whether or not requested by a third party—that is explicitly or implicitly: illegal, abusive, harassing, threatening, hateful, racist, derogatory, harmful to any reputation, pornographic, indecent, profane, obscene, or otherwise objectionable (including nudity);<br /> IV. send advertising or commercial communications, including spam, or any other unsolicited or unauthorized communications;<br /> V. transmit any malicious software, other computer instruction, or technological means intended to, or that may, disrupt, damage, or interfere with the use of computers or related systems;<br /> VI. stalk, harass, threaten, or harm any third party;<br /> VII. impersonate any third party;<br /> VIII. participate in any fraudulent or illegal activity, including phishing, money laundering, or fraud;<br />
                 </p>
                 <p class="policies_para pb-1"> <b>Copyright Infringement Notification</b> Should USER wish to file a copyright infringement notification with SITE, USER will need to send a written or electronic communication that includes all of the following, as based on Section 512(c)(3) of the Digital Millennium Copyright Act (DMCA):
                 </p>
                 <ul class="policies_para pb-1"> <li> A physical or electronic signature of a person authorized to act on behalf of the owner of the material that has allegedly been infringed. </li> <li> Identification of the material that is claimed to be infringing or to be the subject of infringing activity. *Please provide the URL(s) in the body of the email or letter, as this will help us to identify the potentially infringing material. </li> <li>Contact information of the complainant.</li> <li> A statement that the complainant has a good faith belief that use of the material in the manner complained of is a copyright violation. </li> <li> A statement that the information in the notification is accurate, and under penalty of perjury, that the complainant is authorized to act on behalf of the owner of material that has allegedly been infringed. </li>
                 </ul>
                 <p class="policies_para pb-1"> Written or electronic notice of copyright infringement should be mailed, faxed, or emailed to SITE’s designated agent at:
                 </p>
                 <p class="policies_para pb-1">info@encoreevents.live</p>
                 <p class="policies_para pb-1"> Please note the following: <br /> --Under Section 512(f) of the DMCA, any person who knowingly misrepresents that material or activity is infringing may be subject to liability for damages.
                 </p>
                 <p class="policies_para pb-1"> <b>Service and Advertising Emails</b> SITE may send USER several service-related emails to the email address given when placing an order. These include but are not limited to a confirmation email with details of USER’S order, a pre-event email reminder about the event to be attended, and a post-event email gathering feedback on the USER’S experience. When USER places an order, SITE may also add USER to the weekly mailing list to be informed of upcoming events. USER can opt out of these emails at any time by notifying customerservice@encoreevents.live
                 </p>
                 <p class="policies_para pb-1"> <b>COVID-19 (Coronavirus) Related Event Cancellations and Postponement</b> To assure fans’ safety during these uncertain times, all tickets are subject to restrictions and requirements put in place by venues, teams, or government authorities as it pertains to proof of COVID-19 vaccination, proof of negative COVID-19 test, social distancing, wearing personal protective gear, age restrictions, or similar measures. If you cannot attend the event due to your failure or inability to comply with such requirements, you will not receive a refund. If the event is held without fans or reasonably similar seats are not available, you will receive a refund as if the event was canceled.
                 </p>
                 <p class="policies_para pb-1"> In light of recent developments related to COVID-19 and with great concern for our customers’ safety and wellbeing, we established the following terms for COVID-19 related event cancellations and postponements effective immediately:
                 </p>
                 <ul class="policies_para pb-1"> <li> IF AN EVENT IS CANCELLED AS A RESULT OF COVID-19, you may have an option to receive a credit voucher ("Credit Voucher") in the amount of 110% of the original purchase price (minus any delivery charges) (the "Value") to be used towards any ticket purchase made on SITE within 365 days from your Credit Voucher issuance date. Alternatively, you may request a full refund (minus any delivery charges).
                <ul class="policies_para pb-1">  <li> Credit Vouchers can be used for separate purchases as long as any portion of the Credit Voucher retains its Value; however, this will not extend Your Credit Voucher’s valid through date.  </li>  <li> Your Credit Voucher has no cash value and cannot be sold, exchanged or combined with any other offer. We may modify or discontinue the new Credit Voucher issuance without notice. Credit Vouchers are void where prohibited  </li>  <li> Your Credit Voucher cannot be transferred to another individual or used as a payment method on any other site, other than the site where your original purchase was made, and it cannot be transferred to a different currency. If the Site where your original purchase was made is no longer in service, Your Credit Voucher will still be honored  </li>  <li> If You choose not to utilize the Credit Voucher program, please be advised that due to recent events, your refund may take up to 30 days to be processed.  </li>  <li> By accepting the offer of a Credit Voucher or Refund, you agree that no further payment shall be made to you with respect to the purchase in question and you agree not to seek any additional refunds, credits or chargebacks. You understand that your Credit Voucher or Refund is the sole remedy available to you for your original purchase. If a chargeback is filed against the merchant of record with your credit card company, we reserve the right to withdraw any offers made, including this Credit Voucher offer.  </li>  <li> If you take no action after receiving a notification from us, you will receive a voucher by default. If you have received a voucher, but prefer to receive a cash refund, then you must contact our customer service within seven (7) calendar days from receiving the cancellation notification.  </li> </ul> </li> <li> <b>IF AN EVENT IS POSTPONED OR RESCHEDULED AS A RESULT OF COVID-19</b>, and the original tickets are valid for entry at the time of the rescheduled event, your original tickets will remain valid for the rescheduled event and your order will not qualify for a refund or a Credit Voucher. If you do not feel it is safe for you to attend the event, you can always resell your valid ticket. </li> <li> All other Terms and Conditions remain in full force and effect without amendment or modification </li>
                 </ul>
                 <p class="policies_para pb-1"> <b>Amendments</b> SITE reserves the right to amend this policy at any time. SITE will post a notice of changes on its SITE, when and if the terms of this policy are amended.
                 </p>
                 <p class="policies_para pb-1"> <b>Consumer Personal Information Request </b>
                 </p>
                 <p class="policies_para pb-1">1. SAFETY AND HEALTH POLICIES</p>
                 <p class="policies_para pb-1"> Due to the uncertainty related to the COVID-19 pandemic, your Event tickets and admission are subject to all stadium and Event Provider safety and health policies. You acknowledge that due to the evolving nature of the pandemic, the Event Provider may continue to develop and update these policies in the intervening time between your purchase and the Event date. By using Event tickets, you acknowledge and agree that you will comply with such policies and your attendance at the Event is conditioned on such compliance. If your admission to the Event is denied or revoked because you have willfully failed or refused to comply with any such safety and health policies of the stadium or Event Provider, you will not be eligible for a refund
                 </p>
                 <p class="policies_para pb-1"><b>2. ASSUMPTION OF RISK, RELEASE, WAIVER &amp; COVENANT NOT TO SUE</b>
                 </p>
                 <p class="policies_para pb-1">AN INHERENT RISK OF EXPOSURE TO COVID-19 EXISTS IN ANY PUBLIC PLACE WHERE PEOPLE ARE PRESENT. COVID-19 IS AN EXTREMELY CONTAGIOUS DISEASE THAT CAN LEAD TO SEVERE ILLNESS AND DEATH. ACCORDING TO THE CENTERS FOR DISEASE CONTROL AND PREVENTION, SENIOR CITIZENS AND THOSE WITH UNDERLYING MEDICAL CONDITIONS ARE ESPECIALLY VULNERABLE. BY ATTENDING THE EVENT, YOU VOLUNTARILY ASSUME, ON BEHALF OF YOURSELF AND ALL ACCOMPANYING MINORS, ALL RISKS RELATED TO EXPOSURE TO COVID-19.
                 </p>
                 <p class="policies_para pb-1">On behalf of yourself and your Related Persons (defined below), you further hereby release (and covenant not to sue) each of the Released Parties (defined below) with respect to any and all claims that you or any of your Related Persons may have (or hereafter accrue) against any of the Released Parties and that relate in any way to (i) your exposure to COVID-19; (ii) your entry into, or presence within or around, the Event (including all risks related thereto, and including without limitation in parking areas or entry gates) or compliance with any protocols applicable to the Event; or (iii) any interaction between you and any personnel of any of the Released Parties present at the Event, in each case whether caused by any action, inaction or negligence of any Released Party or otherwise.
                 </p>
                 <p class="policies_para pb-1">As used herein:</p>
                 <ul class="policies_para pb-1">
                       <li>“Related Persons” means your heirs, assigns, executors, administrators,next of kin, anyone attending the Event with you (which persons you represent have authorized you to act on their behalf for purposes of these Supplemental Terms), and other persons acting or purporting to act on your or their behalf. </li>
                 </ul>
                 <p class="policies_para pb-1"><b>3. SEVERABILITY CLAUSE</b></p>
                 <p class="policies_para pb-1"> If any provision or part of these Supplemental Terms is held to be illegal, unenforceable or ineffective, such provision or part thereof shall be deemed modified to the least extent necessary to render such provision legal, enforceable and effective, or, if no such modification is possible, such provision or part thereof shall be deemed severable, such that all other provisions in and referenced in these Supplemental Terms remain valid and binding.
                 </p>
                 <p class="policies_para pb-1"></p>
                 <p class="policies_para pb-1"></p>
                </div>
               </div>'
            ],
        ];
        foreach ($staticPageDatas as $staticPageData) {
            StaticContent::create([
                'page_id' => $staticPageData['page_id'],
                'content' => $staticPageData['content'],
            ]);
        }
    }
}
