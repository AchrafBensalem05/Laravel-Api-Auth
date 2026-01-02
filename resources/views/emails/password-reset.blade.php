<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Password Reset</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background-color: #ffffff;
            padding: 30px;
            border: 1px solid #e9ecef;
        }
        .button {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-radius: 0 0 8px 8px;
            font-size: 14px;
            color: #6c757d;
        }
        .token-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
            font-family: monospace;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Password Reset Request</h1>
    </div>
    
    <div class="content">
        <p>Hello {{ $user->name }},</p>
        
        <p>You are receiving this email because we received a password reset request for your account.</p>
        
        <p>To reset your password, use the following token with your password reset endpoint:</p>
        
        <div class="token-info">
            <strong>Reset Token:</strong><br>
            {{ $token }}
        </div>
        
        <p><strong>API Endpoint:</strong> POST /api/auth/reset-password</p>
        
        <p><strong>Required Fields:</strong></p>
        <ul>
            <li>email: {{ $user->email }}</li>
            <li>token: {{ $token }}</li>
            <li>password: your_new_password</li>
            <li>password_confirmation: your_new_password</li>
        </ul>
        
        @if(isset($resetUrl))
        <p>If you have a frontend application, you can also use this link:</p>
        <a href="{{ $resetUrl }}" class="button">Reset Password</a>
        @endif
        
        <p>This password reset token will expire in 24 hours.</p>
        
        <p>If you did not request a password reset, no further action is required.</p>
        
        <p>Best regards,<br>{{ config('app.name') }} Team</p>
    </div>
    
    <div class="footer">
        <p>If you're having trouble with the reset process, please contact our support team.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html>