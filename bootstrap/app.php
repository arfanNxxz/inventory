<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        
        // Cara Pamungkas: Paksa khusus untuk ValidationException di API agar jadi 500
        $exceptions->render(function (ValidationException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => 'error',
                    'data' => null,
                    // Mengambil pesan error validasi pertama yang muncul
                    'message' => $e->validator->errors()->first(), 
                ], 500); // Paksa 500 di sini
            }
        });

    })->create();
    