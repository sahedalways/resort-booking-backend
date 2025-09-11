<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['title'] }}</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.6;
        }

        /* Container */
        .email-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Header */
        .email-header {
            text-align: center;
            background-color: #143049;
            color: #fff;
            padding: 20px 0;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }

        .email-header .company-name {
            font-size: 18px;
            margin-top: 5px;
        }

        /* Content */
        .email-body {
            padding: 20px;
        }

        .email-body p {
            font-size: 16px;
            margin: 10px 0;
        }

        .email-body .token {
            font-size: 20px;
            font-weight: bold;
            color: #143049;
            text-align: center;
            margin: 20px 0;
            padding: 10px;
            background: #fff8e1;
            border: 1px solid 143049;
            border-radius: 4px;
        }

        /* Footer */
        .email-footer {
            text-align: center;
            font-size: 14px;
            color: #777;
            margin-top: 20px;
        }

        .email-footer .company-name {
            color: 143049;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>{{ $data['title'] }}</h1>
            <div class="company-name">{{ siteSetting()->site_title }} LTD.</div>
        </div>

        <!-- Body -->
        <div class="email-body">
            <p>{{ $data['body'] }}</p>

            <p>Pin Code:</p>
            <div class="token">{{ $data['otp'] }}</div>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p>If you didn’t request this, please ignore this email.</p>
            <p>Powered by <span class="company-name">{{ siteSetting()->site_title }} LTD.</span>.</p>
        </div>
    </div>
</body>

</html>
