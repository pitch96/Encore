<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900&display=swap" rel="stylesheet">
    <title>Requested for Access</title>
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
                            Event Request details
                        </td>
                        <td align="right" valign="center"
                            style="border-top: 4px solid #000; border-bottom: 4px solid #000; padding: 25px 0; color: #313130; font-size: 25px; font-family: 'Lato', sans-serif;">
                            {{ url('/') }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="background: #fff; padding: 40px 0 20px 0;">
                            <p
                                style="color: #000; margin: 0; font-size: 14px; font-family: Arial, Helvetica, sans-serif;">
                                Hello and thank you for contacting Encore Events, Inc.
                                For access to your event please allow us 48 business hours to send you the user name and
                                permission to add your event to our site.
                                If you have any questions please contact us via email at
                                <a href="mailto:admin@encoreevents.live">admin@encoreevents.live</a>.
                            </p>
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
                                        Category Name
                                    </td>
                                    <td
                                        style="background-color: #d1d0d0; -webkit-print-color-adjust: exact; color: #000; font-size: 20px; padding: 10px; font-weight: 600; font-family: 'Lato', sans-serif;">
                                        Event Description
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        style="color: #000; font-size: 20px; padding: 10px; border-bottom: 1px solid #000; font-family: 'Lato', sans-serif;">
                                        {{ $event_title }}
                                    </td>
                                    <td
                                        style="color: #000; font-size: 20px; padding: 10px; border-bottom: 1px solid #000; font-family: 'Lato', sans-serif;">
                                        {{ $organizer }}
                                    </td>
                                    <td
                                        style="color: #000; font-size: 20px; padding: 10px; border-bottom: 1px solid #000; font-family: 'Lato', sans-serif;">
                                        {{ $venue }} <br>
                                        {{ $address }}
                                    </td>
                                    <td
                                        style="color: #000; font-size: 20px; padding: 10px; border-bottom: 1px solid #000; font-family: 'Lato', sans-serif;">
                                        {{ $start_date }} {{ $start_time }}
                                    </td>
                                    <td
                                        style="color: #000; font-size: 20px; padding: 10px; border-bottom: 1px solid #000; font-family: 'Lato', sans-serif;">
                                        {{ $end_date }} {{ $end_time }}
                                    </td>
                                    <td
                                        style="color: #000; font-size: 20px; padding: 10px; border-bottom: 1px solid #000; font-family: 'Lato', sans-serif;">
                                        {{ $event_category }}
                                    </td>
                                    <td
                                        style="color: #000; font-size: 20px; padding: 10px; border-bottom: 1px solid #000; font-family: 'Lato', sans-serif;">
                                        {{ $description }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="background: #fff; padding:30px 0 0;">
                <p style="color: #000; margin: 0; font-size: 12px; font-family: Arial, Helvetica, sans-serif;">
                    This is an automatically generated email. The reason you are
                    receiving this email is because you recently signed up for an
                    account at EncoreEvents.
                    <a target="_blank" href="{{ url('privacypolicy') }}"
                        style="text-decoration: none; color: #2f9fe4;">Privacy
                        Policy
                    </a>
                    and
                    <a target="_blank" href="{{ url('termsconditions') }}"
                        style="text-decoration: none; color: #2f9fe4;">Terms &
                        Conditions
                    </a>
                </p>
            </td>
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
