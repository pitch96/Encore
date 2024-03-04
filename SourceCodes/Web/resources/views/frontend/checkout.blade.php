@extends('frontend.layouts.app')
<?php error_reporting(0); ?>
@section('title', 'My Cart')
@section('style')
    
@endsection
@section('content')
    <div class="topper">
        @include('frontend.layouts.header')


    </div>

    <div class="overflow-hidden" id="user_bg">
        <section class="act_system_section pt-5 mt-5">
            <div class="container">
                <div class="row mt-4">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 py-md-0 act-blog1">
                        <div class="event_ticket text-left">
                            <h2 class="pt-5">Event Ticket</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="search-main-card-vendor position-relative search-main-banner rounded mt-4">
                            <div class="row">
                                <div class="col-lg-8 col-12">
                                    <div class="user-view-vendor position-relative card shadow-sm border-rounded mb-4">
                                        <div class="table_ticket table-responsive">
                                            <table class="table mb-0 border-rounded">
                                                <thead class="thead">
                                                    <tr>
                                                        <th scope="col" class="buy_title text-left">Image</th>
                                                        <th scope="col" class="buy_title text-left">Event Title</th>
                                                        <th scope="col" class="buy_title text-left">Ticket Title</th>
                                                        <th scope="col" class="buy_title text-center ">Unit Price</th>
                                                        <th scope="col" class="buy_title text-center ">Quantity</th>
                                                        <th scope="col" class="buy_title text-center ">Amount</th>
                                                        <th scope="col" class="buy_title text-center ">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $totalCartItems = 0;
                                                        $totalPrice = 0;
                                                        $cart_items = [];
                                                    @endphp
                                                    @forelse ($cartDatas as $item)
                                                        @php
                                                            $totalCartItems += $item->quantity;
                                                            $totalPrice += $item->quantity * $item->ticket->price;
                                                            array_push($cart_items, $item->id);
                                                        @endphp
                                                        <tr class="sm-thrd">
                                                            <th scope="row">
                                                                <div class="summary-content">
                                                                    <div class="row text-left">
                                                                        <div class="col-md-12">
                                                                            <div class="pop-wrap position-relative">
                                                                                <div class="pop-icon position-absolute">
                                                                                    <img src="{{ asset('event-images/' . $item->ticket->event->image) }}"
                                                                                        height="60" width="60"
                                                                                        class="img-fluid">
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </th>
                                                            <td class="summ-tds">
                                                                {{ Str::length($item->ticket->event->event_title) > 20 ? substr($item->ticket->event->event_title, 0, 20) . '...' : $item->ticket->event->event_title }}
                                                            </td>
                                                            <input type="hidden"
                                                                class="total_no_of_ticket{{ $item->id }}"
                                                                value="{{ $item->ticket->quantity }}">
                                                            <input type="hidden" class="ticket_id{{ $item->id }}"
                                                                value="{{ $item->ticket_id }}">
                                                            <td class="summ-tds"> {{ $item->ticket->ticket_title }}</td>
                                                            <td class="summ-tds">$ <span
                                                                    class="price_per_head{{ $item->id }}">{{ $item->ticket->price }}</span>
                                                            </td>
                                                            <td class="summ-tds">
                                                                <div class="input-group plus_minus_btn">
                                                                    <input type="button" value="-"
                                                                        class="button-minus manage-quantity"
                                                                        data-field="quantity" data-value="mins"
                                                                        data-id="{{ $item->id }}">
                                                                    <input type="number" step="1" min="1"
                                                                        value="{{ $item->quantity }}" name="quantity"
                                                                        class="quantity-field ticket_qty{{ $item->id }}"
                                                                        readonly>
                                                                    <input type="button" value="+"
                                                                        class="button-plus manage-quantity"
                                                                        data-field="quantity" data-value="plus"
                                                                        data-id="{{ $item->id }}">
                                                                </div>
                                                            </td>
                                                            <td class="summ-tds">$ <span
                                                                    class="total_price{{ $item->id }}">{{ $item->quantity * $item->ticket->price }}</span>
                                                            </td>
                                                            <td class="summ-tds"> <a href="javascript:void(0)"
                                                                    class="deleteTicket"
                                                                    data-cart_id="{{ $item->id }}"><i
                                                                        class="fa fa-trash" aria-hidden="true"></i> </a>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr class="sm-thrd">
                                                            <td colspan="7" class="text-center text-white">Cart is empty</td>
                                                        </tr>
                                                    @endforelse

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-12">

                                    <div class="schedule-card p-4 rounded">
                                        <p class="price_detail"> Order Detail </p>
                                        <div class="order_no d-flex justify-content-between align-items-center">
                                            <p class="mb-0 text-left">Price ( {{ $totalCartItems }} Itmes)</p>
                                            <p class="mb-0 text-right sub_total">${{ $totalPrice }}</p>
                                        </div>
                                        <div class="order_no d-flex justify-content-between align-items-center">
                                            <p class="mb-0 text-left">Discount</p>
                                            <p class="mb-0 text-right discount">$0</p>
                                        </div>
                                        <div class="total_price order_no d-flex justify-content-between align-items-center">
                                            <p class="mb-0 text-left">Total Price</p>
                                            <p class="mb-0 text-right total_amount">${{ $totalPrice }}</p>
                                        </div>
                                        <!-- <a href="javascript:void(0)" class="text-decoration-none place_order">
                                            <div class="input-field third-wrap mt-4">
                                                <button class="btn-search btn-block" type="button ">Place Order</button>
                                            </div>
                                        </a> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="accordionsection pt-5 mt-5">
            <div class="container">
                <div class="row mt-4">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 py-md-0 act-blog1">
                        <div class="event_ticket text-left">
                            <h2 class="g">Payment Checkout</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div id="main">
                            <div class="conr">
                                <div class="accordion" id="faq">
                                    <div class="card">
                                        <div class="card-header" id="faqhead1">
                                            <a href="#" class="btn btn-header-link collapsed "
                                                data-toggle="collapse"
                                                data-target="{{ count($cart_items) > 0 ? '#billing_address' : '' }}"
                                                aria-expanded="false" aria-controls="billing_address">Billing Address</a>
                                        </div>

                                        <div id="billing_address" class="collapse" aria-labelledby="faqhead1"
                                            data-parent="#faq">
                                            <div class="card-body">
                                                <form class="needs-validation validation_form" novalidate="">
                                                    <input type="hidden" id="cart_items"
                                                        value="{{ implode(',', $cart_items) }}">
                                                    <input type="hidden" class="billing_data" name="active_address_id"
                                                        id="active_address_id" value="{{ $active_address->id ? $active_address->id : '' }}">
                                                    <div class="form-row">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="ticket_label" for="validationCustom11">Full
                                                                Name</label>
                                                            <input type="text"
                                                                class="form-control cust-sel-size billing_data name-field"
                                                                name="full_name" id="validationCustom11"
                                                                placeholder="Full Name"
                                                                value="{{ $active_address->full_name ?? '' }}"
                                                                required="">
                                                            <div class="invalid-feedback text-left form-validation">
                                                                This field is required.
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="ticket_label" for="validationCustom01"> Phone
                                                                Number </label>
                                                            <input type="text"
                                                                class="form-control cust-sel-size billing_data phone_no"
                                                                name="phone_no" id="validationCustom01"
                                                                placeholder="Phone Number"
                                                                value="{{ $active_address->phone_no ?? '' }}"
                                                                required="">
                                                            <div class="invalid-feedback text-left form-validation">
                                                                This field is required.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="ticket_label" for="validationCustom02">Email
                                                                ID</label>
                                                            <input type="text"
                                                                class="form-control cust-sel-size billing_data"
                                                                name="email" id="validationCustom02"
                                                                placeholder="Email ID"
                                                                value="{{ $active_address->email ?? '' }}"
                                                                required="">
                                                            <div class="invalid-feedback text-left form-validation">
                                                                This field is required.
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 mb-3">
                                                            <label class="ticket_label"
                                                                for="validationCustom03">State</label>
                                                            <input type="text"
                                                                class="form-control cust-sel-size billing_data name-field"
                                                                name="state" id="validationCustom03"
                                                                placeholder="State"
                                                                value="{{ $active_address->state ?? '' }}"
                                                                required="">
                                                            <div class="invalid-feedback text-left form-validation">
                                                                This field is required.
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 mb-3">
                                                            <label class="ticket_label"
                                                                for="validationCustom04">City</label>
                                                            <input type="text"
                                                                class="form-control cust-sel-size billing_data name-field"
                                                                name="city" id="validationCustom04" placeholder="City"
                                                                value="{{ $active_address->city ?? '' }}" required="">
                                                            <div class="invalid-feedback text-left form-validation">
                                                                This field is required.
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 mb-3">
                                                            <label class="ticket_label"
                                                                for="validationCustom05">Zipcode</label>
                                                            <input type="text"
                                                                class="form-control cust-sel-size billing_data zipcode"
                                                                name="zipcode" id="validationCustom05"
                                                                placeholder="Zipcode"
                                                                value="{{ $active_address->zipcode ?? '' }}"
                                                                required="">
                                                            <div class="invalid-feedback text-left form-validation">
                                                                This field is required.
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="form-row py-2">
                                                        <div class="col-md-12 mb-3">
                                                            <label class="ticket_label"
                                                                for="validationCustom10">Address 2</label>
                                                            <textarea class="form-control cust-sel-size billing_data" name="address" id="validationCustom10" rows="4" cols="40" required="" placeholder="Address">{{ $active_address->address ?? '' }}</textarea>
                                                            <div class="invalid-feedback text-left form-validation">
                                                                This field is required.
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <p class="border_line d-flex justify-content-between py-2 mb-3"
                                                        style="color: #E4E4E4;"> </p>
                                                        <a href="javascript:void(0)"><button  class="btn-search float-right"
                                                                        >Submit</button>
                                                                </a>
                                                    <div class="form-row">
                                                        <div class="col-12 mb-3">
                                                            <div class="input-field third-wrap mt-4">
                                                                <a href="javascript:void(0)"><button  class="btn-search float-right"
                                                                        @if ($totalPrice == 0) id="purches_ticket" @else id="billing-data" @endif>Submit</button>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card"
                                        @if ($totalPrice == 0) style="display: none" @else style="display: block" @endif>
                                        <div class="card-header" id="faqhead2">
                                            <a href="#" class="btn btn-header-link collapsed"
                                                data-toggle="collapse"
                                                data-target="{{ count($cart_items) > 0 ? '#payment_option' : '' }}"
                                                aria-expanded="true" aria-controls="payment_option">Payment Options</a>
                                        </div>

                                        <div id="payment_option" class="collapse" aria-labelledby="faqhead2"
                                            data-parent="#faq">
                                            <div class="card-body">
                                                <form class="needs-validation validation_form validation" novalidate=""
                                                    role="form" data-cc-on-file="false"
                                                    data-stripe-publishable-key="{{ config('constants.STRIPE_KEY') }}"
                                                    id="payment-form">
                                                    @csrf
                                                    <div class="form-row">
                                                        <div class="col-md-3 mb-3">
                                                            <label class="ticket_label" for="validationCustom06"> Card Holder Name </label>
                                                            <input type="text"
                                                                class="form-control cust-sel-size name-field"
                                                                id="validationCustom06" placeholder="Card Holder Name" value=""
                                                                required="" maxlength="30">
                                                            <div class="invalid-feedback text-left form-validation">
                                                                This field is required.
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 mb-3">
                                                            <label class="ticket_label" for="validationCustom06"> Credit/Debit Card </label>
                                                            <input type="text"
                                                                class="form-control cust-sel-size card_no"
                                                                id="validationCustom06" placeholder="Credit/Debit Card" value=""
                                                                required="">
                                                            <div class="invalid-feedback text-left form-validation">
                                                                This field is required.
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2 mb-3">
                                                            <label class="ticket_label" for="validationCustom07">Expiry Month</label>
                                                            <input type="text" class="form-control cust-sel-size month"
                                                                id="validationCustom07" placeholder="MM" value=""
                                                                required="">
                                                            <div class="invalid-feedback text-left form-validation">
                                                                This field is required.
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 mb-3">
                                                            <label class="ticket_label" for="validationCustom08">Expiry Year</label>
                                                            <input type="text" class="form-control cust-sel-size year"
                                                                id="validationCustom08" placeholder="YYYY" value=""
                                                                required="">
                                                            <div class="invalid-feedback text-left form-validation">
                                                                This field is required.
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 mb-3">
                                                            <label class="ticket_label"
                                                                for="validationCustom09">CVV</label>
                                                            <input type="text" class="form-control cust-sel-size cvv"
                                                                id="validationCustom09" placeholder="CVV" value=""
                                                                required="">
                                                            <div class="invalid-feedback text-left form-validation">
                                                                This field is required.
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class='form-row row'>
                                                        <div class='col-md-12 error form-group' style="display: none">
                                                            <div class='alert-danger alert'>Fix the errors before you
                                                                begin.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="border_line d-flex justify-content-between py-2 mb-3"> </p>
                                                    <div class="form-row">
                                                        <div class="col-12 mb-3">
                                                            <div class="input-field third-wrap mt-4">
                                                                <a href="javascript:void(0)">
                                                                    <button class="btn-search float-right" id="buy_ticket"
                                                                        type="submit">Submit</button>
                                                                </a>
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
                    </div>
                </div>
            </div>
        </section>
        <!-- filter code end -->

    </div>

@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('js/stripe.js?v=' . time()) }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/customjs/checkout.js?v=' . time()) }}"></script>
@endsection
