<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InjectFilamentAssets
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Only inject for admin pages and HTML responses
        if (! $request->is('admin*')) {
            return $response;
        }

        if (! $response instanceof Response) {
            return $response;
        }

        $content = $response->getContent();
        if (! is_string($content) || stripos($response->headers->get('Content-Type') ?? '', 'html') === false) {
            return $response;
        }

        // Prepare tags
        $cssTag = '<link rel="stylesheet" href="' . asset('css/filament-custom.css') . '" />';
        $chartJs = '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';
        $localJs = '<script src="' . asset('js/filament-widgets.js') . '"></script>';

        // Inject CSS into head and scripts before closing body
        $content = preg_replace('#</head>#i', $cssTag . "\n</head>", $content, 1);
        $content = preg_replace('#</body>#i', $chartJs . "\n" . $localJs . "\n</body>", $content, 1);

        $response->setContent($content);

        return $response;
    }
}
