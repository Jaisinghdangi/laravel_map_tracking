<?php

use App\Http\Controllers\FavoriteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenController;

use Illuminate\Http\Request;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
use App\Models\User;
 


Route::get('/', function () {
    return view('welcome');
    

});

// Route::resource('favorites', FavoriteController::class);
Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');

Route::post('/favorites', [FavoriteController::class, 'store'])->name('favorites.store');

Route::middleware(['alreadyLoggedIn'])->group(function (){
    Route::get('/favorites/create', [FavoriteController::class, 'create'])->name('favorites.create');
    Route::get('/favorites/show/{favorite}', [FavoriteController::class, 'show'])->name('favorites.show');
    Route::get('/favorites/{favorite}/edit', [FavoriteController::class, 'edit'])->name('favorites.editMY');
    Route::put('/favorites/{favorite}', [FavoriteController::class, 'update'])->name('favorites.update');
    Route::delete('/favorites/{favorite}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

});


Route::get('/ragister', [AuthenController::class, 'ragister']);
Route::post('/ragister/save', [AuthenController::class, 'registerUser'])->name('register-user');

Route::get('/login', [AuthenController::class, 'login'])->name('auth.login');
Route::post('/login-user',[AuthenController::class, 'loginUser'])->name('login-user')->block($lockSeconds = 10, $waitSeconds = 10);
Route::get('/logout',[AuthenController::class, 'logout'])->name('logout');


Route::get('auto-complete-address', [FavoriteController::class, 'googleAutoAddress']);

Route::get('auto-complete-direction', [FavoriteController::class, 'googleAutoDirection']);

Route::get('tracking-route', [FavoriteController::class, 'googleAutotracking']);

Route::get('check-api', [FavoriteController::class, 'checkapi']);

Route::get('home-api', [FavoriteController::class, 'homeapi']);

Route::get('update-api', [FavoriteController::class, 'updateapi']);



///mailing forgot password links
Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');


Route::get('/send-test-email', function () { 
    Mail::raw('This is a test email.', function ($message) {
        $message->to('jaisinghdangi64@gmail.com')
                ->subject('Test Email');
    });

    return 'Test email sent!';
});  // this is check for that email sending msg or not


Route::get('/send-image-email', [ForgotPasswordController::class, 'sendImageEmail']); /// send image via email to user
Route::get('/send-pdf-email', [ForgotPasswordController::class, 'sendEmailWithPDF']);/// send PDF via email to user