<?php

use Illuminate\Support\Facades\Route;

//Route::get('/', [Admin\AuthController::class, 'home'])->name('home');

Route::name('admin.')->group(function () {

    Route::get('/', 'AuthController@login')->name('login');

   	Route::get('/login', 'AuthController@login')->name('login1');

    Route::post('/login','AuthController@do_login')->name('do_login');

    Route::get('/logout','AuthController@logout')->name('logout');



    Route::middleware('admin-auth')->group(function() {

    	Route::get('/dashboard','Dashboard@index')->name('dashboard');

        //auth route
        Route::get('/edit-profile','SettingController@Edit_profile')->name('edit-profile');
        Route::post('/update_profile','SettingController@update_profile')->name('update_profile');
        Route::get('/change-password','SettingController@change_password')->name('change-password');
        Route::post('/update_password','SettingController@update_password')->name('update_password');

        //category 
        Route::get('/category','CategoryController@index')->name('category');
        Route::post('/add-category','CategoryController@add_category')->name('add-category');
        Route::post('/edit-category','CategoryController@category_update')->name('edit-category');
        Route::delete('/delete-category','CategoryController@delete')->name('delete-category');

        //blogs
        Route::get('/blogs','BlogController@index')->name('blogs');
        Route::get('/add-blog','BlogController@add')->name('blog.add');
        Route::get('/edit-blog','BlogController@edit')->name('blog.edit');
        Route::post('/add-blog','BlogController@AddBlog')->name('blog.add.post');
        Route::post('/edit-blog','BlogController@EditBlog')->name('blog.edit.post');
        Route::delete('/delete-blog','BlogController@delete')->name('blog.delete');
        Route::put('/update-blog-order','BlogController@updateBlogOrder')->name('blog.order.update');
        Route::put('/update-blog-latest','BlogController@updateBlogLatest')->name('blog.latest.update');

        //contact request
        Route::get('/contact-request','ContactController@contactRequest')->name('contact-request');
        Route::get('/contact-address','ContactController@contactAddress')->name('contact-address');
        Route::post('/update-contact-address','ContactController@updateContactAddress')->name('update-contact-address');

        //home request
        Route::get('/home-page-banner','GeneralController@home_page_banner')->name('home-page-banner');
        Route::post('/home-page-banner-update','GeneralController@home_page_banner_update')->name('home-page-banner-update');
        Route::get('/home-extra-work-banner','GeneralController@home_extra_work_banner')->name('home-extra-work-banner');
        Route::post('/home-extra-work-banner-update','GeneralController@home_extra_work_banner_update')->name('home-extra-work-banner-update');
        Route::get('/social-link','GeneralController@social_link')->name('social-link');
        Route::post('/social-link-update','GeneralController@social_link_update')->name('social-link-update');
        Route::post('/editor-media','GeneralController@editor_media')->name('editor-media');
        Route::get('/news-letter','GeneralController@news_letter')->name('news-letter');

	});

});





