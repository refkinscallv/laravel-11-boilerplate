<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="robots" content="noindex, nofollow, noarchive, nosnippet, noimageindex, nocache, notranslate">
    <meta name="googlebot" content="noindex, nofollow">
    <meta name="bingbot" content="noindex, nofollow">
    <meta name="slurp" content="noindex, nofollow">

    <title>{{ config('app.name') }}</title>

    <link rel="stylesheet" href="{{ asset('static/css/packages/common.css?v='. md5(now() . uniqid())) }}">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <script>
        // url helper
        const url = (prefix = 'base', path = '') => {
            let url;
            switch (true) {
                case (prefix === 'base') : url = `{{ url('') }}`; break;
                case (prefix === 'api') : url = `{{ url('api') }}`; break;
                case (prefix === 'static') : url = `{{ url('static') }}`; break;
                case (prefix === 'storage') : url = `{{ url('storage') }}`; break;
            }

            return `${url}/${path}`
        }

        // set theme mode
        (() => {
            document.documentElement.setAttribute('data-theme', localStorage.getItem('themeMode') || 'light')
        })()

        // get all flash data
        const showFlash = @json($flash ?? [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)

        // clear cache
        history.pushState(null, '', location.href)
        window.addEventListener('popstate', function () {
            history.pushState(null, '', location.href)
        })
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
