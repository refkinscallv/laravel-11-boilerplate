<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Basic Meta -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Primary SEO Meta -->
    <title>L11Bp - Laravel 11 Boilerplate (Enhanced Edition) by Refkinscallv</title>
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

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('static/images/l11bp.png') }}">

    <!-- CSS & JS -->
    <link rel="stylesheet" href="{{ asset('static/css/packages/common.css?v='. md5(now() . uniqid())) }}">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

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

    <!-- Theme + Helper -->
    <script>
            // URL helper
            const url = (prefix = 'base', path = '') => {
                let base;
                switch (prefix) {
                    case 'api': base = `{{ url('api') }}`; break;
                    case 'static': base = `{{ url('static') }}`; break;
                    case 'storage': base = `{{ url('storage') }}`; break;
                    default: base = `{{ url('') }}`;
                }
                return `${base}/${path}`;
            };

            // Set theme mode
            (() => {
                document.documentElement.setAttribute('data-theme', localStorage.getItem('themeMode') || 'light')
            })();

            // Get flash data
            const showFlash = @json($flash ?? [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    </script>

</head>
<body>

    {{-- Image Preview Container --}}
    <div id="image-preview-overlay" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 hidden items-center justify-center">
        <div class="max-w-4xl w-full p-4 relative">
            <button class="btn btn-sm btn-circle absolute top-2 right-2 z-10" id="close-preview"><i class="ri-close-line"></i></button>
            <img id="image-preview-target" src="" class="w-full h-auto max-h-[80vh] object-contain rounded" />
        </div>
    </div>

    {{-- Loadin container --}}
    <div id="loading-overlay" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center hidden">
        <div class="flex flex-col items-center gap-4 text-base-100">
            <span class="loading loading-spinner loading-lg"></span>
            <p class="text-lg">Loading...</p>
        </div>
    </div>

    {{-- Alert --}}
    <swal></swal>

    {{-- Theme Toggle --}}
    <button class="fixed top-5 right-5 btn btn-circle btn-ghost" id="btnThemeModeToggle">
        <i class="ri-moon-line" id="icon"></i>
    </button>

    @if(isset($layout))
        @include($layout)
    @endif

    <script type="module" src="{{ asset('static/js/packages/common.js?v='. md5(now() . uniqid())) }}"></script>

</body>
</html>
