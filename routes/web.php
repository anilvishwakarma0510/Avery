<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['middleware' => 'remove-index'], function () {

    Route::group([
        'prefix'=>'admin',
        'namespace'=>'App\Http\Controllers\Admin'
    ], function () {
        require __DIR__ . '/admin.php';
    });

    Route::get('/', [Controllers\HomeController::class, 'home'])->name('home');
    Route::get('/terms-and-condition', [Controllers\HomeController::class, 'terms'])->name('terms-and-condition');
    Route::get('/privacy-policy', [Controllers\HomeController::class, 'privacyPolicy'])->name('privacy-policy');
    Route::get('/contact-us', [Controllers\HomeController::class, 'contact_us'])->name('contact-us');
    Route::get('/about-me', [Controllers\HomeController::class, 'about_me'])->name('about-me');
    Route::post('/contact-us', [Controllers\HomeController::class, 'contact_us_post'])->name('contact-us-post');
    Route::post('/subscribe-newsletter', [Controllers\HomeController::class, 'subscribe_newsletter'])->name('subscribe.newsletter');
    Route::get('/blog/{slug}', [Controllers\BlogController::class, 'blog_detail'])->name('blog.detail');
    Route::post('/add-blog-comment', [Controllers\BlogController::class, 'add_comment'])->name('add.blog.comment');
    Route::post('/reply-blog-comment', [Controllers\BlogController::class, 'reply_comment'])->name('reply.blog.comment');
    Route::post('/reply-blog-comment', [Controllers\BlogController::class, 'reply_comment'])->name('reply.blog.comment');
    Route::get('/get-blog-comment', [Controllers\BlogController::class, 'getBlogComment'])->name('get.blog.comment');
    Route::post('/blog-like-action', [Controllers\BlogController::class, 'blogLikeAction'])->name('blog.like.action');
    Route::get('/search', [Controllers\SearchController::class, 'index'])->name('blog.search');
    Route::get('/logout', [Controllers\AuthController::class, 'logout'])->name('logout');
    
    
    

    Route::group(['middleware' => ['guest']], function () {
        Route::get('/login', [Controllers\AuthController::class, 'login'])->name('login');
        Route::get('/registration', [Controllers\AuthController::class, 'registration'])->name('registration');
        Route::post('/sign-up', [Controllers\AuthController::class, 'signupSubmit'])->name('sign-up');
        Route::post('/login', [Controllers\AuthController::class, 'loginSubmit'])->name('loginSubmit');
        Route::get('/forgot-password', [Controllers\AuthController::class, 'forgot_password'])->name('forgot-password');
        Route::post('/forgot-password', [Controllers\AuthController::class, 'SendResetPasswordLink'])->name('send-reset-password-link');
        Route::get('/reset-password/{token}', [Controllers\AuthController::class, 'ResetPassword'])->name('reset-password');
        Route::post('/reset-password', [Controllers\AuthController::class, 'UpdatePassword'])->name('update-password');
    });

    
    Route::group(['middleware' => ['auth']], function () {
        //Route::get('/email-verification', [Controllers\UserController::class, 'emailPending'])->name('email-verification');
        //Route::get('/pending-verification', [Controllers\UserController::class, 'verificationPending'])->name('pending-verification');
        //Route::get('/resend-email-verification-link', [Controllers\UserController::class, 'resendEmailVerificationList'])->name('resend-email-verification-link');

        Route::get('/dashboard', [Controllers\UserController::class, 'dashboard'])->name('dashboard');
        Route::get('/change-password', [Controllers\UserController::class, 'changePassword'])->name('change-password');
        Route::get('/edit-profile', [Controllers\UserController::class, 'editProfile'])->name('edit-profile');
        Route::post('/update-profile', [Controllers\UserController::class, 'updateProfile'])->name('update-profile');
        Route::post('/update-password', [Controllers\UserController::class, 'updatePassword'])->name('update-password');

        Route::get('/chat-room', [Controllers\ChatRoomController::class, 'index'])->name('chat-room');
        Route::get('/get-personal-chat', [Controllers\ChatRoomController::class, 'getPersonChat'])->name('get-personal-chat');
        Route::get('/get-chat-message', [Controllers\ChatRoomController::class, 'GetCatMessage'])->name('get-chat-message');
        Route::get('/get-chat-users', [Controllers\ChatRoomController::class, 'GetUserList'])->name('get-chat-users');
        Route::post('/chatroom-helpful-action', [Controllers\ChatRoomController::class, 'commentHelpFulAction'])->name('chatroom.helpful.action');
        Route::post('/send-message', [Controllers\ChatRoomController::class, 'SendMessage'])->name('send-message');
        
        
        Route::get('/get-chatroom-blog-list', [Controllers\ChatRoomController::class, 'getChatRoomBlogList'])->name('get-chatroom-blog-list');

    });
    

});
