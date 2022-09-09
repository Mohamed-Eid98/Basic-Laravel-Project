<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\BlogController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Home\AboutController;
use App\Http\Controllers\Home\PortfolioController;
use App\Http\Controllers\Home\HomeSliderController;
use App\Http\Controllers\home\BlogCategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('frontend.index');
});


// Admin 

Route::controller(AdminController::class)->group(function(){
    Route::get('admin/logout', 'destroy')->name('admin.logout');
    Route::get('admin/profile', 'profile')->name('admin.profile');
    Route::get('edit/profile', 'EditProfile')->name('edit.profile');
    Route::post('edit/profile', 'StoreProfile')->name('store.profile');
    Route::get('change/password', 'ChangePassword')->name('change.password');
    Route::post('change/password', 'UpdatePassword')->name('update.password');
});

//Home slide All Routes
Route::controller(HomeSliderController::class)->group(function(){
    Route::get('home/slide', 'HomeSlider')->name('home.slide');
    Route::post('home/slide', 'UpdateSlider')->name('update.slide');
    
});

//About Page All Routes

Route::controller(AboutController::class)->group(function(){
    Route::get('about/page', 'AboutPage')->name('about.page');
    Route::post('about/page', 'UpdateAbout')->name('update.about');
    Route::get('/about', 'HomeAbout')->name('home.about');
    Route::get('/about/multi/image', 'AboutMultiImage')->name('about.multi.page');
    Route::post('store/multi/image', 'StoreMultiImage')->name('store.multi.image');
    Route::get('all/multi/image', 'AllMultiImage')->name('all.multi.image');
    Route::get('edit/multi/image/{id}', 'editMultipleImage')->name('edit.multiple.image');
    Route::post('update/multi/image/', 'updateMultipleImage')->name('update.multi.image');
    Route::get('/delete/multi/image/{id}', 'DeleteMultiImage')->name('delete.multi.image');

    
});

// Portfolio All Routes

Route::controller(PortfolioController::class)->group(function(){
    Route::get('All/Portfolio' , 'AllPortfolio')->name('all.portfolio');
    Route::get('Add/Portfolio' , 'AddPortfolio')->name('add.portfolio');
    Route::post('store/Portfolio' , 'StorePortfolio')->name('store.portfolio');
    Route::get('delete/Portfolio{id}' , 'deletePortfolio')->name('delete.portfolio.image');
    Route::get('edit/Portfolio{id}' , 'EditPortfolio')->name('edit.portfolio');
    Route::post('update/Portfolio' , 'UpdatePortfolio')->name('update.protfolio');
    Route::get('portfolio/details{id}' , 'PortfolioDetails')->name('portfolio.details');

});

Route::controller(BlogCategoryController::class)->group(function(){
    Route::get('all/blog/category' , 'AllBlogCategory')->name('all.blog.category');
    Route::get('add/blog/category' , 'AddBlogCategory')->name('add.blog.category');
    Route::post('add/blog/category' , 'StoreBlogCategory')->name('store.blog.category');
    Route::get('add/blog/category{id}' , 'EditBlogCategory')->name('edit.blog.category');
    Route::post('update/blog/category{id}' , 'UpdateBlogCategory')->name('update.blog.category');
    Route::get('delete/blog/category{id}' , 'DeleteBlogCategory')->name('delete.blog.category');

});

// All Blog Route 
Route::controller(BlogController::class)->group(function(){
    Route::get('all/blog/' , 'AllBlog')->name('all.blog');
    Route::get('add/blog/' , 'AddBlog')->name('add.blog');
    Route::post('store/blog/' , 'StoreBlog')->name('store.blog');
    Route::get('edit/blog/{id}' , 'EditBlog')->name('edit.blog');
    Route::post('update/blog/{id}' , 'UpdateBlog')->name('update.blog');
    Route::get('delete/blog/{id}' , 'DeleteBlog')->name('delete.blog');


});

Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
