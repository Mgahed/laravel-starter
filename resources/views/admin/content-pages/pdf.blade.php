<!DOCTYPE html>
<html lang="{{app()->getLocale()}}" dir="{{app()->getLocale() == 'ar' ? 'rtl' : 'ltr'}}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $title }}</title>
    <style>
        @page {
            margin: 0;
        }
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
            unicode-bidi: embed;
        }

        /* Cover Page Styles */
        .cover-page {
            width: 100%;
            height: 297mm;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            page-break-after: always;
            position: relative;
        }
        .logo {
            max-width: 280px;
            max-height: 280px;
            margin: 0 auto 24px;
        }
        .company-name {
            font-size: 32px;
            font-weight: bold;
            margin: 0 0 12px;
            color: #1a1a1a;
        }
        .document-title {
            font-size: 24px;
            font-weight: bold;
            margin: 40px 0 16px;
            color: #333;
            unicode-bidi: embed;
        }
        .approval-number {
            font-size: 18px;
            letter-spacing: 1px;
            color: #666;
            margin: 8px 0;
        }
        .cover-footer {
            position: absolute;
            bottom: 40px;
            width: 100%;
            font-size: 12px;
            color: #666;
            text-align: center;
        }
        .cover-footer div {
            margin: 4px 0;
        }
        .cover-footer .website {
            font-weight: bold;
            color: #0066cc;
        }

        /* Content Page Styles */
        .content-page {
            padding: 60px 80px;
        }
        .content-header {
            border-bottom: 3px solid #0066cc;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .content-title {
            font-size: 28px;
            font-weight: bold;
            margin: 0 0 10px;
            color: #1a1a1a;
            unicode-bidi: embed;
        }
        .content-meta {
            font-size: 12px;
            color: #666;
        }
        .content-meta span {
            margin-right: 20px;
        }
        .content-body {
            font-size: 14px;
            color: #333;
            line-height: 1.8;
            text-align: justify;
            unicode-bidi: embed;
        }
        .content-body p {
            margin: 16px 0;
        }
        .content-footer {
            margin-top: 60px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 11px;
            color: #999;
            text-align: center;
        }

        /* Version badge */
        .version-badge {
            display: inline-block;
            background: #f0f0f0;
            color: #666;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
        }

        /* RTL Support */
        html[dir="rtl"] body {
            text-align: right;
        }
        html[dir="rtl"] .content-body {
            text-align: justify;
        }

        /* RTL Helper */
        .rtl-text {
            direction: rtl;
            unicode-bidi: embed;
        }
    </style>
</head>
<body>
    <!-- Cover Page -->
    <div class="cover-page">
        <div>
            @if($logoFilePath && file_exists($logoFilePath))
                <img class="logo" src="file://{{ $logoFilePath }}" alt="{{ $settings->company_name }}">
            @elseif($logoUrl)
                <img class="logo" src="{{ $logoUrl }}" alt="{{ $settings->company_name }}">
            @endif

            <div class="company-name">{{ $settings->company_name }}</div>
            <div class="approval-number">{{ $settings->health_approval_number }}</div>

            <div class="document-title {{ app()->getLocale() === 'ar' ? 'rtl-text' : '' }}">{!! $title !!}</div>

            @if($page->version)
                <div style="margin-top: 20px;">
                    <span class="version-badge">{{__('admin.content-pages.Version')}} {{ $page->version }}</span>
                </div>
            @endif
        </div>

        <div class="cover-footer">
            @if($settings->website)
                <div class="website">{{ $settings->website }}</div>
            @endif
            @if($settings->mobile)
                <div>{{ $settings->mobile }}</div>
            @endif
            @if($settings->full_address)
                <div>{{ $settings->full_address }}</div>
            @endif
            @if($settings->tax_id)
                <div>{{__('admin.content-pages.Tax id')}}: {{ $settings->tax_id }}</div>
            @endif
            @if($settings->vat_no)
                <div>{{__('admin.content-pages.Vat no')}}: {{ $settings->vat_no }}</div>
            @endif
        </div>
    </div>

    <!-- Content Page -->
    <div class="content-page">
        <div class="content-header">
            <h1 class="content-title {{ app()->getLocale() === 'ar' ? 'rtl-text' : '' }}">{!! $title !!}</h1>
            <div class="content-meta">
                <span>{{__('admin.content-pages.Generated on')}}: {{ now()->format('Y-m-d H:i') }}</span>
                @if($page->version)
                    <span>{{__('admin.content-pages.Version')}}: {{ $page->version }}</span>
                @endif
                @if($page->published_at)
                    <span>{{__('admin.content-pages.Published at')}}: {{ $page->published_at->format('Y-m-d') }}</span>
                @endif
            </div>
        </div>

        <div class="content-body {{ app()->getLocale() === 'ar' ? 'rtl-text' : '' }}">
            {!! $content !!}
        </div>

        <div class="content-footer">
            <div>{{ $settings->company_name }} | {{ $settings->website }} | {{$settings->general_manager}}</div>
        </div>
    </div>
</body>
</html>

