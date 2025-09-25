<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/',function(){
    return "Hello";
});

// Route::post('/save', function(Request $request){
//     return $request;
// });


// For saving a new post
Route::post('/save', [PostController::class, 'store'])->name('api.posts.store');
// For fetching a post to edit
Route::get('/posts/{id}', [PostController::class, 'show'])->name('api.posts.show');

Route::get('/posts', [PostController::class, 'findAllNameAndId'])->name('api.posts.findAllNameAndId');

