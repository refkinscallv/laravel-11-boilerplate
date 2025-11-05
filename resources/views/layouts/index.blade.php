@extends('templates.base')

@section('meta')
<link rel="icon" type="image/png" href="{{ asset('static/images/l11bp.png') }}">
<meta name="title" content="L11Bp - Laravel 11 Boilerplate (Enhanced Edition) by Refkinscallv">
<meta name="description" content="A modern Laravel 11 boilerplate with JWT, Mailer, Validator, Service base classes, and artisan generators for faster and cleaner backend development.">
<meta name="keywords" content="laravel 11, laravel boilerplate, laravel starter, laravel jwt, laravel mailer, laravel validator, laravel service, artisan generator">
<link rel="canonical" href="{{ url()->current() }}">

<!-- Open Graph (Facebook, LinkedIn, etc.) -->
<meta property="og:type" content="website">
<meta property="og:title" content="L11Bp - Laravel 11 Boilerplate (Enhanced Edition) by Refkinscallv">
<meta property="og:description" content="Enhanced Laravel 11 boilerplate with JWT, Mailer, and Artisan tools for developers.">
<meta property="og:image" content="{{ asset('static/images/l11bp.png') }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:site_name" content="Refkinscallv">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="L11Bp - Laravel 11 Boilerplate (Enhanced Edition) by Refkinscallv">
<meta name="twitter:description" content="Modern Laravel 11 boilerplate by Refkinscallv with extended utilities and command tools.">
<meta name="twitter:image" content="{{ asset('static/images/l11bp.png') }}">
<meta name="twitter:creator" content="@refkinscallv1">
@endsection

@push('head_additional')
<!-- Structured Data (JSON-LD Schema) -->
<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "SoftwareApplication",
        "name": "L11Bp - Laravel 11 Boilerplate (Enhanced Edition) by Refkinscallv",
        "alternateName": "Refkinscallv Laravel Boilerplate",
        "operatingSystem": "Cross-platform",
        "applicationCategory": "WebDevelopmentFramework",
        "softwareVersion": "11",
        "description": "A modern Laravel 11 boilerplate with extended utilities and command tools for faster and cleaner backend development. Includes JWT, Mailer, Validator, and artisan generators.",
        "url": "{{ url()->current() }}",
        "author": {
            "@type": "Person",
            "name": "Refkinscallv",
            "url": "https://github.com/refkinscallv"
        },
        "image": "{{ asset('static/images/l11bp.png') }}",
        "license": "https://opensource.org/licenses/MIT"
    }
</script>
@endpush

@section('content')
<button class="fixed top-5 right-5 btn btn-circle btn-ghost" id="btnThemeModeToggle">
    <i class="ri-moon-line" id="icon"></i>
</button>
<div class="w-full lg:w-[70%] w-screen h-screen m-auto">
    @yield('page')
</div>
@endsection
