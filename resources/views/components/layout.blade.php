<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Dashboard' }} - {{ config('app.name', 'Property Manager') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="font-sans bg-[#f8fafc] text-[#1e293b] antialiased">
<div class="min-h-screen flex">
    <aside class="w-60 shrink-0 bg-[#0f172a] text-[#cbd5e1] flex flex-col">
        <div class="px-5 py-5 text-lg font-semibold text-white border-b border-[#1e293b] flex items-center gap-2">
            <x-icon name="mark" class="w-5 h-5" />
            {{ config('app.name', 'Property Manager') }}
        </div>
        <nav class="flex-1 px-3 py-4 space-y-1 text-sm">
            @php
                $navItems = [
                    ['route' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'dashboard'],
                    ['route' => 'properties.index', 'label' => 'Properties', 'icon' => 'properties'],
                    ['route' => 'units.index', 'label' => 'Units', 'icon' => 'units'],
                    ['route' => 'tenants.index', 'label' => 'Tenants', 'icon' => 'tenants'],
                    ['route' => 'bills.index', 'label' => 'Bills & Payments', 'icon' => 'bills'],
                    ['route' => 'concerns.index', 'label' => 'Tenant Concerns', 'icon' => 'concerns'],
                ];
            @endphp
            @foreach ($navItems as $item)
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-2 rounded-lg px-3 py-2 transition
                          {{ request()->routeIs($item['route']) || request()->routeIs(explode('.', $item['route'])[0].'.*')
                                ? 'bg-[#4f46e5] text-white'
                                : 'hover:bg-[#1e293b] text-[#cbd5e1]' }}">
                    <x-icon :name="$item['icon']" />
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>
        <div class="px-3 py-4 border-t border-[#1e293b] text-sm">
            @auth
                <div class="px-3 pb-2 text-[#94a3b8] truncate">{{ auth()->user()->email }}</div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2 text-left rounded-lg px-3 py-2 hover:bg-[#1e293b] text-[#cbd5e1]">
                        <x-icon name="logout" />
                        Log out
                    </button>
                </form>
            @endauth
        </div>
    </aside>

    <div class="flex-1 flex flex-col min-w-0">
        <header class="bg-white border-b border-[#e2e8f0] px-6 py-4">
            <h1 class="text-xl font-semibold text-[#0f172a]">{{ $title ?? 'Dashboard' }}</h1>
        </header>

        <main class="flex-1 p-6">
            @if (session('status'))
                <div class="mb-4 flex items-start gap-2 rounded-lg bg-[#f1f5f9] border border-[#e2e8f0] text-[#1e293b] font-medium px-4 py-3 text-sm">
                    <svg class="w-4 h-4 flex-shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12l5 5L20 6"/></svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-[#fbf0f2] border border-[#e9bcc4] text-[#5c1a26] px-4 py-3 text-sm">
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
