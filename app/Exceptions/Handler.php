<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (ModelNotFoundException $e, $request) {
            if ($e->getModel() === 'Modules\\Product\\Entities\\Item') {
                return response()->json([
                    'success' => false,
                    'message' => 'The requested product could not be found.',
                ], 404);
            }

            // Default 404 response for other models
            return response()->json([
                'success' => false,
                'message' => 'The requested resource could not be found.',
            ], 404);
        });

        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
