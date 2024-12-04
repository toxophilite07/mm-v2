<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Expired</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        /* Global reset and utility classes */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 0 20px;
        }

        /* Container for error message */
        .error-container {
            background: #fff;
            border-radius: 12px;
            padding: 40px 30px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        h1 {
            font-size: 30px;
            color: #e74c3c;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            color: #555;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        /* Back button styling */
        .back-button {
            padding: 12px 25px;
            background-color: #3498db;
            color: #fff;
            font-size: 16px;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .back-button:hover {
            background-color: #2980b9;
            transform: translateY(-3px);
        }

        .back-button:focus {
            outline: none;
        }

        /* Responsive design for smaller screens */
        @media (max-width: 600px) {
            h1 {
                font-size: 36px;
            }

            p {
                font-size: 16px;
                padding: 0 20px; /* Add some padding for mobile text */
            }

            .back-button {
                padding: 10px 20px;
                font-size: 14px;
            }

            /* Adjust container padding for mobile */
            .error-container {
                padding: 30px 20px;
            }
        }

        /* Mobile-friendly for very small devices (if needed) */
        @media (max-width: 400px) {
            h1 {
                font-size: 28px;
            }

            p {
                font-size: 14px;
            }

            .back-button {
                padding: 8px 16px;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>

<div class="error-container">
    <h1>419 - Page Expired</h1>
    <p>Please go back to the previous page and try again.</p>
    <a href="javascript:history.back()" class="back-button">Go Home</a>
</div>

</body>
</html>
