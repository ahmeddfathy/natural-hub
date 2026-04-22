<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Natural Hub - صالون تجميل فاخر متخصص في العناية بالشعر والبشرة والرموش. احجزي جلستك الآن واستمتعي بتجربة عناية استثنائية.')">
    <title>@yield('title', 'Natural Hub | صالون العناية الفاخرة بالشعر والبشرة والرموش')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&family=Noto+Kufi+Arabic:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @stack('styles')
</head>

<body class="@yield('body_class')">

    @include('partials.navbar')

    @yield('content')

    @include('partials.footer')

    @stack('scripts')

</body>

</html>
