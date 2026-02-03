<?php

namespace App\Exceptions;

use DomainException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (DomainException $e, $request) {

            // Para requests Inertia / API
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $e->getMessage(),
                ], 422);
            }

            // Para requests web normais
            return redirect()
                ->back()
                ->withErrors([
                    'error' => $e->getMessage(),
                ]);
        });
    }
}
