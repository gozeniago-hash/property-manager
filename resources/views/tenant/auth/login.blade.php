<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tenant Login - {{ config('app.name', 'Property Manager') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="font-sans bg-[#f1f5f9] min-h-screen flex items-center justify-center">
    <div class="w-full max-w-sm bg-white rounded-xl shadow-sm border border-[#e2e8f0] p-8">
        <div class="text-center mb-6">
            <div class="flex justify-center mb-2"><x-icon name="mark" class="w-8 h-8 text-[#4f46e5]" /></div>
            <h1 class="text-lg font-semibold text-[#0f172a]">Tenant Portal</h1>
            <p class="text-sm text-[#64748b]">View your bills and raise concerns</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-[#fbf0f2] border border-[#e9bcc4] text-[#5c1a26] px-4 py-3 text-sm">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('tenant.login') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-[#1e293b] mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">
            </div>
            <div>
                <label class="block text-sm font-medium text-[#1e293b] mb-1">Password</label>
                <input type="password" name="password" required
                       class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">
            </div>
            <label class="flex items-center gap-2 text-sm text-[#475569]">
                <input type="checkbox" name="remember" class="rounded border-[#cbd5e1]">
                Remember me
            </label>
            <button type="submit"
                    class="w-full bg-[#4f46e5] hover:bg-[#4338ca] text-white font-medium rounded-lg px-4 py-2 text-sm transition">
                Log in
            </button>
        </form>

        <p class="text-center text-xs text-[#94a3b8] mt-6">
            Don't have portal access yet? Ask your property manager.
        </p>
        <p class="text-center text-xs text-[#94a3b8] mt-2">
            <a href="{{ route('login') }}" class="hover:underline">Property manager login</a>
        </p>
    </div>
</body>
</html>
