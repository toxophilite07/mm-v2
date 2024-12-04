<!DOCTYPE html>
<html>
<head>
    <title>Your OTP Code</title>
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
        .otp-code {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            text-align: center;
            margin: 20px 0;
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
            <h1>Menstrual Monitoring App v2</h1>
        </div>
        <div class="email-body">
            <p>Hello,</p>
            <p>Your OTP code is:</p>
            <div class="otp-code">{{ $otp }}</div>
            <p>This OTP will expire in <strong>3 minutes</strong>. Please do not share this code with anyone.</p>
            <p>Thank you,</p>
        </div>
        <div class="email-footer">
            <p>If you did not request this, please <a href="mailto:nelbanbetache@gmail.com">contact us immediately</a>.</p>
            <p>Thank you,<br>Menstrual Monitoring App v2</p>
        </div>
    </div>
</body>
</html>
