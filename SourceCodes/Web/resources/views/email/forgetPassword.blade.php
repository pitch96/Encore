<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900&display=swap" rel="stylesheet">
    <title>Reset Password Link</title>
</head>

<body style="margin: 0;">
    <table cellpadding="0" cellspacing="0" style="width:100%">
        <tr>
            <td align="center">
                <table cellpadding="0" cellspacing="0" width="500">
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
                                                        You are receiving this email because we received a password
                                                        reset request for your account.
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 33%;"></td>
                                                <td
                                                    style="background: #cf2c2f; padding: 10px 12px; text-align: center; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px;">
                                                    <a href="{{ route('reset.password.get', $token) }}"
                                                        style="color: #fff; text-decoration: none; font-family: Arial, Helvetica, sans-serif;">Reset
                                                        Password</a>
                                                </td>
                                                <td style="width: 33%;"></td>
                                            </tr>
                                            {{-- <tr>
                                                <td colspan="3" style="background: #fff; padding: 40px 0 20px 0;">
                                                    <p
                                                        style="color: #000; margin: 0; font-size: 14px; font-family: Arial, Helvetica, sans-serif;">
                                                        This password reset link will expire in 60 minutes.
                                                    </p>
                                                </td>
                                            </tr> --}}
                                            <tr>
                                                <td colspan="3" style="background: #fff;">
                                                    <p
                                                        style="color: #000; margin: 0; font-size: 14px; font-family: Arial, Helvetica, sans-serif;">
                                                        If you did not request a password reset, no further action is
                                                        required.
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="background: #fff; padding: 30px 0 20px 0;">
                                                    <p
                                                        style="color: #000; margin: 0; font-size: 14px; font-family: Arial, Helvetica, sans-serif;">
                                                        Regards,
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="background: #fff;">
                                                    <p
                                                        style="color: #000; margin: 0; font-size: 14px; font-family: Arial, Helvetica, sans-serif;">
                                                        Team EncoreEvents
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="background: #fff; padding: 30px 0 20px 0;">
                                                    <p
                                                        style="color: #000; margin: 0; font-size: 14px; font-family: Arial, Helvetica, sans-serif;">
                                                        If you’re having trouble clicking the "Reset Password" button,
                                                        copy and paste the URL below into your web browser:
                                                    </p>
                                                    <p
                                                        style="color: #000; margin: 0; font-size: 14px; word-break: break-all; font-family: Arial, Helvetica, sans-serif;">
                                                        <a href="{{ route('reset.password.get', $token) }}"
                                                            target="_blank"
                                                            rel="noopener noreferrer">{{ route('reset.password.get', $token) }}</a>
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3"
                                                    style="background: #fff; padding: 30px 0 0 0; border-top: 1px solid #ddd;">

                                                    <p
                                                        style="color: #000; margin: 0; padding-bottom: 5px; font-size: 12px; word-break: break-all; font-family: Arial, Helvetica, sans-serif;">
                                                        Sent by admin@encoreevents.live
                                                    </p>
                                                    <a target="_blank" href="{{ url('privacypolicy') }}"
                                                        style="text-decoration: none; color: #2f9fe4;">Privacy
                                                        Policy
                                                    </a>
                                                    and
                                                    <a target="_blank" href="{{ url('termsconditions') }}"
                                                        style="text-decoration: none; color: #2f9fe4;">Terms &
                                                        Conditions
                                                    </a>
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
