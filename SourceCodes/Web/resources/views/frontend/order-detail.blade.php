<!DOCTYPE html>
<html lang="en">
<?php error_reporting(0); ?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900&display=swap" rel="stylesheet">
    <title>Order Details</title>
</head>

<body>
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
                            <a href="{{ url('/') }}" target="_blank"
                                rel="noopener noreferrer">{{ url('/') }}</a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="padding: 70px 0;">
                            <table cellpadding="0" cellspacing="0" style="width:100%">
                                <tr>
                                    <td>
                                        <span
                                            style="color: #000; font-size: 27px; display: block; font-family: 'Lato', sans-serif;"><strong>Total
                                                Ticket: </strong> {{ $order_details->ticket_purchase_qty }}</span> <br>
                                    </td>
                                    <td align="right">
                                        <span
                                            style="color: #000; font-size: 27px; display: block; font-family: 'Lato', sans-serif;"><strong>Ticket
                                                No: </strong> {{ $ticket_no }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span
                                            style="color: #000; font-size: 27px; display: block; font-family: 'Lato', sans-serif;"><strong>Event
                                                Description: </strong></span> <br>
                                        <span
                                            style="color: #000; font-size: 24px; display: block; font-family: 'Lato', sans-serif;">{{ $order_details->event_description }}</span>
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
                                        {{ $order_details->event_title }}
                                    </td>
                                    <td
                                        style="color: #000; font-size: 20px; padding: 10px; border-bottom: 1px solid #000; font-family: 'Lato', sans-serif;">
                                        {{ $order_details->event_organizer }}
                                    </td>
                                    <td
                                        style="color: #000; font-size: 20px; padding: 10px; border-bottom: 1px solid #000; font-family: 'Lato', sans-serif;">
                                        {{ $order_details->event_venue }} <br>
                                        {{ $order_details->event_address }}
                                    </td>
                                    <td
                                        style="color: #000; font-size: 20px; padding: 10px; border-bottom: 1px solid #000; font-family: 'Lato', sans-serif;">
                                        {{ $order_details->event_start_date }} {{ $order_details->event_start_time }}
                                    </td>
                                    <td
                                        style="color: #000; font-size: 20px; padding: 10px; border-bottom: 1px solid #000; font-family: 'Lato', sans-serif;">
                                        {{ $order_details->event_end_date }} {{ $order_details->event_end_time }}
                                    </td>
                                    <td
                                        style="color: #000; font-size: 20px; padding: 10px; border-bottom: 1px solid #000; font-family: 'Lato', sans-serif;">
                                        {{ $order_details->ticket_title }}
                                    </td>
                                    <td
                                        style="color: #000; font-size: 20px; padding: 10px; border-bottom: 1px solid #000; font-family: 'Lato', sans-serif;">
                                        {{ $order_details->ticket_purchase_qty }}
                                    </td>
                                    <td
                                        style="color: #000; font-size: 20px; padding: 10px; border-bottom: 1px solid #000; font-family: 'Lato', sans-serif;">
                                        {{ $order_details->ticket_price }}
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="bottom" colspan="6" rowspan="3"></td>
                                    <td
                                        style="color: #000; font-size: 28px; text-transform: uppercase; padding: 10px; font-weight: 600; font-family: 'Lato', sans-serif;">
                                        SUBTOTAL($):
                                    </td>
                                    <td
                                        style="color: #000; font-size: 26px; padding: 10px; font-family: 'Lato', sans-serif;">
                                        {{ $order_details->total_price }}
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
                                        {{ $order_details->total_price }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>


    </table>

</body>

</html>
