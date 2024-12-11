<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Confirmed</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .email-header {
            background-color: #007bff;
            color: #ffffff;
            text-align: center;
            padding: 20px;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .email-body {
            padding: 20px;
        }
        .email-body p {
            margin: 10px 0;
        }
        .email-body .btn {
            display: inline-block;
            margin: 15px 0;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }
        .email-body .btn:hover {
            background-color: #0056b3;
        }
        .email-footer {
            text-align: center;
            background-color: #f1f1f1;
            padding: 10px;
            font-size: 14px;
            color: #666;
        }
        .email-footer a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Account Confirmed</h1>
        </div>
        <div class="email-body">
            <p>Hello {{ $userName }},</p>
            <p>Your account has been successfully verified by the admin. You can now access all the features available to our system.</p>
            <p>Thank you for your patience!</p>
            <a href="{{ url('/login') }}" class="btn">Go to Login</a>
            <a href="https://www.mediafire.com/file/cj7tjxtebxglk0b/Menstrual_Monitoring_App_v2.apk/file" class="btn">Download the App</a>
        </div>
        <div class="email-footer">
            <p>If you did not request verification, please contact us immediately at <a href="mailto:nelbanbetache@gmail.com">support@menstrualmonitoringappv2.com</a>.</p>
            <p>Thank you,<br>Menstrual Monitoring App v2</p>
        </div>
    </div>
</body>
</html>
