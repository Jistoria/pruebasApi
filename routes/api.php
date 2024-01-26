<?php

use App\Http\Controllers\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\UserController;
use App\Models\Image;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('/upload', [ImageController::class, 'upload'])->name('image.upload');

Route::get('/juan', function () {
    return response()->json(['message'=> 'Hola']);
})->name('juan');

Route::get('/get_image',[ImageController::class, 'getImage'])->name('image.get');
Route::get('/image/{filename}',[ImageController::class, 'viewImage'])->name('view.image');
Route::delete('/images/{id}', [ImageController::class, 'deleteImage'])->name('delete.image');

Route::post('/register_user', [UserController::class,'register'])->name('user.register');
Route::post('/login_user', [UserController::class,'login'])->name('login');
Route::get('/email/verify/{id}/{hash}', [UserController::class, 'verify'])->name('verification.verify');

Route::group(['middleware'=>['auth:sanctum']],function(){
    Route::get('/get_notifications',[UserController::class,'userNotifications'])->name('user.notifications');
    Route::get('/get_user',[UserController::class, 'getUser']);
    Route::post('/logout',[UserController::class, 'logout']);
    Route::post('/create_comment', [CommentController::class,'commentCreate']);

});


