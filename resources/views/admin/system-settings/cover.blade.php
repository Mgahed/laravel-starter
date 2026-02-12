<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    <meta charset="utf-8">
    <title>{{__('admin.settings.system-settings.Cover')}}</title>
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

		.tax-id, .vat-no {
			font-size: 16px;
			color: #555;
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
        <div class="tax-id">{{ $settings->tax_id }}</div>
        <div class="vat-no">{{ $settings->vat_no }}</div>
    </div>
	<div style="position: absolute; bottom: 20px; width: 100%; font-size: 12px; color: #888;">
{{--		{{__('admin.settings.system-settings.Generated on')}} {{ now()->format('Y-m-d H:i') }}--}}
		<footer style="margin-top: 4px; font-size: 10px; color: #aaa;">
			<div>{{$settings->website}}</div>
			<div>{{ $settings->mobile }}</div>
			<div>{{ $settings->full_address }}</div>
		</footer>
	</div>
</div>
</body>
</html>

