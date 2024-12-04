<!-- resources/views/emails/female_verified.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Confirmed</title>
    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            text-align: center;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #4CAF50;
        }

        p {
            font-size: 16px;
            color: #555;
        }

        /* Button styling */
        .btn {
            background-color: #4CAF50; /* Green */
            color: white;
            padding: 14px 20px;
            border: none;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 20px;
        }

        .btn:hover {
            background-color: #45a049; /* Darker green */
        }

        /* Footer styling */
        .footer {
            margin-top: 40px;
            font-size: 14px;
            color: #777;
        }

        .footer a {
            color: #4CAF50;
            text-decoration: none;
        }

    </style>
</head>
<body>

    <div class="container">
        <h2>Hello {{ $userName  }},</h2>
        <p>Your account has been successfully verified by the admin. You can now access all the features available to our system.</p>
        <p>Thank you for your patience!</p>

        <!-- Optional button or link -->
        <p>
            <a href="{{ url('/login') }}" class="btn">Go to Login</a>
        </p>

        <div class="footer">
            <p>If you did not request verification, please contact us immediately at <a href="mailto:nelbanbetache@gmail.com">support@menstrualmonitoringappv2.com</a>.</p>
            <p>Thank you,<br>Menstrual Monitoring App v2</p>
        </div>
    </div>

</body>
</html>
