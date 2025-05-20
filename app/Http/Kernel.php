<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middlewareGroups = [
        'web' => [
            // OUTROS MIDDLEWARES...

            \App\Http\Middleware\VerifyCsrfToken::class, // ✅ ESSA LINHA PRECISA EXISTIR
        ],
    ];
}
