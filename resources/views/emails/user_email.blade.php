<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <title>Internal Tracker</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <style>
        body {
            background-color: #fff;
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #5f5e5e;
        }
        .container {
            width: 800px;
            margin: 0 auto;
            border: 1px solid #efefef;
            border-radius: 5px;
            overflow: hidden;
        }
        .header {
            background-color: #516672;
            padding: 10px 20px;
            text-align: center;
            color: #fff;
        }
        .header img {
            width: 50px;
            display: block;
            margin: 0 auto;
        }
        .header .title {
            margin-top: 10px;
        }
        .content {
            background-color: #f9f9f9;
            padding: 40px 50px 10px;
            border-bottom: 1px solid #e1e1e1;
            text-align: center;
        }
        .footer {
            text-align: center;
            padding: 20px 10px;
            font-size: 13px;
            color: #666;
        }
    </style>
</head>
<body>
    <center>
        <table class="container" cellspacing="0">
            <tr>
                <td class="header">
                    <img src="{{ asset('public/assets/images/logo-icon.png') }}" alt="Internal Tracker Logo" />
                    <div class="title">Internal Tracker</div>
                </td>
            </tr>
            <tr>
                <td class="content">
                    <p>Welcome, {{ ucfirst($first_name) }} {{ ucfirst($last_name) }}</p>
                </td>
                <td class="content">
                    <p>Your password is: <strong>{{ $password }}</strong></p>
                </td>
            </tr>
            <tr>
                <td class="footer">
                    Copyright &copy; {{ date('Y') }} Internal Tracker. All rights reserved.
                </td>
            </tr>
        </table>
    </center>
</body>
</html> -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Account Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
        }
        h1 {
            font-size: 24px;
            color: #2c3e50;
        }
        p {
            font-size: 16px;
            color: #555;
        }
        strong {
            color: #2c3e50;
        }
    </style>
</head>
<body>
    <h1>Welcome, {{ ucfirst($first_name) }} {{ ucfirst($last_name) }}</h1>
    <p>Your account has been created successfully. Below are your login details:</p>
    <p><strong>Email:</strong> {{ $email }}</p>
    <p><strong>Password:</strong> {{ $password }}</p>
</body>
</html>
