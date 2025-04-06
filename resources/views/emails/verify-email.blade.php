<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email Address - Delivery</title>
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
            display: inline-block;
            background-color: #3498db;
            color: white !important;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 6px;
            font-weight: 600;
            margin: 15px 0;
            text-align: center;
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
            <h1>Verify Your Email Address</h1>
        </div>

        <!-- Greeting -->
        <p>Hello <span class="highlight">{{ $user['email'] }}</span>,</p>

        <!-- Message -->
        <p>Thank you for registering with <span class="highlight">Delivery</span>. To complete your registration, please
            verify your email address using the following code:</p>

        <!-- Verification Code -->
        <div class="code-container">
            <div class="code">{{ $code }}</div>
        </div>

        <!-- Instructions -->
        <p>This verification code will expire in 30 minutes. If you didn't request this code, you can safely ignore this
            email.</p>

        <!-- Footer -->
        <div class="footer">
            <p>If you did not create an account, no further action is required.</p>
            <p>&copy; 2025 Delivery. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
