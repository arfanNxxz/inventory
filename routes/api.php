<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;

// [SOAL 4] Route Publik - Register & Login (Bisa diakses tanpa token)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
// [SOAL 4] Route Terproteksi dengan Middleware auth:sanctum
Route::middleware(['auth:sanctum'])->group(function() {
    
    // Route resource untuk categories dan items (Fungsi destroy/delete sengaja dikecualikan dulu)
    Route::apiResource('categories', CategoryController::class)->except(['destroy']);
    Route::apiResource('items', ItemController::class)->except(['destroy']);
    // [SOAL 5] Khusus Route DELETE dikunci ekstra dengan Custom Middleware 'role:admin'
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->middleware('role:admin');
    Route::delete('/items/{id}', [ItemController::class, 'destroy'])->middleware('role:admin');
    
});