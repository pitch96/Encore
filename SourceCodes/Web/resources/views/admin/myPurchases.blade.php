@extends('frontend.layouts.default')
<?php error_reporting(0); ?>
@section('title', 'Search Events')
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
</style>
@section('content')
    <div class="searchevent_banner overflow-hidden main-section section-gapping">
       
        <!-- banner code start -->
        <section class="kh">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-11 col-lg-12 col-12 mt-md-5 mb-4">
                        <div class="searchevent_header">
                            <h1 class="main-title text-center">My Purchases</h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- banner code start -->

    </div>

    <div class="main_content overflow-hidden">
        <!-- tabs section-->

        <section class="main-registration">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="main-reg-bg rounded p-3">
                            <div class="container px-0">
                                <div class="row">
                                    <div class="col-md-12 col-12 px-0">
                                        <div class="starting-reg">
                                            <!-- tab 1 -->
                                            <div class="main-profile">
                                                <div class="container px-0">
                                                    <div class="tab_container">
                                                        <!-- tab 4 start -->
                                                        <div id="tab4" class="tab_content ">
                                                            <section class="blog-section pb-5 ">
                                                                <div class="container">

                                                                    <div class="tabs_4 card mt-4">
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                {{-- <div class="row mt-4">
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 py-md-0 act-blog1">
                                                                                        <div class="event_ticket text-center">
                                                                                            <h2 class="bonus_head pb-2">My
                                                                                                Order</h2>
                                                                                        </div>
                                                                                    </div>
                                                                                </div> --}}
                                                                                <div class="search-main-card-vendor position-relative search-main-banner rounded mt-4">
                                                                                    <div class="row">
                                                                                        <div class="col-lg-12 col-12">
                                                                                            <div class="user-view-vendor position-relative card shadow-sm border-rounded">
                                                                                                <div class="table_ticket table-responsive">
                                                                                                    <table id="data-table"
                                                                                                        class="table mb-0 border-rounded">
                                                                                                        <thead
                                                                                                            class="thead">
                                                                                                            <tr>
                                                                                                                <th scope="col"
                                                                                                                    class="buy_title text-left">
                                                                                                                    S.No.
                                                                                                                </th>
                                                                                                                <th scope="col"
                                                                                                                    class="buy_title text-center ">
                                                                                                                    Event
                                                                                                                    Title
                                                                                                                </th>
                                                                                                                <th scope="col"
                                                                                                                    class="buy_title text-center ">
                                                                                                                    Ticket
                                                                                                                    Title
                                                                                                                </th>
                                                                                                                <th scope="col"
                                                                                                                    class="buy_title text-center ">
                                                                                                                    Ticket
                                                                                                                    Type
                                                                                                                </th>
                                                                                                                <th scope="col"
                                                                                                                    class="buy_title text-center ">
                                                                                                                    Quantity
                                                                                                                </th>
                                                                                                                <th scope="col"
                                                                                                                    class="buy_title text-center ">
                                                                                                                    Price
                                                                                                                </th>
                                                                                                                <th scope="col"
                                                                                                                    class="buy_title text-center ">
                                                                                                                    Total
                                                                                                                    Price
                                                                                                                </th>
                                                                                                                <th scope="col"
                                                                                                                    class="buy_title text-center ">
                                                                                                                    Date &
                                                                                                                    Time
                                                                                                                </th>
                                                                                                                <th scope="col"
                                                                                                                    class="buy_title text-center ">
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
                                                                                                                <tr
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
                                                                                                                        class="summ-tds">
                                                                                                                        {{ $order_details->ticket_title }}
                                                                                                                    </td>
                                                                                                                    <td
                                                                                                                        class="summ-tds">
                                                                                                                        {{ $order_details->ticket_type }}
                                                                                                                    </td>
                                                                                                                    <td
                                                                                                                        class="summ-tds">
                                                                                                                        {{ $order_details->ticket_purchase_qty }}
                                                                                                                    </td>
                                                                                                                    <td
                                                                                                                        class="summ-tds">
                                                                                                                        {{ $order_details->ticket_price }}
                                                                                                                    </td>
                                                                                                                    <td class="summ-tds">
                                                                                                                        {{ $item->total_price }}
                                                                                                                    </td>
                                                                                                                    <td class="summ-tds">
                                                                                                                        {{ date('m/d/Y H:i A', strtotime($item->order_placed_date)) }}
                                                                                                                    </td>
                                                                                                                    <td>
                                                                                                                        <div
                                                                                                                            class="input-field second-wrap float-right">
                                                                                                                            {{-- <button
                                                                                                                                type="button"
                                                                                                                                data-toggle="modal"
                                                                                                                                data-target="#myModal"
                                                                                                                                onclick="showQrCodes({{ $item->id }})"
                                                                                                                                class="btn-search">Qr Code</button> --}}
                                                                                                                        </div>
                                                                                                                    </td>
                                                                                                                </tr>
                                                                                                            @empty
                                                                                                                <tr
                                                                                                                    class="sm-thrd">
                                                                                                                    <td colspan="8"
                                                                                                                        class="text-center">
                                                                                                                        {{ trans('messages.record_not_found') }}
                                                                                                                    </td>
                                                                                                                </tr>
                                                                                                            @endforelse
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
                                                            </section>
                                                        </div>
                                                        <!-- tab 4 end -->
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
                <div style="margin-top: 50px;" id="myModal" class="modal fade hidden" role="dialog">
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
                                    <div class="input-field second-wrap float-left row" id="paginationBtn" style="margin-right: 1px; margin-top: 8px;"></div>
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
