<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset - Delivery</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f9ff;
            margin: 0;
            padding: 0;
            color: #333333;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border-top: 5px solid #3498db;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .logo {
            color: #3498db;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        h1 {
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
            color: #555555;
            margin-bottom: 20px;
        }

        .code-container {
            background-color: #f0f7ff;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            margin: 25px 0;
            border: 1px dashed #3498db;
        }

        .code {
            font-size: 28px;
            font-weight: bold;
            letter-spacing: 2px;
            color: #3498db;
            font-family: 'Courier New', monospace;
        }

        .button {
            display: block;
            width: fit-content;
            margin: 25px auto;
            background-color: #3498db;
            color: white !important;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 6px;
            font-weight: 600;
            text-align: center;
        }

        .note {
            font-size: 14px;
            color: #777777;
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            background-color: #fff8e6;
            border-left: 3px solid #ffc107;
            border-radius: 0 4px 4px 0;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #888888;
            border-top: 1px solid #eeeeee;
            padding-top: 20px;
        }

        .highlight {
            color: #3498db;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header with Logo -->
        <div class="header">
            <div class="logo">Delivery</div>
            <h1>Password Reset Request</h1>
        </div>

        <!-- Greeting -->
        <p>Hello,</p>

        <!-- Message -->
        <p>We received a request to reset your password for your <span class="highlight">Delivery</span> account. Please
            use the following verification code to proceed:</p>

        <!-- Verification Code -->
        <div class="code-container">
            <div class="code">{{ $code }}</div>
        </div>

        <!-- Note -->
        <p class="note"><strong>Note:</strong> This verification code will expire in 1 hour. If you didn't request a
            password reset, please ignore this email.</p>

        <!-- Call to Action -->
        <a href="#" class="button">Reset Password</a>

        <!-- Footer -->
        <div class="footer">
            <p>If you have any questions, feel free to contact our support team.</p>
            <p>&copy; 2025 Delivery. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
