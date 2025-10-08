<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['title'] ?? 'Verify Your Email Address' }}</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .email-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 400px;
            padding: 20px;
            text-align: left;
        }

        .header {
            background-color: #007bff;
            color: #fff;
            padding: 15px;
            border-radius: 8px 8px 0 0;
            font-size: 1em;
            margin-bottom: 20px;
            text-align: center;
        }

        h2 {
            color: #333;
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 1.5em;
            text-align: center;
        }

        p {
            color: #555;
            line-height: 1.5;
            margin-bottom: 10px;
            font-size: 0.9em;
        }

        .verification-code-container {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 15px;
            text-align: center;
        }

        .verification-code-label {
            color: #555;
            font-size: 0.9em;
            margin-bottom: 5px;
        }

        .otp-code {
            font-size: 1.8em;
            font-weight: bold;
            color: #495057;
        }

        .footer {
            color: #777;
            font-size: 0.7em;
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            This is a System Generated Email
        </div>
        <h2>Hello ({{ $data['username'] ?? 'User' }})</h2>
        <p>Thanks for joining us.</p>
        <p>{{ $data['body'] ?? 'Please use the below code to verify your email address.' }}</p>
        <div class="verification-code-container">
            <p class="verification-code-label">Your email verification code is:</p>
            <div class="otp-code">
                <strong>{{ $data['otp'] ?? '******' }}</strong>
            </div>
        </div>
        <div class="footer">
            <p>If you have any questions regarding this transaction or need further assistance, please don’t hesitate to
                reach out to our support team.</p>
            <p>Thank you for using <strong>{{ siteSetting()->site_title ?? 'BookingXpart' }}</strong>.</p>
            <p>Warm regards,<br>
                The {{ siteSetting()->site_title ?? 'BookingXpart' }} Team<br>
                <a href="mailto:support@bookingxpart.com">support@bookingxpart.com</a><br>
                <a href="https://www.bookingxpart.com" target="_blank">www.bookingxpart.com</a>
            </p>
        </div>
    </div>
</body>

</html>
