<?php

namespace App\Exceptions;

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof QueryException) {
            // Check if the exception indicates a foreign key constraint violation
            if ($exception->errorInfo[1] == 1451 && $this->isDeleteOperation($exception)) {
                if ($request->ajax()) {
                    return response()->json(['error' => 'Unable to delete the record due to existing dependencies. Please remove associated records before deleting this item.'], 500);
                } else {
                    return redirect()->back()->withError('Unable to delete the record due to existing dependencies. Please remove associated records before deleting this item.');
                }
            }
        }

        return parent::render($request, $exception);
    }

    protected function isDeleteOperation(QueryException $exception)
    {
        // Check if the SQL statement in the exception message indicates a DELETE operation
        return strpos($exception->getMessage(), 'SQLSTATE[23000]: Integrity constraint violation: 1451 Cannot delete or update') !== false;
    }
}
