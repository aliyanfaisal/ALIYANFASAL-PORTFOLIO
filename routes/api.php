<?php

use App\Http\Controllers\Api\BlogPostController;
use Illuminate\Support\Facades\Route;

Route::post('/blog-posts', [BlogPostController::class, 'store'])
    ->middleware('blog.api.token')
    ->name('api.blog-posts.store');
