<!DOCTYPE html>
<html lang="{{app()->getLocale()}}" dir="{{app()->getLocale() == 'ar' ? 'rtl' : 'ltr'}}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>{{ $title }} [cite: 4]</title>
	<style>
		/* 1. Global Page Setup */
		@page {
			/* Large margins to house the fixed header and footer on every page */
			margin: 110px 50px 80px 50px;
		}

		/*!* 2. Remove margins ONLY for the very first page (Cover) *!*/
		/*@page :first {*/
		/*	margin: 0;*/
		/*}*/

		@font-face {
			font-family: 'cairo';
			src: url('file://{{ public_path('assets/Cairo-Regular.ttf') }}') format('truetype');
			font-weight: normal;
			font-style: normal;
		}

		body {
			font-family: 'cairo', 'DejaVu Sans', sans-serif;
			margin: 0;
			padding: 0;
			line-height: 1.6;
		}

		/* 3. Fixed Header - This will now appear on Page 2, 3, 4... */
		header {
			position: fixed;
			top: -85px;
			left: 0;
			right: 0;
			height: 60px;
			border-bottom: 1px solid #eee;
			/* Hide on page 1 by using a white background or z-index if needed,
			   but @page :first margin: 0 usually handles this */
		}

		.header-table {
			width: 100%;
			font-size: 12px;
			color: #666;
		}

		/* 4. Fixed Footer - This will now appear on Page 2, 3, 4... */
		footer {
			position: fixed;
			bottom: -60px;
			left: 0;
			right: 0;
			height: 50px;
			border-top: 1px solid #ddd;
			font-size: 11px;
			color: #999;
			text-align: center;
			padding-top: 10px;
		}

		/* 5. Cover Page Styling */
		.cover-page {
			width: 100%;
			height: 100%;
			page-break-after: always;
			text-align: center;
			/* Ensures cover content doesn't collide with fixed elements */
			background-color: white;
			z-index: 10;
		}

		/* 6. Content Area */
		.content-wrapper {
			width: 100%;
		}

		.rtl-text { direction: rtl; unicode-bidi: embed; }
	</style>
</head>
<body>

<header>
	<table class="header-table">
		<tr>
			<td align="{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
				<strong>{{ $settings->company_name }}</strong>
			</td>
			<td align="{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}">
				{{ $title }}
			</td>
		</tr>
	</table>
</header>

<footer>
	<div>
		{{ $settings->company_name }} | {{ $settings->website }} | {{ $settings->general_manager }}
	</div>
</footer>

<div class="cover-page">
	<div style="padding-top: 120px;">
		@if($logoFilePath && file_exists($logoFilePath))
			<img src="file://{{ $logoFilePath }}" style="max-width: 250px;" alt="">
		@endif
		<h1 style="font-size: 32px; margin-top: 40px;">{{ $settings->company_name }}</h1>
		<div style="font-size: 18px; color: #666;">{{ $settings->health_approval_number }}</div>

		<div style="font-size: 24px; font-weight: bold; margin-top: 60px;" class="{{ app()->getLocale() === 'ar' ? 'rtl-text' : '' }}">
			{!! $title !!}
		</div>

		@if($page->version)
			<div style="margin-top: 20px; font-weight: bold; color: #888;">
				Version {{ $page->version }}
			</div>
		@endif
	</div>

	<div style="position: absolute; bottom: 80px; width: 100%; font-size: 13px;">
		<div>{{ $settings->full_address }}</div>
		<div style="color: #0066cc;">{{ $settings->website }}</div>
	</div>
</div>

<div class="content-wrapper">
	<div class="content-header">
		<h2 class="{{ app()->getLocale() === 'ar' ? 'rtl-text' : '' }}">{!! $title !!}</h2>
	</div>

	<div class="content-body {{ app()->getLocale() === 'ar' ? 'rtl-text' : '' }}">
		{!! $content !!}
	</div>
</div>

</body>
</html>
