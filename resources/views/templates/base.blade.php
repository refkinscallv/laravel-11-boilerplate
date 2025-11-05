<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @if (!isset($page))
            {{ config('app.name') }}
        @elseif (empty($page->title))
            Unknown Page - {{ config('app.name') }}
        @else
            {{ $page->title }} - {{ config('app.name') }}
        @endif
    </title>

    @yield('meta')

    <link rel="stylesheet" href="{{ asset('static/css/packages/common.css?v='. md5(now() . uniqid())) }}">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    @stack('head_additional')

    <script>
        // URL helper
        const url = (prefix = 'base', path = '') => {
            const base = {
                base: `{{ url('') }}`,
                api: `{{ url('api') }}`,
                static: `{{ url('static') }}`,
                storage: `{{ url('storage') }}`
            }[prefix] || `{{ url('') }}`;
            return `${base}/${path}`
        }

        // Theme Mode
        (() => {
            document.documentElement.setAttribute('data-theme', localStorage.getItem('themeMode') || 'light')
        })()

        // Flash data
        const showFlash = @json($flash ?? [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)

        // Prevent back navigation cache
        history.pushState(null, '', location.href)
        window.addEventListener('popstate', () => history.pushState(null, '', location.href))
    </script>

</head>
<body class="min-h-screen bg-base-100 text-base-content">
    {{-- Loading Overlay --}}
    <div id="loading-overlay" class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center hidden" style="z-index: 2147483647 !important;">
        <div class="flex flex-col items-center gap-4 text-white">
            <span class="loading loading-spinner loading-lg"></span>
            <p class="text-lg">Loading...</p>
        </div>
    </div>

    {{-- Image Preview --}}
    <div id="image-preview-overlay" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 hidden items-center justify-center">
        <div class="max-w-4xl w-full p-4 relative">
            <button class="btn btn-sm btn-circle absolute top-2 right-2 z-10 btn-error" id="close-preview">
                <i class="ri-close-line"></i>
            </button>
            <img id="image-preview-target" src="" class="w-full h-auto max-h-[80vh] object-contain rounded" />
        </div>
    </div>

    {{-- Alert --}}
    <swal></swal>

    {{-- Modal --}}
    @yield('modal')

    {{-- Main Content --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    {{-- Scripts --}}
    <script type="module" src="{{ asset('static/js/packages/common.js?v=' . md5(filemtime(public_path('static/js/packages/common.js')))) }}"></script>
    @stack('body_additional')
</body>
</html>
