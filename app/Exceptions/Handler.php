<?php


namespace App\Exceptions;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;   

public function render($request, Throwable $e) {
if ($request->is('api/*')) {
return response()->json([
'status' => 'error',
'data' => null,
'message' => $e->getMessage(),
], method_exists($e,'getStatusCode') ?
$e->getStatusCode() :
500);
}
return parent::render($request, $e);
}