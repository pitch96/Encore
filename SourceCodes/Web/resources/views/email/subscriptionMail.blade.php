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
                                    <td>
                                        <table cellpadding="0" cellspacing="0" style="width:100%">

                                            <tr>
                                                <td colspan="3" style="background: #fff; padding: 0 0 30px 0;">
                                                    <p
                                                        style="color: #000; margin: 0; font-size: 14px; font-family: Arial, Helvetica, sans-serif;">
                                                        Thank you for subscribing to Encore Events, INC. Please be on
                                                        the lookout for upcoming events in and around your
                                                        city. Don’t forget to add our email subscribe@encoreevents.live
                                                        to your contacts to stay in the know.
                                                        If you wished to unsubscribe please 
                                                        <a href="{{ url('unsubscribe/' . $email) }}">click here.</a>
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
