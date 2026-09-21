<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Dashboard' }} - {{ config('app.name', 'Property Manager') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-slate-50 text-slate-800 antialiased">
<div class="min-h-screen flex">
    <aside class="w-60 shrink-0 bg-slate-900 text-slate-200 flex flex-col">
        <div class="px-5 py-5 text-lg font-semibold text-white border-b border-slate-800">
            🏠 {{ config('app.name', 'Property Manager') }}
        </div>
        <nav class="flex-1 px-3 py-4 space-y-1 text-sm">
            @php
                $navItems = [
                    ['route' => 'dashboard', 'label' => 'Dashboard', 'icon' => '📊'],
                    ['route' => 'properties.index', 'label' => 'Properties', 'icon' => '🏢'],
                    ['route' => 'units.index', 'label' => 'Units', 'icon' => '🚪'],
                    ['route' => 'tenants.index', 'label' => 'Tenants', 'icon' => '👤'],
                    ['route' => 'bills.index', 'label' => 'Bills & Payments', 'icon' => '🧾'],
                    ['route' => 'concerns.index', 'label' => 'Tenant Concerns', 'icon' => '⚠️'],
                ];
            @endphp
            @foreach ($navItems as $item)
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-2 rounded-lg px-3 py-2 transition
                          {{ request()->routeIs($item['route']) || request()->routeIs(explode('.', $item['route'])[0].'.*')
                                ? 'bg-blue-600 text-white'
                                : 'hover:bg-slate-800 text-slate-300' }}">
                    <span>{{ $item['icon'] }}</span>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>
        <div class="px-3 py-4 border-t border-slate-800 text-sm">
            @auth
                <div class="px-3 pb-2 text-slate-400 truncate">{{ auth()->user()->email }}</div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left rounded-lg px-3 py-2 hover:bg-slate-800 text-slate-300">
                        ↩ Log out
                    </button>
                </form>
            @endauth
        </div>
    </aside>

    <div class="flex-1 flex flex-col min-w-0">
        <header class="bg-white border-b border-slate-200 px-6 py-4">
            <h1 class="text-xl font-semibold text-slate-900">{{ $title ?? 'Dashboard' }}</h1>
        </header>

        <main class="flex-1 p-6">
            @if (session('status'))
                <div class="mb-4 rounded-lg bg-green-50 border border-green-200 text-green-800 px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-800 px-4 py-3 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>
</div>
</body>
</html>
