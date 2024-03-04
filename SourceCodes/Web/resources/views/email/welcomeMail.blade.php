<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900&display=swap" rel="stylesheet">
    <title>Signup Email</title>
</head>

<body style="margin: 0;">
    <table cellpadding="0" cellspacing="0" style="width:100%">
        <tr>
            <td align="center">
                <table cellpadding="0" cellspacing="0" width="600">
                    <tr>
                        <td style="background: #fff; padding: 20px; border: 1px solid #ddd;">
                            <table cellpadding="0" cellspacing="0" style="width:100%">
                                <tr>
                                    <td>
                                        <img src="{{ asset('assets/dist/img/brand_logo.png') }}" alt="EncoreEvents"
                                            height="40" />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="padding: 25px 0 20px 0;">
                                        <p
                                            style="color: #000; margin: 0; font-size: 14px; font-family: Arial, Helvetica, sans-serif;">
                                            Hi {{ $first_name }}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table cellpadding="0" cellspacing="0" style="width:100%">
                                            <tr>
                                                <td colspan="3" style="padding: 25px 0 20px 0;">
                                                    <h1
                                                        style="color: #000; margin: 0; font-size: 24px; font-family: Arial, Helvetica, sans-serif;">
                                                        Welcome to EncoreEvents
                                                    </h1>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="background: #fff; padding: 0 0 30px 0;">
                                                    <p
                                                        style="color: #000; margin: 0; font-size: 14px; font-family: Arial, Helvetica, sans-serif;">
                                                        Hello and thank you for registering with Encore Events, Inc.
                                                        Please give us 48 business hours to contact you and
                                                        provide information on your registration.
                                                        If you need anything before then please contact us via email at
                                                        <a
                                                            href="mailto:admin@encoreevents.live">admin@encoreevents.live</a>
                                                    </p>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="3" style="background: #fff; padding:30px 0 0;">
                                                    <p
                                                        style="color: #000; margin: 0; font-size: 12px; font-family: Arial, Helvetica, sans-serif;">
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
                                                    <p
                                                        style="color: #000; margin: 0; font-size: 14px; font-family: Arial, Helvetica, sans-serif;">
                                                        Regards,
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="background: #fff; padding-bottom: 30px;">
                                                    <p
                                                        style="color: #000; margin: 0; font-size: 14px; font-family: Arial, Helvetica, sans-serif;">
                                                        Team EncoreEvents
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="background: #fff; padding: 20px 0 0 0;">

                                                    <p
                                                        style="color: #000; margin: 0; padding-bottom: 5px; font-size: 12px; word-break: break-all; font-family: Arial, Helvetica, sans-serif;">
                                                        Sent by admin@encoreevents.live
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
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
