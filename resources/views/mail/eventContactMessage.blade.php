<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>New Event Contact Message</title>
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
            font-size: 1.2rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .email-body {
            padding: 30px 25px;
            color: #333333;
        }

        h2 {
            text-align: center;
            font-size: 1.4rem;
            margin-bottom: 10px;
            color: #164f84;
        }

        p {
            line-height: 1.6;
            font-size: 0.95rem;
            color: #555555;
            margin-bottom: 12px;
        }

        .contact-info {
            background-color: #f0f4f8;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }

        .contact-info p {
            margin: 5px 0;
        }

        .label {
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
            New Contact Message – {{ siteSetting()->site_title ?? 'BookingXpert' }}
        </div>

        <div class="email-body">
            <h2>Hello Admin,</h2>
            <p>You have received a new event contact message from your website:</p>

            <div class="contact-info">
                <p><span class="label">Name:</span> {{ $contact->name }}</p>
                <p><span class="label">Email:</span> {{ $contact->email ?? 'N/A' }}</p>
                <p><span class="label">Phone:</span> {{ $contact->phone }}</p>
                <p><span class="label">Date of Function:</span> {{ $contact->date_of_function ?? 'N/A' }}</p>
                <p><span class="label">Gathering Size:</span> {{ $contact->gathering_size ?? 'N/A' }}</p>
                <p><span class="label">Message:</span> {{ $contact->message ?? '-' }}</p>
            </div>

            <p>Please follow up with this contact as soon as possible.</p>
        </div>

        <div class="footer">
            <p>
                Need help? Contact us at
                <a href="mailto:{{ getSiteEmail() ?? 'support@BookingXpert.com' }}">
                    {{ getSiteEmail() ?? 'support@BookingXpert.com' }}
                </a>
            </p>
            <p>
                &copy; {{ date('Y') }}
                <strong>{{ siteSetting()->site_title ?? 'BookingXpert' }}</strong>. All rights
                reserved.
            </p>
            <p>
                <a href="https://www.bookingxpert.org" target="_blank">www.bookingxpert.org</a>
            </p>
        </div>
    </div>
</body>

</html>
