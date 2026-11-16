<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Welcome\PortfolioController;
use App\Http\Controllers\Admin\PortfolioController as AdminPortfolioController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\AdminController;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Portfolio website routes
|--------------------------------------------------------------------------
| The old ecommerce routes are backed up in storage/ecommerce-backup/web.php
*/

Route::fallback(function () {
    return Inertia::render('Error', ['status' => 404, 'message' => 'Page not found.'])
        ->toResponse(request())->setStatusCode(404);
});

// ---------------- Public site ----------------
Route::get('/', [PortfolioController::class, 'home'])->name('index');
Route::get('/projects', [PortfolioController::class, 'projects'])->name('projects');
Route::get('/projects/{slug}', [PortfolioController::class, 'projectShow'])->name('projectShow');
Route::get('/blog', [PortfolioController::class, 'blogs'])->name('blogs');
Route::get('/blog/category/{slug}', fn () => redirect()->route('blogs'))->name('blogCategory');
Route::get('/blog/{slug}',[PortfolioController::class, 'blogShow'])->name('blogView');
Route::get('/image/{template?}/{image?}', [\App\Http\Controllers\Welcome\WelcomeController::class, 'imageView2'])->name('imageView2');
Route::post('/contact',[PortfolioController::class, 'contact'])->name('contact')->middleware('throttle:5,1');

// ---------------- Auth ----------------
Route::any('/login', [AuthController::class, 'login'])->name('login');
Route::post('/log-out', [AuthController::class, 'logout'])->name('logout');

// ---------------- Admin ----------------
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'role:admin', 'permission']], function () {

    Route::get('/dashboard', [AdminPortfolioController::class, 'dashboard'])->name('dashboard');
    Route::any('/my-profile', [AdminController::class, 'myProfile'])->name('myProfile');

    // Portfolio content
    Route::get('/portfolio/settings', [AdminPortfolioController::class, 'settings'])->name('portfolio.settings');
    Route::post('/portfolio/settings', [AdminPortfolioController::class, 'settingsUpdate'])->name('portfolio.settingsUpdate');

    Route::get('/portfolio/messages', [AdminPortfolioController::class, 'messages'])->name('portfolio.messages');
    Route::get('/portfolio/messages/{id}', [AdminPortfolioController::class, 'messageShow'])->name('portfolio.messageShow');
    Route::delete('/portfolio/messages/{id}', [AdminPortfolioController::class, 'messageDelete'])->name('portfolio.messageDelete');

    $sections = 'skills|services|projects|experiences|testimonials|achievements';
    Route::get('/portfolio/{section}', [AdminPortfolioController::class, 'index'])->name('portfolio.index')->where('section', $sections);
    Route::get('/portfolio/{section}/create', [AdminPortfolioController::class, 'create'])->name('portfolio.create')->where('section', $sections);
    Route::post('/portfolio/{section}', [AdminPortfolioController::class, 'store'])->name('portfolio.store')->where('section', $sections);
    Route::get('/portfolio/{section}/{id}/edit', [AdminPortfolioController::class, 'edit'])->name('portfolio.edit')->where('section', $sections);
    Route::put('/portfolio/{section}/{id}', [AdminPortfolioController::class, 'update'])->name('portfolio.update')->where('section', $sections);
    Route::delete('/portfolio/{section}/{id}', [AdminPortfolioController::class, 'destroy'])->name('portfolio.destroy')->where('section', $sections);

    // Media library
    Route::get('/medias', [AdminController::class, 'medies'])->name('medies');
    Route::post('/medias/create', [AdminController::class, 'mediesCreate'])->name('mediesCreate');
    Route::match(['get', 'post'], '/medias/edit/{id}', [AdminController::class, 'mediesEdit'])->name('mediesEdit');
    Route::get('/medies/delete/{id}', [AdminController::class, 'mediesDelete'])->name('mediesDelete');

    // Blog posts
    Route::get('/posts/comments/all', [PostsController::class, 'postsCommentsAll'])->name('postsCommentsAll');
    Route::get('/posts/comments/post/{id}', [PostsController::class, 'postsComments'])->name('postsComments');
    Route::any('/posts/comments/{action}/{id}', [PostsController::class, 'postsCommentsAction'])->name('postsCommentsAction');
    Route::get('/posts/categories', [PostsController::class, 'postsCategories'])->name('postsCategories');
    Route::any('/posts/categories/{action}/{id?}', [PostsController::class, 'postsCategoriesAction'])->name('postsCategoriesAction');
    Route::get('/posts/tags', [PostsController::class, 'postsTags'])->name('postsTags');
    Route::any('/posts/tags/{action}/{id?}', [PostsController::class, 'postsTagsAction'])->name('postsTagsAction');
    Route::get('/posts', [PostsController::class, 'posts'])->name('posts');
    Route::any('/posts/{action}/{id?}', [PostsController::class, 'postsAction'])->name('postsAction');

    // Admin users & roles
    Route::get('/users/admin/', [AdminController::class, 'usersAdmin'])->name('usersAdmin');
    Route::any('/users/admin/{action}/{id?}', [AdminController::class, 'usersAdminAction'])->name('usersAdminAction');
    Route::get('/users/roles', [AdminController::class, 'userRoles'])->name('userRoles');
    Route::any('/users/roles/{action}/{id?}', [AdminController::class, 'userRoleAction'])->name('userRoleAction');

    // App settings (general / mail / social)
    Route::get('/setting/{type}', [AdminController::class, 'setting'])->name('setting');
    Route::post('/setting/{type}/update', [AdminController::class, 'settingUpdate'])->name('settingUpdate');
});
