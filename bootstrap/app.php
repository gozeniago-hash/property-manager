<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\TrustProxies;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Render (and most cloud hosts) terminate HTTPS at a proxy and forward
        // plain HTTP to the app. Without this, Laravel thinks every request is
        // insecure and generates http:// links (e.g. for the stylesheet),
        // which browsers then block as mixed content on an https:// page.
        $middleware->trustProxies(at: '*', headers: Request::HEADER_X_FORWARDED_FOR |
            Request::HEADER_X_FORWARDED_HOST |
            Request::HEADER_X_FORWARDED_PORT |
            Request::HEADER_X_FORWARDED_PROTO);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        // A logged-out visit to a tenant-portal page should bounce to the
        // tenant login page, not the property-manager login page.
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if (in_array('tenant', $e->guards(), true)) {
                return redirect()->guest(route('tenant.login'));
            }
        });
    })->create();
