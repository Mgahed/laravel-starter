<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>HACCP Cover</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .page {
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .logo {
            max-width: 280px;
            max-height: 280px;
            margin: 0 auto 24px;
        }
        .company-name {
            font-size: 28px;
            font-weight: bold;
            margin: 0 0 8px;
        }
        .approval-number {
            font-size: 18px;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>
<div class="page">
    <div>
        @if($logoUrl)
            <img class="logo" src="{{ $logoUrl }}" alt="Company Logo">
        @endif
        <div class="company-name">{{ $settings->company_name }}</div>
        <div class="approval-number">{{ $settings->health_approval_number }}</div>
    </div>
</div>
</body>
</html>

