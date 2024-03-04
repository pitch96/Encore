@extends('frontend.layouts.default')
<?php error_reporting(0); ?>
@section('title', 'My Account')
@section('style')
 
@endsection

<style>
    .parent {
        border: 1px solid #212529;
        padding: 20px;
    }

    .child {
        width: 50%;
        float: left;
        padding: 20px;
    }
    .disabledBtn {
        background: grey !important;
    }
</style>
@section('content')
<div class="overflow-hidden main-section section-gapping">

    <div class="searchevent_banner">
       
        <!-- banner code start -->
        <section class="kh">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-11 col-lg-12 col-12 mt-md-5 mb-4">
                        <div class="searchevent_header">
                            <h1 class="main-title text-center">My Account</h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- banner code start -->

    </div>

    
        <!-- tabs section-->

        
    

        <section class="main-registration">
            <div class="container">
            <div class="tab-teaser">
                <div class="tab-menu">
                <ul>
                    <li><a href="#" class="active category-title" data-rel="tab-1" style="text-transform:capitalize!important">Account</a></li>
                    <li><a href="#" data-rel="tab-2" class="category-title" style="text-transform:capitalize!important">Order History</a></li>
                </ul>
            </div>
        
        <div class="tab-main-box">
            <div class="tab-box no-bg" id="tab-1" style="display:block;">
                <div class="tabs_4 card">
                    <div class="row">
                        <div class="col-12">
                            <div class="row main-reg-bg rounded px-3 mt-4 d-flex">

                                <div class="col-xl-3 col-lg-3 col-md-12 mb-4 d-flex justify-content-center align-items-center" style="flex: 0.3">
                                    <div class="acc_dp">
                                        <img src="{{ $user->user_image }}" class="account_image img-fluid">
                                    </div>
                                </div>

                                <div
                                    class="col-xl-9 col-lg-9 col-md-12 mt-md-4">
                                    <div class="user-content-vendor">

                                        <form
                                            class="needs-validation validation_form"
                                            method="POST"
                                            action="{{ url('update/user/' . Crypt::encrypt($user->id)) }}"
                                            enctype="multipart/form-data"
                                            novalidate="">
                                            @method('put')
                                            @csrf

                                            <div class="form-control">
                                                <input type="text" placeholder="First name" maxLength="20" name="first_name" id="first_name" class="input-fields" value="{{ $user->first_name }}" required>
                                            </div>
                                            <div class="form-control">
                                                <input type="text" placeholder="Last name" maxLength="20" name="last_name" id="last_name" class="input-fields" value="{{ $user->last_name }}" required>
                                            </div>
                                            <div class="form-control">
                                                <input type="email" placeholder="Email" name="email" id="email" class="input-fields" value="{{ $user->email }}" readonly>
                                            </div>
                                            <div class="form-control">
                                                <input type="text" placeholder="(123) 456-7890" name="phone_no" id="phone_no" class="input-fields" value="{{ $user->phone_no }}" required>
                                            </div>
                                            <div class="form-control">
                                                <input type="text" placeholder="Company name" name="company_name" id="company_name" class="input-fields" value="{{ $user->company_name }}">
                                            </div>

                                            <div class="form-control">
                                                <input type="file" name="user_profile" class="acc_email custom-file-input input-fields" id="fileUpload" accept="image/*"> 
                                            </div>
                                            <div class="form-control">
                                                <input type="submit" value="Submit" class="btn-common">
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-box" id="tab-2">
                <div class="tabs_4 card mt-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="search-main-card-vendor position-relative search-main-banner rounded mt-4">
                                <div class="row">
                                    <div class="col-lg-12 col-12">
                                        <div
                                            class="user-view-vendor position-relative card shadow-sm border-rounded">
                                            <div
                                                class="table_ticket table-responsive">
                                                <table id="ordertable" class="table mb-0 border-rounded">
                                                    <thead
                                                        class="thead">
                                                        <tr>
                                                            <th scope="col" class="buy_title text-left">
                                                                S.No.
                                                            </th>
                                                            <th scope="col" class="buy_title text-center ">
                                                                Event
                                                                Title
                                                            </th>
                                                            <th scope="col" class="buy_title text-center tkt-dtl">
                                                                Ticket
                                                                Title
                                                            </th>
                                                            <th scope="col" class="buy_title text-center tkt-dtl ">
                                                                Ticket
                                                                Type
                                                            </th>
                                                            <th scope="col" class="buy_title text-center tkt-dtl ">
                                                                Quantity
                                                            </th>
                                                            <th scope="col" class="buy_title text-center tkt-dtl ">
                                                                Price
                                                            </th>
                                                            <th scope="col" class="buy_title text-center tkt-dtl ">
                                                                Total
                                                                Price
                                                            </th>
                                                            <th scope="col" class="buy_title text-center tkt-dtl ">
                                                                Date &
                                                                Time
                                                            </th>
                                                            <th scope="col" class="buy_title text-center  ">
                                                                Check
                                                                Tickets
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($order_data as $key => $item)
                                                            @php
                                                                $order_details = json_decode($item->order_details);
                                                            @endphp
                                                            <tr @if ($item->isCancelled === 1)
                                                                    style="background: #382d2d;"
                                                                @endif
                                                                class="sm-thrd">
                                                                <td
                                                                    class="summ-tds">
                                                                    {{ $key + 1 }}
                                                                </td>
                                                                <td
                                                                    class="summ-tds">
                                                                    <a
                                                                        href="{{ url('event/detail/' . $order_details->event_id) }}">{{ Str::length($order_details->event_title) > 30 ? substr($order_details->event_title, 0, 30) . '...' : $order_details->event_title }}</a>
                                                                </td>
                                                                <td
                                                                    class="summ-tds tkt-dtl">
                                                                    {{ $order_details->ticket_title }}
                                                                </td>
                                                                <td
                                                                    class="summ-tds tkt-dtl">
                                                                    {{ $order_details->ticket_type }}
                                                                </td>
                                                                <td
                                                                    class="summ-tds tkt-dtl">
                                                                    {{ $order_details->ticket_purchase_qty }}
                                                                </td>
                                                                <td
                                                                    class="summ-tds tkt-dtl">
                                                                    {{ $order_details->ticket_price }}
                                                                </td>
                                                                <td class="summ-tds tkt-dtl">
                                                                    {{ $item->total_price }}
                                                                </td>
                                                                <td class="summ-tds tkt-dtl">
                                                                    {{ date('m/d/Y H:i A', strtotime($item->order_placed_date)) }}
                                                                </td>
                                                                <td>
                                                                    @if ($item->isCancelled === 1)
                                                                    <div
                                                                    class="input-field second-wrap float-right">
                                                                    <button
                                                                        title="Event Cancelled"
                                                                        type="button"
                                                                        onclick="cancelNotification({{ $item->id }})"
                                                                        class="btn-search">
                                                                        <i class="fa fa-ban" aria-hidden="true">
                                                                        </i>
                                                                    </button>
                                                                </div>
                                                                    @else
                                                                    <div
                                                                        class="input-field second-wrap ">
                                                                        <button
                                                                            title="Show QRs"
                                                                            type="button"
                                                                            data-toggle="modal"
                                                                            data-target="#myModal"
                                                                            onclick="showQrCodes({{ $item->id }})"
                                                                            class="btn-search" style="margin-left: auto;margin-right:auto;"><i
                                                                                class="fa fa-qrcode"
                                                                                aria-hidden="true" ></i></button>  
                                                                    </div>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
          </div>


                <!--Start Show QR codes for each orders/ticket Modal -->
                <div style="margin-top: 50px;" id="myModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div style="background: #212529;" class="modal-content">
                            <div class="modal-header">
                                <h4 style="color: #dee2e6" class="modal-title">{{ 'Event Qr Codes: ' }}
                                    <b id="event_name"></b>
                                </h4>
                            </div>
                            <center>
                                <p id="event_start-date" style="color: #dee2e6"></p>
                                <p id="event_end-date" style="color: #dee2e6; margin-top: -16px;"></p>
                            </center>

                            <div class="parent">
                                <div class="modal-body child" id="showTicketsForMyOrders">
                                </div>
                                <div class="child" id="qrRender"></div>
                            </div>
                            <div class="modal-footer">
                                <center>
                                    <input type="hidden" name="page_num" id="page_num">
                                    <div class="input-field second-wrap float-left bootstrap-row" id="paginationBtn" style="margin-right: 1px; margin-top: 8px;"></div>
                                </center>
                            </div>
                        </div>

                    </div>
                </div>
                <!--End Show QR codes for each orders/ticket Modal -->
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script src="{{ asset('frontend/customjs/dashboard.js?v=' . time()) }}"></script>
    <script src="{{ asset('customjs/profile.js?v=' . time()) }}"></script>
@endsection
