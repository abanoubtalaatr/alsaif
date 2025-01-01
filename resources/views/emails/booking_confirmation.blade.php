<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 20px;
        }
        .email-container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            width: 100px;
        }
        .details {
            margin-bottom: 20px;
        }
        .details p {
            margin: 5px 0;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h2>Booking Confirmation</h2>
            <p>Thank you for your booking!</p>
        </div>
        <div class="details">
            <p><strong>Date:</strong> {{ $booking['date'] }}</p>
            <p><strong>Time:</strong> {{ $booking['time'] }}</p>
            <p><strong>Name:</strong> {{ $booking['name'] }}</p>
            <p><strong>Email:</strong> {{ $booking['email'] }}</p>
            <p><strong>Phone:</strong> {{ $booking['phone'] }}</p>
            @if($booking['company_name'])
                <p><strong>Company:</strong> {{ $booking['company_name'] }}</p>
            @endif
            @if($booking['labor_sector'])
                <p><strong>Sector:</strong> {{ $booking['labor_sector'] }}</p>
            @endif
            <p>We look forward to seeing you!</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} </p>
        </div>
    </div>
</body>
</html>
