<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Notification')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        /* Reset & Layout */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f5f7fa;
            color: #333;
            -webkit-font-smoothing: antialiased;
        }
        .wrapper {
            width: 100%;
            background-color: #f5f7fa;
            padding: 40px 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        /* Header */
        .header {
            background-color: #0d6efd;
            color: #fff;
            padding: 20px 30px;
            text-align: center;
            font-size: 22px;
            font-weight: bold;
        }

        /* Content */
        .content {
            padding: 30px;
            font-size: 16px;
            line-height: 1.6;
        }
        .content h1 {
            font-size: 22px;
            color: #111;
        }
        .content p {
            margin: 10px 0;
        }

        /* Button */
        .button {
            display: inline-block;
            background-color: #0d6efd;
            color: #fff !important;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-weight: bold;
            margin: 20px 0;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 20px 30px;
            font-size: 13px;
            color: #777;
            background-color: #f8f9fa;
        }

        @media (max-width: 600px) {
            .container { margin: 0 10px; }
            .content { padding: 20px; }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                {{ config('app.name', 'Laravel') }}
            </div>

            <div class="content">
                @yield('content')
            </div>

            <div class="footer">
                &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.
            </div>
        </div>
    </div>
</body>
</html>
