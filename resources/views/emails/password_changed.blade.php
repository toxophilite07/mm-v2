<!DOCTYPE html>
<html>
<head>
    <title>Password Changed Successfully</title>
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
            <h1>Password Changed Notification</h1>
        </div>
        <div class="email-body">
            <p>Hello,</p>
            <p>Your account password has been successfully changed. If you did not initiate this action, please <a href="mailto:support@example.com">contact us immediately</a>.</p>
        </div>
        <div class="email-footer">
            <p>Thank you,<br>{{ config('app.name') }}</p>
        </div>
    </div>
</body>
</html>
