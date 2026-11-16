{{-- Standalone error page: no app layout / database-heavy partials, so it can always render. --}}
@php
    try {
        $logoText = \App\Models\PortfolioSetting::get('site_logo_text', 'Portfolio');
    } catch (\Throwable $e) {
        $logoText = 'Portfolio';
    }
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('code') · @yield('title')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 24px;
            font-family: "Poppins", system-ui, sans-serif;
            color: #fff;
            background:
                radial-gradient(700px 400px at 80% 0%, rgba(124, 58, 237, 0.35), transparent 70%),
                radial-gradient(600px 400px at 0% 100%, rgba(59, 130, 246, 0.25), transparent 70%),
                #070a22;
        }
        .box { text-align: center; max-width: 520px; }
        .logo { font-weight: 600; font-size: 20px; margin-bottom: 40px; display: inline-block; color: #fff; text-decoration: none; }
        .logo b { color: #a855f7; font-weight: 800; letter-spacing: -2px; margin-right: 6px; }
        .code {
            font-size: clamp(90px, 20vw, 150px);
            font-weight: 800;
            line-height: 1;
            letter-spacing: -4px;
            background: linear-gradient(90deg, #b05cf8, #6271ff);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            filter: drop-shadow(0 0 30px rgba(168, 85, 247, 0.45));
        }
        h1 { font-size: 24px; margin: 14px 0 8px; }
        p { color: #b3b6d4; margin: 0 0 30px; line-height: 1.6; }
        .btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 13px 28px; border-radius: 999px;
            color: #fff; text-decoration: none; font-weight: 600; font-size: 14px;
            background: linear-gradient(90deg, #9d4edd, #7c3aed 55%, #6d5df6);
            box-shadow: 0 10px 28px -8px rgba(168, 85, 247, 0.8);
            transition: transform 0.2s;
        }
        .btn:hover { transform: translateY(-2px); }
        .btn.ghost { background: transparent; border: 1px solid rgba(160, 150, 230, 0.45); box-shadow: none; margin-left: 10px; }
    </style>
</head>
<body>
    <div class="box">
        <a class="logo" href="{{ url('/') }}"><b>&lt;/&gt;</b>{{ $logoText }}</a>
        <div class="code">@yield('code')</div>
        <h1>@yield('title')</h1>
        <p>@yield('message')</p>
        <a class="btn" href="{{ url('/') }}">← Back to Home</a>
        <a class="btn ghost" href="javascript:history.back()">Go Back</a>
    </div>
</body>
</html>
