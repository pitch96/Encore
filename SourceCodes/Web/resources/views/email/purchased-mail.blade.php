<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900&display=swap" rel="stylesheet">
    <title>Order Details</title>
</head>

<body>
    @php
        $billing_address = json_decode($billing_address);
        $order_detail = json_decode($order_details);
    @endphp
    <table cellpadding="0" cellspacing="0" style="width:100%">
        <tr>
            <td align="center" style="padding: 15px;">
                <table cellpadding="0" cellspacing="0" style="width:100%">
                    <tr>
                        <td style="border-top: 4px solid #000; border-bottom: 4px solid #000; padding: 25px 0;">
                            <img src="{{ asset('assets/dist/img/brand_logo.png') }}" alt="Encore Events" />
                        </td>
                        <td align="center" valign="center"
                            style="border-top: 4px solid #000; border-bottom: 4px solid #000; padding: 25px 0; color: #313130; font-size: 30px; font-weight: 600; text-transform: uppercase; font-family: 'Lato', sans-serif;">
                            Order details
                        </td>
                        <td align="right" valign="center"
                            style="border-top: 4px solid #000; border-bottom: 4px solid #000; padding: 25px 0; color: #313130; font-size: 25px; font-family: 'Lato', sans-serif;">
                            {{ url('/') }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="padding: 70px 0;">
                            <table cellpadding="0" cellspacing="0" style="width:100%">
                                <tr>
                                    <td>
                                        <span
                                            style="color: #000; font-size: 27px; display: block; font-family: 'Lato', sans-serif;"><strong>User
                                                Details: </strong></span> <br>
                                        <span
                                            style="color: #000; font-size: 24px; display: block; font-family: 'Lato', sans-serif;">{{ $full_name }},
                                            {{ $billing_address->address }}</span>
                                    </td>
                                    <td align="right">
                                        <span
                                            style="color: #000; font-size: 27px; display: block; font-family: 'Lato', sans-serif;"><strong>Order
                                                No:</strong> {{ $order_no }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span
                                            style="color: #000; font-size: 27px; display: block; font-family: 'Lato', sans-serif;"><strong>Contact
                                                Details: </strong></span> <br>
                                        <span
                                            style="color: #000; font-size: 24px; display: block; font-family: 'Lato', sans-serif;">{{ $billing_address->phone_no }},
                                            {{ $billing_address->email }}</span>
                                    </td>
                                    <td align="right">
                                        <span
                                            style="color: #000; font-size: 24px; display: block; font-family: 'Lato', sans-serif;"><strong>
                                                Ticket Purchase Date: </strong>{{ $order_placed_date }}</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <table cellpadding="0" cellspacing="0" style="width:100%">
                                <tr>
                                    <td
                                        style="background-color: #d1d0d0; -webkit-print-color-adjust: exact; color: #000; font-size: 20px; padding: 10px; font-weight: 600; font-family: 'Lato', sans-serif;">
                                        Event Name
                                    </td>
                                    <td
                                        style="background-color: #d1d0d0; -webkit-print-color-adjust: exact; color: #000; font-size: 20px; padding: 10px; font-weight: 600; font-family: 'Lato', sans-serif;">
                                        Organizer
                                    </td>
                                    <td
                                        style="background-color: #d1d0d0; -webkit-print-color-adjust: exact; color: #000; font-size: 20px; padding: 10px; font-weight: 600; font-family: 'Lato', sans-serif;">
                                        Venue/Address
                                    </td>
                                    <td
                                        style="background-color: #d1d0d0; -webkit-print-color-adjust: exact; color: #000; font-size: 20px; padding: 10px; font-weight: 600; font-family: 'Lato', sans-serif;">
                                        Start Date
                                    </td>
                                    <td
                                        style="background-color: #d1d0d0; -webkit-print-color-adjust: exact; color: #000; font-size: 20px; padding: 10px; font-weight: 600; font-family: 'Lato', sans-serif;">
                                        End Date
                                    </td>
                                    <td
                                        style="background-color: #d1d0d0; -webkit-print-color-adjust: exact; color: #000; font-size: 20px; padding: 10px; font-weight: 600; font-family: 'Lato', sans-serif;">
                                        Ticket Type
                                    </td>
                                    <td
                                        style="background-color: #d1d0d0; -webkit-print-color-adjust: exact; color: #000; font-size: 20px; padding: 10px; font-weight: 600; font-family: 'Lato', sans-serif;">
                                        Ticket Quantity
                                    </td>
                                    <td
                                        style="background-color: #d1d0d0; -webkit-print-color-adjust: exact; color: #000; font-size: 20px; padding: 10px; font-weight: 600; font-family: 'Lato', sans-serif;">
                                        Price($)
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        style="color: #000; font-size: 20px; padding: 10px; border-bottom: 1px solid #000; font-family: 'Lato', sans-serif;">
                                        {{ $order_detail->event_title }}
                                    </td>
                                    <td
                                        style="color: #000; font-size: 20px; padding: 10px; border-bottom: 1px solid #000; font-family: 'Lato', sans-serif;">
                                        {{ $order_detail->event_organizer }}
                                    </td>
                                    <td
                                        style="color: #000; font-size: 20px; padding: 10px; border-bottom: 1px solid #000; font-family: 'Lato', sans-serif;">
                                        {{ $order_detail->event_venue }} <br>
                                        {{ $order_detail->event_address }}
                                    </td>
                                    <td
                                        style="color: #000; font-size: 20px; padding: 10px; border-bottom: 1px solid #000; font-family: 'Lato', sans-serif;">
                                        {{ $order_detail->event_start_date }} {{ $order_detail->event_start_time }}
                                    </td>
                                    <td
                                        style="color: #000; font-size: 20px; padding: 10px; border-bottom: 1px solid #000; font-family: 'Lato', sans-serif;">
                                        {{ $order_detail->event_end_date }} {{ $order_detail->event_end_time }}
                                    </td>
                                    <td
                                        style="color: #000; font-size: 20px; padding: 10px; border-bottom: 1px solid #000; font-family: 'Lato', sans-serif;">
                                        {{ $order_detail->ticket_title }}
                                    </td>
                                    <td
                                        style="color: #000; font-size: 20px; padding: 10px; border-bottom: 1px solid #000; font-family: 'Lato', sans-serif;">
                                        {{ $order_detail->ticket_purchase_qty }}
                                    </td>
                                    <td
                                        style="color: #000; font-size: 20px; padding: 10px; border-bottom: 1px solid #000; font-family: 'Lato', sans-serif;">
                                        {{ $order_detail->ticket_price }}
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="bottom" colspan="6" rowspan="3">
                                    </td>
                                    <td
                                        style="color: #000; font-size: 28px; text-transform: uppercase; padding: 10px; font-weight: 600; font-family: 'Lato', sans-serif;">
                                        SUBTOTAL($):
                                    </td>
                                    <td
                                        style="color: #000; font-size: 26px; padding: 10px; font-family: 'Lato', sans-serif;">
                                        {{ $order_detail->total_price }}
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        style="color: #000; font-size: 28px; text-transform: uppercase; padding: 5px 10px 10px 10px; font-weight: 600; font-family: 'Lato', sans-serif;">
                                        Transanction Charge
                                    </td>
                                    <td
                                        style="color: #000; font-size: 26px; padding: 5px 10px 10px 10px; font-family: 'Lato', sans-serif;">
                                        @php
                                        $transfer_charge = ($order_detail->total_price - (2.9/(100))*$order_detail->total_price)-0.3;
                                        $transaction_charge = $order_detail->total_price - $transfer_charge;
                                        @endphp
                                        {{ $transaction_charge }}
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        style="color: #000; font-size: 28px; text-transform: uppercase; padding: 5px 10px 10px 10px; font-weight: 600; font-family: 'Lato', sans-serif;">
                                        Tax(%)
                                    </td>
                                    <td
                                        style="color: #000; font-size: 26px; padding: 5px 10px 10px 10px; font-family: 'Lato', sans-serif;">
                                        0
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        style="color: #000; font-size: 28px; border-top: 2px solid #000; border-bottom: 2px solid #000; text-transform: uppercase; padding: 5px 10px 10px 10px; font-weight: 600; font-family: 'Lato', sans-serif;">
                                        Total($)
                                    </td>
                                    <td
                                        style="color: #000; font-size: 26px; border-top: 2px solid #000; border-bottom: 2px solid #000; padding: 5px 10px 10px 10px; font-family: 'Lato', sans-serif;">
                                        {{ $order_detail->total_price }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr style="background: yellow;">{{  'Note: Transanction Charge is not refundable in any case' }}</tr>
                </table>
            </td>
        </tr>
        <tr>
            <table cellpadding="0" cellspacing="0" style="width:100%">
                <tr>
                    <td colspan="2" style="background: #fff; padding: 15px 0 0 0; border-top: 1px solid #cfcfcf;">
                        <p
                            style="color: #000;  margin: 0; font-size: 18px; font-family: Times New Roman, Helvetica, sans-serif;">
                            QR code
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 7px 7px 7px 0;">
                        <table cellpadding="0" cellspacing="0" style="width: 100%;">
                            <tr>
                                {{-- @for ($i = 0; $i < $order_detail->ticket_purchase_qty; $i++)
                                    @php
                                        $ticket_number = (int) $total_sold_ticket_count++;
                                    @endphp
                                    <td colspan="2" style="padding-bottom: 7px;">
                                        <img src='https://chart.googleapis.com/chart?cht=qr&chs=200x200&chld=L|0&chl={{ url('orderDetails/' . base64_encode($order_id) . '/' . base64_encode($ticket_number)) }}'
                                            alt="Thubnail" style="width: 100%;" />
                                    </td>
                                @endfor --}}
                                @foreach ($qr_numbers as $qr_number)
                                    <td colspan="2" style="padding-bottom: 7px;">
                                        <img src='https://chart.googleapis.com/chart?cht=qr&chs=200x200&chld=L|0&chl={{ $qr_number->ticket_no }}'
                                            alt="Thubnail" style="width: 100%;" />
                                    </td>
                                @endforeach
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
        </tr>
        <tr>
            <td colspan="3" style="background: #fff; padding: 40px 0 20px 0;">
                <p style="color: #000; margin: 0; font-size: 14px; font-family: Arial, Helvetica, sans-serif;">
                    Regards,
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="background: #fff; padding-bottom: 30px;">
                <p style="color: #000; margin: 0; font-size: 14px; font-family: Arial, Helvetica, sans-serif;">
                    Team EncoreEvents
                </p>
            </td>
        </tr>
    </table>

</body>

</html>
