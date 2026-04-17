<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .logo-float {
            animation: logoFloat 4s ease-in-out infinite;
        }

        .card-rise {
            transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
        }

        .card-rise:hover {
            transform: translateY(-6px);
        }

        .soft-fade {
            animation: softFade .5s ease-out;
        }

        @keyframes logoFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-4px); }
        }

        @keyframes softFade {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="min-h-screen bg-white text-slate-900 antialiased">
    <div class="min-h-screen bg-[radial-gradient(circle_at_top_left,rgba(239,68,68,0.08),transparent_30%),radial-gradient(circle_at_bottom_right,rgba(220,38,38,0.05),transparent_32%)]">
        <header class="sticky top-0 z-50 border-b border-slate-200 bg-white/90 backdrop-blur">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-4">
                    <div class="logo-float flex h-14 w-14 items-center justify-center rounded-2xl bg-red-600 shadow-lg shadow-red-200">
                        <svg viewBox="0 0 64 64" class="h-8 w-8 fill-white" aria-hidden="true">
                            <path d="M16 46V18h18c8.837 0 16 7.163 16 16s-7.163 12-16 12H16zm8-8h10c4.418 0 8-1.79 8-4s-3.582-8-8-8H24v12z"/>
                        </svg>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-red-600">School Project Showcase</p>
                        <h1 class="text-2xl font-black tracking-tight text-slate-900">Advanced Search System</h1>
                    </div>
                </div>

                <div class="hidden items-center gap-3 rounded-2xl border border-red-100 bg-white px-3 py-2 shadow-sm sm:flex">
                    <div class="relative h-12 w-12 overflow-hidden rounded-xl border border-red-200 bg-red-50">
                        <img
                            src="{{ asset('images/my-school-logo.jpg') }}"
                            alt="School Logo"
                            class="h-full w-full object-cover"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                        >
                        <div class="absolute inset-0 hidden items-center justify-center bg-red-600 text-[10px] font-black tracking-widest text-white">
                            LOGO
                        </div>
                    </div>

                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-red-600">Lincoln University College</p>
                        <p class="text-sm font-semibold text-slate-800">Learn. Lead. Succeed.</p>
                    </div>
                </div>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8 soft-fade">
            @yield('content')
        </main>
    </div>
</body>
</html>