<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $data['title'] ?? 'New Booking Received' }}</title>
    <style>
        body {
            font-family: "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 40px 0;
        }

        .email-wrapper {
            max-width: 480px;
            background-color: #ffffff;
            margin: 0 auto;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .email-header {
            background: linear-gradient(90deg, #164f84 0%, #0083bb 100%);
            color: #ffffff;
            text-align: center;
            padding: 20px;
            font-size: 1.1rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .email-body {
            padding: 30px 25px;
            color: #333333;
        }

        h2 {
            text-align: center;
            font-size: 1.5rem;
            margin-bottom: 8px;
        }

        p {
            line-height: 1.6;
            font-size: 0.95rem;
            color: #555555;
            margin-bottom: 14px;
        }

        .booking-info {
            background-color: #f0f4f8;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
        }

        .info-row {
            margin-bottom: 10px;
        }

        .info-label {
            font-weight: 600;
            color: #164f84;
        }

        .footer {
            background-color: #f9fafc;
            text-align: center;
            padding: 20px;
            font-size: 0.8rem;
            color: #777777;
            border-top: 1px solid #eaeaea;
        }

        .footer a {
            color: #164f84;
            text-decoration: none;
        }

        .footer strong {
            color: #164f84;
        }
    </style>
</head>

<body>
    <div class="email-wrapper">
        <div class="email-header">
            New Booking Notification – {{ siteSetting()->site_title ?? 'BookingXpart' }}
        </div>

        <div class="email-body">
            <h2>Hello Admin,</h2>
            <p>A new booking has been made on <strong>{{ siteSetting()->site_title ?? 'BookingXpart' }}</strong>.</p>

            <div class="booking-info">
                <div class="info-row"><span class="info-label">User:</span> {{ $data['user']->f_name }}
                    {{ $data['user']->l_name }} ({{ $data['user']->email }})
                </div>
                <div class="info-row"><span class="info-label">Resort:</span> {{ $data['resort']->name }}</div>
                <div class="info-row"><span class="info-label">Room:</span> {{ $data['room']->name }}</div>
                <div class="info-row"><span class="info-label">Booking Dates:</span> {{ $data['booking']->start_date }}
                    to
                    {{ $data['booking']->end_date }}
                </div>
                <div class="info-row"><span class="info-label">Guests:</span> {{ $data['booking']->adult }} Adult(s),
                    {{ $data['booking']->child }} Child(ren)
                </div>
                <div class="info-row"><span class="info-label">Amount:</span>
                    ৳{{ number_format($data['booking']->amount, 2) }}
                </div>
                <div class="info-row"><span class="info-label">Additional Comment:</span>
                    {{ $data['booking']->additional_comment ?? 'N/A' }}
                </div>
            </div>

            <p>Please check the booking details in the admin panel for further actions.</p>
        </div>

        <div class="footer">
            <p>
                &copy; {{ date('Y') }} <strong>{{ siteSetting()->site_title ?? 'BookingXpart' }}</strong>. All
                rights reserved.
            </p>
            <p>
                <a href="https://www.bookingxpart.org" target="_blank">www.bookingxpart.org</a>
            </p>
        </div>
    </div>
</body>

</html>
