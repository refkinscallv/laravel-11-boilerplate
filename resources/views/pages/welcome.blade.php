@extends('layouts.index')

@section('page')
    <main class="min-h-screen flex flex-col items-center justify-center text-center px-6 py-10">
        <img data-preview="{{ asset('static/images/l11bp.png') }}" src="{{ asset('static/images/l11bp.png') }}" alt="Laravel 11 Boilerplate Logo" title="Laravel 11 Boilerplate" class="cursor-pointer h-40 object-contain opacity-90 hover:opacity-100 transition" />

        <h1 class="text-4xl md:text-6xl font-bold my-[20px]">Laravel 11 Boilerplate</h1>

        <p class="max-w-2xl my-[20px] text-gray-600">
            A modern Laravel 11 boilerplate with extended utilities and command tools for faster and cleaner backend development.
            Includes built-in JWT, Mailer, Validator, Service base classes, and artisan generators.
        </p>

        <div class="flex flex-wrap justify-center items-center gap-4 my-[20px]">
            <a href="https://github.com/refkinscallv/laravel-11-boilerplate" target="_blank" rel="noopener noreferrer" class="btn btn-primary rounded-full">
                View Repository
            </a>
        </div>

        <!-- Tech Stack Logos -->
        <div class="flex flex-wrap justify-center items-center gap-4">
            @foreach ([
                ['l11bp_laravel.svg', 'Laravel'],
                ['l11bp_php-jwt.png', 'Firebase/php-jwt'],
                ['l11bp_phpmailer.png', 'PHPMailer'],
                ['l11bp_tailwindcss.png', 'Tailwind CSS'],
                ['l11bp_daisyui.png', 'DaisyUI'],
                ['l11bp_jquery.png', 'jQuery'],
                ['l11bp_axios.png', 'Axios'],
                ['l11bp_remixicon.webp', 'Remix Icon'],
                ['l11bp_yajra.svg', 'Yajra BOx'],
                ['l11bp.png', 'DataTables'],
                ['l11bp.png', 'Tom Select'],
            ] as [$file, $name])
            <div class="w-20 h-12 flex items-center justify-center overflow-hidden group">
                <img data-preview="{{ asset('static/images/' . $file) }}" src="{{ asset('static/images/' . $file) }}" alt="{{ $name }}" title="{{ $name }}" class="cursor-pointer max-h-full object-contain filter grayscale group-hover:grayscale-0 transition duration-500" />
            </div>
            @endforeach
        </div>
    </main>

    <!-- Summary Section -->
    <section class="max-w-5xl mx-auto text-left px-6 py-12 space-y-12">

        <article>
            <h2 class="text-2xl font-bold mb-4">Features</h2>

            <h3 class="font-semibold mb-2">Core Enhancements</h3>
            <ul class="list-disc pl-6 space-y-1">
                <li><b>Laravel 11 base</b> with extended architecture.</li>
                <li><b>Additional libraries:</b>
                    <ul class="list-inside pl-4 space-y-1 text-sm">
                        <li>
                            <a href="https://github.com/firebase/php-jwt"
                                target="_blank"
                                class="text-blue-600 hover:underline font-semibold">firebase/php-jwt</a>
                            — Secure JWT handling.
                        </li>
                        <li>
                            <a href="https://github.com/PHPMailer/PHPMailer"
                                target="_blank"
                                class="text-blue-600 hover:underline font-semibold">phpmailer/phpmailer</a>
                            — Direct email sending via SMTP.
                        </li>
                    </ul>
                </li>
            </ul>
        </article>

        <article>
            <h2 class="text-2xl font-bold mb-3">Frontend Packages</h2>

            <h3 class="font-semibold mb-2">CSS & UI</h3>
            <div class="overflow-x-auto">
                <table class="table table-zebra text-sm">
                    <thead>
                        <tr>
                            <th>Library</th>
                            <th>CDN</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><a href="https://tailwindcss.com/" target="_blank"
                                    class="text-blue-600 hover:underline font-semibold">Tailwind CSS</a></td>
                            <td>@tailwindcss/browser@4</td>
                            <td>Utility-first CSS framework</td>
                        </tr>
                        <tr>
                            <td><a href="https://daisyui.com/" target="_blank"
                                    class="text-blue-600 hover:underline font-semibold">DaisyUI</a></td>
                            <td>@5</td>
                            <td>Prebuilt UI components for Tailwind</td>
                        </tr>
                        <tr>
                            <td><a href="https://remixicon.com/" target="_blank"
                                    class="text-blue-600 hover:underline font-semibold">Remix Icon</a></td>
                            <td>@4.5.0</td>
                            <td>Modern icon pack</td>
                        </tr>
                        <tr>
                            <td><a href="https://tom-select.js.org/" target="_blank"
                                    class="text-blue-600 hover:underline font-semibold">Tom Select</a></td>
                            <td>@2.4.3</td>
                            <td>Dropdown and autocomplete control</td>
                        </tr>
                        <tr>
                            <td><a href="https://datatables.net/" target="_blank"
                                    class="text-blue-600 hover:underline font-semibold">DataTables</a></td>
                            <td>dt-2.3.4</td>
                            <td>Interactive tables with export options</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </article>

        <article>
            <h3 class="font-semibold mb-2">JavaScript & Tools</h3>
            <div class="overflow-x-auto">
                <table class="table table-zebra text-sm">
                    <thead>
                        <tr>
                            <th>Library</th>
                            <th>CDN</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><a href="https://jquery.com/" target="_blank"
                                    class="text-blue-600 hover:underline font-semibold">jQuery</a></td>
                            <td>3.7.1</td>
                            <td>DOM manipulation & event handling</td>
                        </tr>
                        <tr>
                            <td><a href="https://axios-http.com/docs/intro" target="_blank"
                                    class="text-blue-600 hover:underline font-semibold">Axios</a></td>
                            <td>Latest</td>
                            <td>HTTP client for API calls</td>
                        </tr>
                        <tr>
                            <td><a href="https://tom-select.js.org" target="_blank"
                                    class="text-blue-600 hover:underline font-semibold">Tom Select JS</a></td>
                            <td>@2.4.3</td>
                            <td>Select dropdown controller</td>
                        </tr>
                        <tr>
                            <td><a href="https://pdfmake.github.io/docs/" target="_blank"
                                    class="text-blue-600 hover:underline font-semibold">PDFMake</a></td>
                            <td>0.2.7</td>
                            <td>Client-side PDF generation</td>
                        </tr>
                        <tr>
                            <td><a href="https://datatables.net/" target="_blank"
                                    class="text-blue-600 hover:underline font-semibold">DataTables JS Bundle</a></td>
                            <td>Matched CSS version</td>
                            <td>Responsive and export support</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </article>
    </section>

    <!-- Installation & Example Section -->
    <section class="max-w-5xl mx-auto text-left px-6 py-10 space-y-8">
        <div>
            <h3 class="text-xl font-semibold mb-3">Installation</h3>
            <div class="mockup-code">
                <pre data-prefix="1"><code>git clone https://github.com/refkinscallv/laravel-11-boilerplate.git ./</code></pre>
                <pre data-prefix="2"><code>composer install --no-cache</code></pre>
                <pre data-prefix="3"><code>cp .env.example .env</code></pre>
                <pre data-prefix="4"><code>php artisan key:generate</code></pre>
                <pre data-prefix="5"><code>php artisan migrate</code></pre>
                <pre data-prefix="6"><code>php artisan serve</code></pre>
            </div>
            <p class="text-sm text-gray-500 mt-2">Requires PHP ≥ 8.2 and Composer ≥ 2.x.</p>
        </div>

        <div>
            <h3 class="text-xl font-semibold mb-3">Requirements</h3>
            <ul class="list-disc pl-6 text-sm space-y-1">
                <li>PHP ≥ 8.2</li>
                <li>Composer ≥ 2.x</li>
                <li>Laravel 11.x</li>
                <li>MySQL or SQLite database</li>
                <li>OpenSSL for JWT</li>
            </ul>
        </div>
    </section>

    <footer class="text-center py-8 text-sm">
        © {{ date('Y') }} Refkinscallv — MIT Licensed
    </footer>
@endsection
