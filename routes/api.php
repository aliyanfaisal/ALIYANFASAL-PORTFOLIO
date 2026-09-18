<?php

use App\Http\Controllers\Api\AutomationLogController;
use App\Http\Controllers\Api\BlogPostController;
use App\Http\Controllers\Api\LinkedInPostController;
use Illuminate\Support\Facades\Route;

Route::post('/blog-posts', [BlogPostController::class, 'store'])
    ->middleware('blog.api.token')
    ->name('api.blog-posts.store');

Route::get('/blog-posts/recent-images', [BlogPostController::class, 'recentImages'])
    ->middleware('blog.api.token')
    ->name('api.blog-posts.recent-images');

Route::post('/automation-logs', [AutomationLogController::class, 'store'])
    ->middleware('blog.api.token')
    ->name('api.automation-logs.store');

Route::post('/linkedin-post', [LinkedInPostController::class, 'store'])
    ->middleware('linkedin.api.token')
    ->name('api.linkedin-post.store');
